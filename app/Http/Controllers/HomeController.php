<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\promo;
use App\Models\product;
use App\Models\product_payments;
use App\Models\payment;
use App\Models\product_details;
use App\Models\family_breakdown;
use App\Models\notifications;
use App\Models\cardDetail;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyMail;
use Illuminate\Support\Facades\Response;
use Config;

use DB;
use Session;
use Exception;
use Illuminate\Contracts\Session\Session as SessionSession;

class HomeController extends Controller
{
    public function redirect()
    {

        if (session('prod_id')) {
            $id = Session::get('prod_id');


            $data = product::find($id);
           
            $promo = promo::where('employee_id', '=', $id)->where('active_until', '>=', date('Y-m-d'))->get();
            $ppay = product_payments::where('destination_id', '=', $id)->first();
            // $proddet = product_details::where('product_id', '=', $id)->get();

            session()->forget('prod_id');
            return view('user.package', compact('data', 'ppay', 'promo'));
            //   return \Redirect::route('product', $idd);

        } else {
            // $ppay = product_payments::where('destination_id', '=', $id)->first();
            $package = DB::table('destinations')->orderBy(DB::raw('FIELD(name, "Poland", "Czech", "Malta", "Canada", "Germany")'))->get();
            // $package = product::all()->sortBy(DB::raw('FIELD(product_name, "Czech", "Poland", "Malta", "Canada", "Germany")'));
            $promo = promo::where('active_until', '>=', date('Y-m-d'))->get();

            return view('user.home', compact('package', 'promo'));
        }
    }

    public function index()
    {
      

        $package = DB::table('destinations')->orderBy(DB::raw('FIELD(name, "Poland", "Czech", "Malta", "Canada", "Germany")'))->get();
        $promo = promo::where('active_until', '>=', date('Y-m-d'))->get();

        return view('user.home', compact('package', 'promo'));
    }

    public function packageType($productId, Request $request)
    {
        Session::forget('packageType');
        Session::forget('myproduct_id');
        Session::forget('mySpouse');
        Session::forget('myKids');

        if (isset($request->parents)) {
            Session::put('mySpouse', $request['parents']);
            Session::put('myKids', $request['kid']);
        }

        Session::put('myproduct_id', $productId);
        $data = product::find($productId);

        if (Session::has('mySpouse')) {
            if (Session::get('mySpouse') == "yes") {
                $parentt = 2;
            } else {
                $parentt = 1;
            }

            if (Session::get('myKids') == 0 || Session::get('myKids') == "none" || Session::get('myKids') == 5 || Session::get('myKids') == null) {

                $kids = 1;
            } else {
                $kids = Session::get('myKids');
            }

            $famdet = family_breakdown::where('destination_id', '=', $productId)
                ->where('pricing_plan_type', 'FAMILY PACKAGE')
                ->where('no_of_parent', $parentt)
                ->where('no_of_children', $kids)

                ->first();
            if ($request->response == 1) {
                return $famdet;
            }
            // dd($famdet);
        } else {
            $famdet = family_breakdown::where('destination_id', '=', $productId)->where('pricing_plan_type', 'FAMILY PACKAGE')->first();
       
        }
   
      
        $proddet = family_breakdown::where('destination_id', '=', $productId)->where('pricing_plan_type', 'BLUE COLLAR JOBS')->get();
        $whiteJobs = family_breakdown::where('destination_id', '=', $productId)->where('pricing_plan_type', 'WHITE COLLAR JOBS')->get();
        $canadaOthers = family_breakdown::where('destination_id', '=', $productId)->whereIn('pricing_plan_type', array('Express Entry', 'Study Permit'))->get();
        return view('user.package-type', compact('proddet', 'famdet', 'productId', 'whiteJobs', 'data','canadaOthers'));
    }

