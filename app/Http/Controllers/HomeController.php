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
use DB;
use Session;
use Exception;


class HomeController extends Controller
{
    public function redirect()
    {

        if(session('prod_id'))
        {
          $id = Session::get('prod_id');

          
        $data = product::find($id);
        $promo = promo::where('product_id', '=', $id)->where('validity', '>=', date('Y-m-d'))->get();
        $ppay = product_payments::where('product_id', '=', $id)->get();
        $proddet = product_details::where('product_id', '=', $id)->get();

        session()->forget('prod_id');
        return view('user.package', compact('data', 'ppay', 'proddet','promo'));
        //   return \Redirect::route('product', $idd);

        } else{
                $package = product::all()->sortBy("id");
                $promo = promo::where('validity', '>=', date('Y-m-d'))->get();
                return view('user.home', compact('package','promo'));
        }            
        
    }

    public function index()
    {
        $package = product::all()->sortBy("id");
        $promo = promo::where('validity', '>=', date('Y-m-d'))->get();
        return view('user.home', compact('package','promo'));
    }

    public function createsession(Request $request) {
        \Session::put('packageType', $request->value);
        return redirect()->back();
    }

    public function packageType($productId)
    {
        $parents = $_COOKIE['parents'];
        $kids = $_COOKIE['pers'];


        if(isset($_COOKIE['packageType']))
        {
         Session::put('packageType', $_COOKIE['packageType']);
        }

        Session::put('mySpouse', $parents);
        Session::put('myKids', $kids);
        Session::put('myproduct_id', $productId);
        $data = product::find($productId);


        if (isset($parents) ) {

        if($parents =="yes") { $parentt =2; } else { $parentt = 1; }

        if($kids =="none") {
            $kids = 1;
        }
            $famdet = family_breakdown::where('product_id', '=', $productId)
            ->where('visa_type', 'FAMILY PACKAGE')
            ->where('parent', $parentt)
            ->where('children', $kids)
            ->get();
        } else {
            $famdet = family_breakdown::where('product_id', '=', $productId)->where('visa_type', 'FAMILY PACKAGE')->get();
        }

        unset($_COOKIE['pers']);
        unset($_COOKIE['parents']);

        $proddet = product_details::where('product_id', '=', $productId)->where('visa_type', 'BLUE AND PINK COLLAR JOBS')->get();
        $whiteJobs = product_details::where('product_id', '=', $productId)->where('visa_type', 'WHITE COLLAR JOBS')->get();
        return view('user.package-type', compact('proddet','famdet', 'productId', 'whiteJobs','data'));
    }

    public function product(Request $request)
    {

        
        if(isset($_COOKIE['packageType']))
        {
         Session::put('packageType', $_COOKIE['packageType']);
        }
        
        $id = Session::get('myproduct_id');
        
        session()->forget('totalCost');
        if(Session::get('packageType') == "FAMILY PACKAGE"){
            Session::put('totalCost', $request->cost);
            // Session::put('spouse', $request->spouse);
            // Session::put('kids', $request->children);
        } 
        $data = product::find($id);
        $promo = promo::where('product_id', '=', $id)->where('validity', '>=', date('Y-m-d'))->get();
        $ppay = product_payments::where('product_id', '=', $id)->get();
        $proddet = product_details::where('product_id', '=', $id)->get();

        session()->forget('prod_id');
        return view('user.package', compact('data', 'ppay', 'proddet','promo'));
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

            $folderPath = public_path('storage/signature/');
       
            $image_parts = explode(";base64,", $request->signed);
                 
            $image_type_aux = explode("image/", $image_parts[0]);
               
            $image_type = $image_type_aux[1];
               
            $image_base64 = base64_decode($image_parts[1]);
     
            $signate = time() . '.'.$image_type;
               
            $file = $folderPath . $signate;
     
            file_put_contents($file, $image_base64);
     
            $signature = user::find($request->user_id);
            $signature->signature = $signate;
            // $save = new Signature;
            // $save->name = $request->name;
            // $save->signature = $signature
            // $save->save();
        

            // if ($request->hasFile('image')) {
            //         $image = $request->file('image');
            //         $imagename = time() . '.' . $image->getClientOriginalName();
            //         $destinationPath = 'public/signature';
            //         $image->storeAs($destinationPath, $imagename);
            //         $signature->signature = $imagename;
            // }
            $signature->save();
            Applicant::updateOrCreate([
                'product_id' => $request->pid,
                'user_id' => Auth::id()
            ],[
                'first_name'=> Auth::user()->first_name,
                'visa_type' => Session::get('packageType'),
                'is_spouse' => Session::get('mySpouse'),
                'children_count'=> Session::get('myKidsp'),
            ]);
            return \Redirect::route('payment', $request->pid)
            ->with('info', 'Signature Uploaded Successfully!')
            ->with('info_sub','Proceed to application');
        } else {
            return redirect()->back()->with('message', 'You are not authorized');
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
            //Session::put('myproduct_id', $id);
            // Session::put('payall', $payall);
            // Session::get('variableName');
            $data = product::find($id);
            return view('user.referal-details', compact('data'));
        } else {
            return redirect()->back()->with('message', 'You are not authorized');
        }
    }

    public function addreferal(Request $request)
    {
        if (Auth::id()) {
            // Session::put('myapplication_id', $id);
            $request->validate([
                'current_location' => 'required',
                'pid' => 'required'
            ]);

            // $data = new applicant;
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
                $applys = DB::table('applicants')
                            ->where('product_id', '=', $request->pid)
                            ->where('user_id', '=', Auth::user()->id)
                            ->get();

                $applied='0';
                foreach($applys as $apply) 
                {
                        $applied = $apply->applicant_status;
                } 

                if ($applied == '1' || $applied == '0' || $applied == 'Pending') {
                    $msg="Referral Saved Successfully!";
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
            
            $pays = DB::table('product_payments')
                ->join('applicants', 'applicants.product_id', '=', 'product_payments.product_id')
                ->select('product_payments.id', 'product_payments.payment', 'product_payments.amount', 'product_payments.product_id')
                ->where('applicants.user_id', '=', $id)
                ->groupBy('product_payments.id')
                ->get();

            $paid = DB::table('payments')
                ->join('applicants', 'payments.application_id', '=', 'applicants.id')
                ->selectRaw('payments.*, applicants.*, COUNT(payments.id) as count')

                ->where('applicants.user_id', '=', $id)
                // ->groupBy('payments.id')
                ->groupBy('applicants.id')
                ->orderBy('applicants.id', 'desc')
                // ->limit(2)
                ->get();
    
            $prod = DB::table('products')
                ->join('applicants', 'products.id', '=', 'applicants.product_id')
                ->select('products.product_name', 'products.id')
                ->where('applicants.user_id', '=', $id)
                ->groupBy('products.id')
                ->get();


            return view('user.myapplication', compact('paid', 'pays', 'prod'));
        } else {
            return redirect()->back()->with('message', 'You are not authorized');
        }
    }

    public function payment(Request $request)
    {
        if (Auth::id()) 
        {
            if (session()->get('myproduct_id')) {
            } else {
                Session::put('myproduct_id', $request->id);
            }

            $id = Session::get('myproduct_id');
            // $applys = DB::table('applicants')
            // ->where('product_id', '=', $id)
            // ->where('user_id', '=', Auth::user()->id)
            // ->get();

            // $applied='0';
            // foreach($applys as $apply) 
            // {
            //         $applied = $apply->applicant_status;
            // } 

            // if ($applied == '1') {

                $data = product::find(Session::get('myproduct_id'));
                          
                $payall = Session::get('payall'); //$request->payall;

        //         $coupons = DB::table('promos')
        //         ->select('discount_percent')
        //         ->where('product_id', '=', $id)
        //         ->where('validity', '>=', date('Y-m-d'))
        //         ->get();

        //         foreach($coupons as $coupon) 
        //         {
        //                 $my_discount = $coupon->discount_percent;
        //         } 
        
        // if ($coupon->first()) {
        //     Session::put('myDiscount', $my_discount);
        // }

                $pays = DB::table('applicants')
                    ->leftJoin('payments', 'payments.application_id', '=', 'applicants.id')
                    ->leftJoin('product_payments', 'product_payments.id', '=', 'payments.product_payment_id')
                    ->select('product_payments.*', 'payments.product_payment_id', 'payments.total','payments.total_paid','payments.payment_status')
                    ->where('applicants.user_id', '=', Auth::user()->id)
                    ->where('applicants.product_id', '=', $id)
                    ->orderBy('payments.product_payment_id', 'desc')
                    ->limit(1)
                    ->get();
                $pdet = DB::table('product_payments')
                    ->where('product_id', '=', Session::get('myproduct_id'))
                    // ->groupBy('product_payments.id')
                    ->get();

                return view('user.payment-form', compact('data', 'pdet', 'pays', 'payall'));

        } else {
            return redirect()->back()->with('message', 'You are not authorized');
        }
    }

    
    public function addpayment(Request $request)
    {
        if (Auth::id()) {
            $id = Session::get('myproduct_id');
            $applys = DB::table('applicants')
                        ->where('product_id', '=', $id)
                        ->where('user_id', '=', Auth::user()->id)
                        ->get();

            foreach($applys as $apply) 
            {
                    $applicant_id = $apply->id;
            } 

            $validator = \Validator::make($request->all(), [
                'card_number' => 'required|numeric|digits:16',
                'card_holder_name' => 'required',
                'month' => 'required|numeric',
                'year' => 'required|numeric|digits:4|max:'.(date('Y')+100),
                'cvv' => 'required|numeric|digits:3',
                'totaldue' => 'required',
                'totalpay' => 'numeric|gte:1000'
                
            ]);

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            } else {
                if ($request->totalpay ==null || $request->totalpay=="" ||$request->totalpay < 1000) {
                    $totalpay = 0;
                } else {
                    $totalpay = $request->totalpay;
                }

                // Save Payment Information

                if ($request->totaldue == $request->totalpay) {
                    $whatsPaid ="Paid";
                } elseif ($request->totaldue > $request->totalpay && $request->totalpay>1000) {
                    $whatsPaid ="Partial";
                } else {
                    $whatsPaid ="Paid";
                    $overPay = $request->totalpay - $request->totaldue;
                }
                
                $datas = payment::where([
                ['product_payment_id', '=', $request->ppid],
                ['payment_type', '=', $request->whichpayment],
                ['application_id', '=', $applicant_id],
                        ])->first();
                if ($datas === null) {
                    $data = new payment();
                    $data->product_payment_id = $request->ppid;
                    $data->application_id = $applicant_id;
                    $data->card_holder_name = $request->card_holder_name;
                    $data->total = $request->totaldue;
                    $data->total_paid = $totalpay;
                    $data->payment_status = $whatsPaid;
                    $data->payment_type = $request->whichpayment;

                    if($request->save_card != null) {
                    $data->save_card_info = 1;
                    $data->card_number = $request->card_number;
                    $data->month = $request->month;
                    $data->year = $request->year;
                    $data->cvv = $request->cvv;
                    }
                    $res = $data->save();
                } else {
                    $datas->product_payment_id = $request->ppid;
                    $datas->application_id = $applicant_id;
                    $datas->card_holder_name = $request->card_holder_name;
                    $datas->total = $request->totaldue;
                    $datas->total_paid = $totalpay;
                    $datas->payment_status = $whatsPaid;
                    $datas->payment_type = $request->whichpayment;

            //        $isChecked = $request->save_card != null;
                    if($request->save_card != null) {
                    $datas->save_card_info = 1;
                    $datas->card_number = $request->card_number;
                    $datas->month = $request->month;
                    $datas->year = $request->year;
                    $datas->cvv = $request->cvv;
                    }
                    $res = $datas->save();
                }

                //Update Applicant status in APPPLICANT TABLE
                $status = applicant::where([
                ['user_id', '=', Auth::user()->id],
                ['product_id', '=', $request->pid],
                ['id', '=', $applicant_id],
                        ])->first();
                if ($status === null) {
                } else {
                    $status->applicant_status = '1f';
                    $status->save();
                }
                if ($res) {
                    $productId = $id;
                    $dest = product::find($request->pid);
                    $dest_name = $dest->product_name;

                    $msg="Awesome! Payment Successful!";
                    return view('user.payment-success', compact('id'));
                    // return \Redirect::route('applicant', $request->pid)->with('info', $msg)->with('info_sub', 'You journey to ' .$dest_name. ' just began!');
        } else {
            return view('user.payment-fail', compact('id'));

            // return redirect()->back()->with('failed', 'Oppss! Something Went Wrong!');
        }
    }
        } else {
            return redirect()->back()->with('failed', 'You are not authorized');
        }
    }

    public function getPromo(Request $request)
    {

        $id = Session::get('myproduct_id');
        $coupon = DB::table('promos')
        ->select('discount_percent')
        ->where('promo_code', '=', $request->discount_code)
        ->where('product_id', '=', $id)
        ->where('validity', '>=', date('Y-m-d'))
        ->get();
        foreach($coupon as $apply) 
        {
                $my_discount = $apply->discount_percent;
        } 

        if ($coupon->first()) {
            Session::put('myDiscount', $my_discount);
            Session::put('haveCoupon', 1);
            return \Redirect::route('payment', $id);
        } else {
            Session::put('haveCoupon', 0);
            return \Redirect::route('payment', $id)->with('failed', 'Invalid Discount/Promo Code');
        }
    }
    
    // public function applicant()
    // {
    //     return view('user.applicant');
    // }

    // /**
    //  * Store applicant details at step 3
    //  * @param Request
    //  *
    //  * @return void
    //  */
    // public function applicantDetails(Request $request)
    // {
    //     $request->validate([
    //         'applied_country' => 'required',
    //         'job_type' => 'required',
    //         'cv' => 'required|mimes:pdf',
    //         'agent_phone' => 'required',
    //         'agent_name' => 'required',
    //         'embassy_country' => 'required',
    //         'agree' => 'required'
    //     ]);
    //     $file = $request->file('cv');
    //     $fileName = time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());

    //     $destinationPath = 'public/resumes';
    //     $file->storeAs($destinationPath, $fileName);

    //     Applicant::where('user_id', Auth::id())
    //         ->where('product_id', $request->product_id)
    //         ->update([
    //             'country' => $request->applied_country,
    //             'job_type' => $request->job_type,
    //             'resume' => $fileName,
    //             'agent_phone_number' => $request->agent_phone,
    //             'agent_name' => $request->agent_name,
    //             'embassy_country' => $request->embassy_country,
    //         ]);

    //     return view('user.application-next')->with('success', 'Data saved successfully!');
    // }

    
    public function familyDetails(Request $request)
    {
        return \Redirect::route('product', $request->productId);
    }

    public function contract($productId)
    {
        return view('user.contract', compact('productId'));
    }

}