    public function product(Request $request)
    {

        Session::put('packageType', $request->myPack);
        $id = Session::get('myproduct_id');

        session()->forget('totalCost');
        Session::put('totalCost', $request->cost);
        Session::put('fam_id', $request->fam_id);


        $data = product::find($id);
        $promo = promo::where('employee_id', '=', $id)->where('active_until', '>=', date('Y-m-d'))->get();

        if (Session::has('mySpouse') && Session::get('packageType') == "FAMILY PACKAGE") {
            if (Session::get('mySpouse') == "yes") {
                $parentt = 2;
            } else {
                $parentt = 1;
            }

            if (Session::get('myKids') == 0 || Session::get('myKids') == "none" || Session::get('myKids') == 5 || Session::get('myKids') == null) {

                $kids = 1;
            } else {
                $kids = Session::get('myKids');
            }
    
            $ppay = family_breakdown::where('destination_id', '=', $id)
                ->where('pricing_plan_type', '=', Session::get('packageType'))
                ->where('no_of_parent', '=', $parentt)
                ->where('no_of_children', '=', $kids)
                ->first();
        } else {
            $ppay = family_breakdown::where('destination_id', '=', $id)
                ->where('pricing_plan_type', '=', Session::get('packageType'))
                // ->where('family_sub_id', '=', Session::get('fam_id'))      
                ->first();
        }
        // dd($ppay);
        // $proddet = product_details::where('product_id', '=', $id)->get();

        session()->forget('prod_id');
        return view('user.package', compact('data', 'ppay', 'promo'));
    }


    public function signature(Request $request, $id)
    {
        if (Auth::id()) {
            // Session::put('myproduct_id', $id);
            Session::put('mypay_option', $request->payall);
            $data = product::find($id);
            return view('user.signature', compact('data'));
        } else {
            return redirect()->back()->with('message', 'You are not authorized');
        }
    }

    public function upload(Request $request)
    {
    if (Auth::id()) {
        list($part_a, $image_parts) = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $part_a);
        $image_type = $image_type_aux[1];
        $signate = time() . '.'.$image_type;
        $signature = user::find(Auth::user()->id);
        $signature->addMediaFromBase64($request->signed)->usingFileName($signate)->toMediaCollection(User::$media_collection_main_signture);

        $signature->save();

        if (Session::get('mySpouse')=="yes") {
            $is_spouse = 1;
        } else {
            $is_spouse = 0;
        }

        if(Session::has('myKids'))
        {
            $children = Session::get('myKids');
        } else {
            $children = 0;
        }

        if(Session::has('myproduct_id'))
        {
            $pid  = Session::get('myproduct_id');
        } else {
            $pid = 1;
        }

        $datas = Applicant::where('client_id', Auth::id())
            ->where('destination_id', $pid)
            ->first();
        if ($datas === null) {
            $data = new applicant();
            $data->client_id = Auth::id();
            $data->destination_id = $pid;
            $data->work_permit_category = (Session::get('packageType')) ?? 'BLUE COLLAR';
            $data->application_stage_status = 1;
            $data->destination_id = $pid;
            $res = $data->save();
        } else {
            $datas->work_permit_category =  (Session::get('packageType')) ?? 'BLUE COLLAR';
            $datas->application_stage_status = 1;
            $datas->destination_id = $pid;
            $res = $datas->save();
        }

        User::where('id', Auth::id())
            ->update([
                'is_spouse' => $is_spouse,
                'children_count' => $children
            ]);

        if ($res) {

            Session::put('info', 'Signature is Successful!');
            Session::put('info_sub', 'Proceed to application');
            return true;

        } else {
            Session::put('failed', 'Oppss! Something went wrong.');
            return false;
            // return redirect()->back()->with('failed', 'Oppss! Something went wrong.');
        }
    } else {
        return false;
        // return redirect()->back()->with('message', 'You are not authorized');
    }
}

    public function signature_success($id)
    {
        if (Auth::id()) {
            $data = product::find($id);
            return view('user.signature-upload-success', compact('data'));
        } else {
            return redirect()->back()->with('message', 'You are not authorized');
        }
    }


    public function referal($id)
    {
        if (Auth::id()) {
            $data = product::find($id);
            return view('user.referal-details', compact('data'));
        } else {
            return redirect()->back()->with('message', 'You are not authorized');
        }
    }

    public function addreferal(Request $request)
    {
        if (Auth::id()) {
            $request->validate([
                'current_location' => 'required',
                'pid' => 'required'
            ]);

            $datas = applicant::where([
                ['user_id', '=', Auth::user()->id],
                ['product_id', '=', $request->pid],
            ])->first();
            if ($datas === null) {
                $data = new applicant;
                $data->referral_first_name = $request->referrer_first_name;
                $data->referral_last_name = $request->referrer_last_name;
                $data->coupon_code = $request->coupon_code;
                $data->current_residance_country = $request->current_location;
                $data->home_country = $request->nationality;
                $data->applicant_status = '1';
                $data->product_id = $request->pid;
                if (Auth::id()) {
                    $data->user_id = Auth::user()->id;
                    $data->first_name = Auth::user()->name;
                }
                $res = $data->save();
            } else {
                $datas->referral_first_name = $request->referrer_first_name;
                $datas->referral_last_name = $request->referrer_last_name;
                $datas->coupon_code = $request->coupon_code;
                $datas->current_residance_country = $request->current_location;
                $datas->home_country = $request->nationality;
                $datas->applicant_status = '1';
                $datas->product_id = $request->pid;
                if (Auth::id()) {
                    $datas->user_id = Auth::user()->id;
                    $datas->first_name = Auth::user()->name;
                }
                $res = $datas->save();
            }

            if ($res) {
                $applys = DB::table('applications')
                    ->where('product_id', '=', $request->pid)
                    ->where('user_id', '=', Auth::user()->id)
                    ->get();

                $applied = '0';
                foreach ($applys as $apply) {
                    $applied = $apply->applicant_status;
                }

                if ($applied == '1' || $applied == '0' || $applied == 'Pending') {
                    $msg = "Referral Saved Successfully!";
                    return \Redirect::route('payment', $request->pid)->with('info', $msg)->with('info_sub', 'Proceed to make payment.');
                } else {
                    return \Redirect::route('applicant', $request->pid)->with('failed', 'Payment Already Completed');
                }
            } else {
                return redirect()->back()->with('failed', 'Oppss! Something Went Wrong!');
            }
        } else {
            return redirect()->back()->with('failed', 'You are not authorized');
        }
    }

    public function myapplication()
    {
        if (Auth::id()) {
            $id = Auth::user()->id;

            \DB::statement("SET SQL_MODE=''");

            $complete = DB::table('applications')
            ->where('client_id', '=', Auth::user()->id)
            // ->whereNotIn('status',  ['APPLICATION_COMPLETED','VISA_REFUSED', 'APPLICATION_CANCELLED','REFUNDED'] )
            ->orderBy('id','desc')
            ->first();

            // {
            if($complete)
            {
              $app_id= $complete->id;
              $p_id= $complete->destination_id;
            //   $hasSpouse = $complete->is_spouse;
            //   $children = $complete->children_count;
             }
             else {
                $app_id= 0;
                $p_id= 0;
                // $hasSpouse = $complete->is_spouse;
                // $children = $complete->children_count;
             }

            if(isset($hasSpouse) && $hasSpouse == 1)
            {
                $yesSpouse = 2;
            } else {
                $yesSpouse = 1;
            }

            if(!isset($children)){
                $children =0;
            }

            $families = DB::table('pricing_plans')
                ->where('no_of_children', '=', $children)
                ->where('no_of_parent', '=', $yesSpouse)
                ->where('pricing_plan_type', '=', 'FAMILY PACKAGE')
                ->get();

            foreach ($families as $famili) {
                $famCode = $famili->id;
            }

            if (session()->get('myproduct_id') && session()->get('myproduct_id') == $p_id) {
            } else {
                Session::put('myproduct_id', $p_id);
            }

            if(isset($complete->work_permit_category)){
                $packageType = $complete->work_permit_category;
            }
            elseif (Session::has('packageType')) {
                $packageType = Session::get('packageType');
            } else {
                $packageType = ($complete->work_permit_category) ?? null;
            }

            if (Session::has('fam_id')) {
                $family_id = Session::get('fam_id');
            } else {

                if (isset($famCode)) {
                    $family_id = $famCode;
                } else {
                    $family_id = 0;
                }

            }

            $pays = DB::table('pricing_plans')
            ->join('applications', 'applications.destination_id', '=', 'pricing_plans.destination_id')
            ->select('pricing_plans.id', 'pricing_plans.pricing_plan_type', 'pricing_plans.total_price', 'pricing_plans.destination_id','pricing_plans.first_payment_price','pricing_plans.second_payment_price','pricing_plans.third_payment_price')
            ->where('pricing_plans.pricing_plan_type', '=', $packageType)
            ->where('applications.client_id', '=', $id)
            ->orderBy('pricing_plans.id')
                ->first();

// dd($pays);
            $paid = DB::table('payments')
                ->join('applications', 'payments.application_id', '=', 'applications.id')
                ->selectRaw('payments.*, applications.*, COUNT(payments.id) as count')

                ->where('applications.client_id', '=', $id)
                ->groupBy('payments.id')
                // ->groupBy('applicants.id')
                ->orderBy('applications.id', 'desc')
                // ->limit(1)
                ->first();

            $prod = DB::table('destinations')
                ->join('applications', 'destinations.id', '=', 'applications.destination_id')
                ->select('destinations.name', 'destinations.id')
                ->where('applications.client_id', '=', $id)
                ->groupBy('destinations.id')
                ->first();
// dd($prod);
            return view('user.myapplication', compact('paid', 'pays', 'prod'));
        } else {
            return redirect()->back()->with('message', 'You are not authorized');
        }
    }

    public function payment(Request $request)
    {
        $famCode = 0;
        if (Auth::id()) {
            Session::forget('haveCoupon');
            Session::forget('myDiscount');

            $complete = DB::table('applications')
                ->where('client_id', '=', Auth::user()->id)
                // ->whereNotIn('status',  ['APPLICATION_COMPLETED','VISA_REFUSED', 'APPLICATION_CANCELLED','REFUNDED'] )
                ->orderBy('id', 'desc')
                ->first();

                $app_id = $complete->id;
                $p_id = $complete->destination_id;
            
            $hasSpouse = Auth::user()->is_spouse;
            $children = Auth::user()->children_count;
            if ($hasSpouse == 1) {
                $yesSpouse = 2;
            } else {
                $yesSpouse = 1;
            }


            if (session()->get('myproduct_id')) {
            } else if (isset($request->id)) {
                Session::put('myproduct_id', $request->id);
            } else {
                Session::put('myproduct_id', $p_id);
            }

            $id = Session::get('myproduct_id');

            if (Session::has('payall')) {
                $payall = Session::get('payall'); //$request->payall;
            } else if (isset($request->payall)) {
                $payall = $request->payall;
            } else {
                $payall = 0;
            }

            if(isset($complete->work_permit_category) && $complete->third_payment_status =='PENDING') {
                $packageType = $complete->work_permit_category;
            }elseif (Session::has('packageType')) {
                $packageType = Session::get('packageType');
            } else {
                $packageType = $complete->work_permit_category;
            }

            $data = product::find(Session::get('myproduct_id'));

            $pays = DB::table('applications')
                ->select('applications.pricing_plan_id', 'applications.total_price', 'applications.total_paid', 'applications.first_payment_status','applications.second_payment_status','applications.third_payment_status')
                ->where('applications.client_id', '=', Auth::user()->id)
                ->where('applications.destination_id', '=', $id)
                // ->whereNotIn('status',  ['APPLICATION_COMPLETED','VISA_REFUSED', 'APPLICATION_CANCELLED','REFUNDED'] )
                ->limit(1)
                ->first();

            $pdet = DB::table('pricing_plans')
                ->where('destination_id', '=', Session::get('myproduct_id'))
                ->where('pricing_plan_type', '=', $packageType)
                ->first();

            return view('user.payment-form', compact('data', 'pdet', 'pays', 'payall'));
        } else {
            return redirect()->back()->with('message', 'You are not authorized');
        }
    }


    public static function invokeCurlRequest($type, $url, $headers, $post) 
    {
        try {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);		
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            if ($type == "POST") {
               
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                
            }
    
            $server_output = curl_exec ($ch);
            if($server_output === false) {
                throw new Exception(curl_error($ch), curl_errno($ch));

            }
            curl_close ($ch);
            
            return $server_output;
        } catch (Exception $e) {
            return $e->getMessage();
        }
		
		
	}

    public function addpayment(Request $request)
    {
        if (Auth::id()) {
            session()->forget('info');
            $amount = $request->totalpay;
            $id = Session::get('myproduct_id');

            $apply = DB::table('applications')
                ->where('destination_id', '=', $id)
                // ->whereNotIn('status',  ['APPLICATION_COMPLETED','VISA_REFUSED', 'APPLICATION_CANCELLED','REFUNDED'] )
                ->where('client_id', '=', Auth::user()->id)
                ->first();

                $applicant_id = $apply->id;

            $request->validate([
                'totaldue' => 'required',
                'totalpay' => 'numeric|gte:1000',
                'current_location' => 'required',
                'embassy_appearance' => 'required'
            ]);


                $thisPayment = $request->whichpayment;
                $thisVat = $request->vats;
                $thisPayment = $request->totaldue;
                $thisPaymentMade = $request->totalpay;
                if($request->discount>0) {
                    $thisDiscount = $request->discount;
                    $thisCode = $request->discount_code;
                } else {
                    $thisDiscount =0;
                    $thisCode ='';
                }
                $thisDay = date('Y-m-d');


                if ($request->totalpay == null || $request->totalpay == "" || $request->totalpay < 1000) {
                    $totalpay = 0;
                } else {
                    $totalpay = $request->totalpay;
                }
                // dd($request->vats);
                $outstand= $request->totalpay + $thisVat;

                if ($request->totaldue == $outstand) {
                    $whatsPaid = "Paid";
                } elseif ($request->totaldue > $outstand && $request->totalpay > 1000) {
                    $whatsPaid = "Partial";
                } else {
                    $whatsPaid = "Paid";
                    $overPay = $request->totalpay - $request->totaldue;
                }
                

                $haveSpouse =  Session::get('mySpouse');
                $kids =  Session::get('myKids');

                $rre = user::where([
                    ['id', '=', Auth::user()->id]
                ])->first();

                if ($rre === null) {
                    $rres = new user;
                    
                    $rres->country_of_residence =  $request->current_location;
                    // if( Session::has('mySpouse'))
                    // {
                    //     $rres->is_spouse = $haveSpouse;
                    //     $rres->children_count = $kids;
                    // }
                    $rres->save();
                } else {
                    $rre->country_of_residence =  $request->current_location;
                    // if( Session::has('mySpouse'))
                    // {
                    //     $rre->is_spouse = $haveSpouse;
                    //     $rre->children_count = $kids;
                    // }
                    $rre->save();
                }

                $ppd = payment::where([
                    ['application_id', '=', $applicant_id],
                    ['payment_type', '=', $request->whichpayment],
                ])->first();

                if ($ppd === null) {
                    $dat = new payment;
                    
                    $dat->payment_type = $request->whichpayment;
                    $dat->application_id = $applicant_id;
                    $dat->payment_date = $thisDay;
                    $dat->payable_amount = $request->totaldue;
                    $dat->paid_amount = $request->totalpay;
                    $dat->invoice_amount = $request->totalpay;
                    $dat->save();
                } else {
                    $ppd->payment_type = $request->whichpayment;
                    $ppd->application_id = $applicant_id;
                    $ppd->payment_date = $thisDay;
                    $ppd->payable_amount = $request->totaldue;
                    $ppd->paid_amount = $request->totalpay;
                    $ppd->invoice_amount = $request->totalpay;
                    $ppd->save();
                }
                
                // dd($re);
                $datas = applicant::where([
                    ['client_id', '=', Auth::user()->id],
                    ['destination_id', '=', $request->pid],
                ])->first();
                if ($datas === null) {
                    $data = new applicant;
                    $data->embassy_country = $request->embassy_appearance;
                    $data->pricing_plan_id = $request->ppid;

                    if($request->whichpayment =='First Payment')
                    {
                        $data->first_payment_price = $thisPayment;
                        $data->first_payment_paid = $thisPaymentMade;
                        $data->first_payment_vat = $thisVat;
                        $data->first_payment_discount = $thisDiscount;
                        $data->first_payment_status = $whatsPaid;
                        $data->status = 'WAITING_FOR_2ND_PAYMENT';
                        if($whatsPaid=='Partial')
                        {
                            $data->is_first_payment_partially_paid = 1;
                        }
                    } elseif($request->whichpayment =='Second Payment') {
                        $data->second_payment_price = $thisPayment;
                        $data->second_payment_paid = $thisPaymentMade;
                        $data->second_payment_vat = $thisVat;
                        $data->second_payment_discount = $thisDiscount;
                        $data->second_payment_status = $whatsPaid;
                        $data->status = 'WAITING_FOR_3RD_PAYMENT';
                        if($whatsPaid=='Partial')
                        {
                            $data->is_second_payment_partially_paid = 1;
                        }
                    } elseif($request->whichpayment =='Third Payment') {
                        $data->third_payment_price = $thisPayment;
                        $data->third_payment_paid = $thisPaymentMade;
                        $data->third_payment_vat = $thisVat;
                        $data->third_payment_discount = $thisDiscount;
                        $data->third_payment_status = $whatsPaid;
                        $data->status = 'WAITING_FOR_EMBASSY_APPEARANCE';
                        if($whatsPaid=='Partial')
                        {
                            $data->is_third_payment_partially_paid = 1;
                        }
                    } else {
                        $data->total_price = $thisPayment;
                        $data->total_paid = $thisPaymentMade;
                        $data->total_vat = $thisVat;
                        $data->total_discount = $thisDiscount;
                    }

                    $data->coupon_code = $thisCode;
                    $data->application_stage_status = 2;

                    $res = $data->save();
                } else {
                    $datas->embassy_country = $request->embassy_appearance;
                    $datas->pricing_plan_id = $request->ppid;

                    if($request->whichpayment =='First Payment')
                    {
                        $datas->first_payment_price = $thisPayment;
                        $datas->first_payment_paid = $thisPaymentMade;
                        $datas->first_payment_vat = $thisVat;
                        $datas->first_payment_discount = $thisDiscount;
                        $datas->first_payment_status = $whatsPaid;
                        if($whatsPaid=='Partial')
                        {
                            $datas->is_first_payment_partially_paid = 1;
                        }
                    } elseif($request->whichpayment =='Second Payment') {
                        $datas->second_payment_price = $thisPayment;
                        $datas->second_payment_paid = $thisPaymentMade;
                        $datas->second_payment_vat = $thisVat;
                        $datas->second_payment_discount = $thisDiscount;
                        $datas->second_payment_status = $whatsPaid;
                        if($whatsPaid=='Partial')
                        {
                            $datas->is_second_payment_partially_paid = 1;
                        }
                    } elseif($request->whichpayment =='Third Payment') {
                        $datas->third_payment_price = $thisPayment;
                        $datas->third_payment_paid = $thisPaymentMade;
                        $datas->third_payment_vat = $thisVat;
                        $datas->third_payment_discount = $thisDiscount;
                        $datas->third_payment_status = $whatsPaid;
                        if($whatsPaid=='Partial')
                        {
                            $datas->is_third_payment_partially_paid = 1;
                        }
                    } else {
                        $datas->total_price = $thisPayment;
                        $datas->total_paid = $thisPaymentMade;
                        $datas->total_vat = $thisVat;
                        $datas->total_discount = $thisDiscount;
                    }

                    $datas->coupon_code = $thisCode;
                    $datas->application_stage_status = 2;


                    $res = $datas->save();
                }


                $datas = payment::where([
               
                    ['payment_type', '=', $request->whichpayment],
                    ['application_id', '=', $applicant_id],
                ])->first();

                set_time_limit(0);

                $outletRef 	 	 = '15d885ec-682a-4398-89d9-247254d71c18';// config('app.payment_reference'); 
                $apikey 		 = "MmM2ODJiOGMtOGFmNS00NzUyLTg2MjUtM2Y5MTg3OWU5YjRlOjViMzhjM2I5LTUyMDItNDBmZi1hNzAyLTFlYTIwZDkwYjhiMQ=="; //config('app.payment_api_key'); 

                // Test URLS 
                $idServiceURL  = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
                $txnServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders"; 

                // LIVE URLS 
                //$idServiceURL  = "https://identity.ngenius-payments.com/auth/realms/NetworkInternational/protocol/openid-connect/token";           // set the identity service URL (example only)
                //$txnServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders"; 

                $tokenHeaders  = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
                $tokenResponse = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
                $tokenResponse = json_decode($tokenResponse);

                $access_token  = $tokenResponse->access_token;


                $order = array();	
                $successUrl = url('/').'/payment/success/'.$datas['id'];
                $failUrl =  url('/').'/payment/fail/'.$datas['id'];

                $order['action'] 				 	  = "PURCHASE";                                        // Transaction mode ("AUTH" = authorize only, no automatic settle/capture, "SALE" = authorize + automatic settle/capture)
                $order['amount']['currencyCode'] 	  = "AED";                           // Payment currency ('AED' only for now)
                $order['amount']['value'] 		 	  = ($amount)*100;                                   // Minor units (1000 = 10.00 AED)
                $order['language'] 					  = "en";      						// Payment page language ('en' or 'ar' only)
                $order['emailAddress'] 			 	  = "pwggroup@pwggroup.pl";      
                $order['billingAddress']['firstName'] = "PWG";      
                $order['billingAddress']['lastName']  = "Group";      
                $order['billingAddress']['address1']  = "The Oberoi Center";      
                $order['billingAddress']['city']  	  = "Business Bay";      
                $order['billingAddress']['countryCode'] = "UAE";      
                $order['merchantOrderReference'] = time();
                $order['merchantAttributes']['redirectUrl'] = $successUrl;
                $order['merchantAttributes']['skipConfirmationPage'] = true;
                $order['merchantAttributes']['cancelUrl']   = $failUrl;
                $order['merchantAttributes']['cancelText']  = 'Cancel';
                $order = json_encode($order);  
                $orderCreateHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
                //$orderCreateResponse = invokeCurlRequest("POST", $txnServiceURL, $orderCreateHeaders, $payment);
                $orderCreateResponse = $this->invokeCurlRequest("POST", $txnServiceURL, $orderCreateHeaders, $order);
                $orderCreateResponse = json_decode($orderCreateResponse);

                // $paymentLink 		   = $orderCreateResponse->_links->payment->href; 
                // return Redirect::to($paymentLink);

                // dd($orderCreateResponse);
                if(isset($orderCreateResponse->_links->payment->href)){
                    $paymentLink 		   = $orderCreateResponse->_links->payment->href; 
                    return Redirect::to($paymentLink);
                } else {
                    return redirect()->back()->with('failed', $orderCreateResponse->errors[0]->message);
                }
            // }
        } else {
            return redirect()->back()->with('failed', 'You are not authorized');
        }
    }

    public function getPromo(Request $request)
    {
        $response['status'] = false;
            $id = Session::get('myproduct_id');
            $coupon = DB::table('coupons')
                ->select('amount')
                ->where('code', '=', $request->discount_code)
                ->where('employee_id', '=', $id)
                ->where('active_from', '<=', date('Y-m-d'))
                ->where('active_until', '>=', date('Y-m-d'))
                ->where('active','=',1)
                ->get();

            foreach ($coupon as $apply) {
                $my_discount = $apply->amount;
            }


        if ($coupon->first()) {

            $discountPercent = 'PROMO: ' . $my_discount . '%';
            $discountamt = ($my_discount *  $request->totaldue) / 100;

            $topaynow = $request->totaldue  - (($my_discount *  $request->totaldue) / 100);
          

            Session::put('haveCoupon', 1);
            Session::put('myDiscount', $my_discount);

            $response['myDiscount'] = $my_discount;
            $response['haveCoupon'] = 1;
            $response['discountamt'] = $discountamt;
            $response['topaynow'] = $topaynow;
            $response['discountPercent'] =$discountPercent;

            $response['status'] = true;


            // return \Redirect::route('payment', $id);
        } else {
            $topaynoww = $request->totaldue; //If no promo
            Session::put('haveCoupon', 0);
            $response['haveCoupon'] = 0;
            $response['topaynow'] = $topaynoww;
            // return \Redirect::route('payment', $id)->with('failed', 'Invalid Discount/Promo Code');

        }
        return $response;
    }

    public function checkPromo(Request $request)
    {
            $response['status'] = false;

            $id = Session::get('myproduct_id');
            
            $coupon = DB::table('coupons')
            ->select('amount')
            ->where('location', '=', $request->embassy_appearance)
            ->where('employee_id', '=', $id)
            ->where('active_from', '<=', date('Y-m-d'))
            ->where('active_until', '>=', date('Y-m-d'))
            ->where('active','=',1)
            ->get();

        if ($coupon->first()) {
            // $response['haveCoupon'] = 1;

            $response['status'] = true;

            // return \Redirect::route('payment', $id);
        } else {
            // Session::put('haveCoupon', 0);
            // $response['haveCoupon'] = 0;
            $response['status'] = false;
            // return \Redirect::route('payment', $id)->with('failed', 'Invalid Discount/Promo Code');
        }
        return $response;
    }


    public function familyDetails(Request $request)
    {
        if (Auth::id()) {
            return \Redirect::route('product', $request->productId);
        } else {
            return redirect()->back()->with('failed', 'You are not authorized');
        }
    }

    public function contract($productId)
    {
        if (Auth::id()) {
            return view('user.contract', compact('productId'));
        } else {
            return redirect()->back()->with('failed', 'You are not authorized');
        }
    }

    /**
     * profile card details
     * 
     */
    public function card_details(Request $request) 
    {  
        $validator = \Validator::make($request->all(), [
            'card_number' => 'required|digits:16',
            'name' => 'required',
            'month' => 'required|numeric',
            'year' => 'required|numeric|digits:4|max:'.(date('Y')+100)
           
        ]);

        if($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {

            // Save Payment Information
            $apply = DB::table('applications')
            ->where('client_id', '=', Auth::user()->id)
            ->first();
            // $applicant_id = $apply->id;

            $datas = cardDetail::where('client_id', '=', Auth::user()->id)->first();
            if ($datas === null) {
                $data = new cardDetail();

                $data->client_id = Auth::user()->id;
                $data->card_holder_name = $request->name;
            
                $data->card_number = $request->card_number;
                $data->month = $request->month;
                $data->year = $request->year;
                $data->cvv = $request->cvc;
            
                $data->save();
            } else {

                $datas->client_id = Auth::user()->id;
                $datas->card_holder_name = $request->name;
            
                $datas->card_number = $request->card_number;
                $datas->month = $request->month;
                $datas->year = $request->year;
                $datas->cvv = $request->cvc;
                
                $datas->save();
            }
            // dd($datas);
        }
      return response()->json(['status' => 'Saved']);
}

public function mark_read(Request $request) {

           $notis = notifications::where('client_id', '=', Auth::user()->id)->get();

           if ($notis) {
                foreach($notis as $noti)
                {
                    $noti->status = 'Read';
                    $noti->save();
                }    
           }
            return response()->json(['status' => 'Cleared']);
}

    public function paymentSuccess($paymentId)
    {
        session_start();
        $id = Session::get('myproduct_id');
        $outletRef 	 	 = config('app.payment_reference');   
        $apikey 		 = config('app.payment_api_key'); 
        $orderReference  = $_GET['ref']; 
        //$orderReference  = 'd4008299-a923-4fde-9107-e0af33114549'; 
        //$idServiceURL    = "https://identity.ngenius-payments.com/auth/realms/Networkinternational/protocol/openid-connect/token";           // set the identity service URL (example only)
        //$residServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 

        $idServiceURL    = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
        $residServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 


        $tokenHeaders    = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
        $tokenResponse   = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
        $tokenResponse   = json_decode($tokenResponse);
        $access_token 	 = $tokenResponse->access_token;

        $responseHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
        $orderResponse 	  = $this->invokeCurlRequest("GET", $residServiceURL, $responseHeaders, '');
        $paymentResponse = json_decode($orderResponse);
        if(isset($paymentResponse->_embedded->payment[0]->authResponse)){
            $paymentResponse = $paymentResponse->_embedded->payment[0];

            if($paymentResponse->authResponse->success == true && $paymentResponse->authResponse->resultCode == "00"){
            
                $paymentDetails = Payment::where('id', $paymentId)->first();

                $paymentDetails->update([
                    'currency' => $paymentResponse->amount->currencyCode,
                    'transaction_id' => $paymentResponse->_id,
                ]);
                $monthYear = explode('-', $paymentResponse->paymentMethod->expiry);
                $res = cardDetail::updateOrCreate([
                    'client_id' => Auth::id()
                ],[
                    'client_id' => Auth::id(),
                    'card_number' => $paymentResponse->paymentMethod->pan,
                    'card_holder_name' => $paymentResponse->paymentMethod->cardholderName,
                    'month' => $monthYear[0],
                    'year' =>  $monthYear[1],
                ]);

                if ($res) {
                    //Update Applicant status in APPPLICANT TABLE
                    $status = applicant::where([
                        ['client_id', '=', Auth::user()->id],
                        ['destination_id', '=', $id],
                    ])->first();
                    if ($status === null) {
                    } else {
                        if($status->application_stage_status == 1)
                        {
                         $status->applicant_stage_status = '2';
                         $status->save();
                        }
                    }
                    // Save Payment Info
                    $card = cardDetail::where('client_id', '=', Auth::user()->id)->first();

                    // Send Notifications on This Payment ##############
                    $email = Auth::user()->email;
                    $userID = Auth::user()->id;

                    if($paymentDetails['payment_type'] == "First Payment")
                    {
                        $ems = "";
                    } else if($paymentDetails['payment_type'] == "Second Payment") {
                        $ems = " You will be notified when your Work Permit is ready.";
                    } else {
                        $ems = " You will be notified when your embassy appearance date is set.";
                    }

                    $criteria = $paymentDetails['payment_type'] . " Completed!";
                    $message = "You have successfully made your " .$paymentDetails['payment_type']. ". Kindly login to the PWG Client portal and check your receipt on 'My Application'" . $ems;

                    $link = "";
            
                    $dataArray = [
                        'title' => $criteria .' Mail from PWG Group',
                        'body' => $message,
                        'link' => $link
                    ];
                
                    $check_noti = notifications::where('criteria', '=', $criteria)->where('client_id', '=', Auth::user()->id)->first();

                    if ($check_noti === null) 
                    {

                        DB::table('notifications')->insert(
                                ['client_id' => $userID, 'message' => $message, 'criteria' => $criteria, 'link' => $link]
                        );
                
                        Mail::to($email)->send(new NotifyMail($dataArray));
                    } 
                    // Notification Ends ############ 
                    $dest = product::find($id);
                    $dest_name = $dest->name;

                    $msg = "Awesome! Payment Successful!";
                    return view('user.payment-success', compact('id'));
                } else {
                    return \Redirect::route('payment-fail', $id);
                }
            } else {
                return \Redirect::route('payment-fail', $id);
            }
        } else {
            return \Redirect::route('payment-fail', $id);
        }
    }

    public function paymentFail($paymentId)
    {
        Payment::where('id', $paymentId)->delete();
        $id = Session::get('myproduct_id');
        return view('user.payment-fail', compact('id'));
    }

}
