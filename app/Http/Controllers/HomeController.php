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
use App\Helpers\Quickbook;
use App\Models\Quickbook as QuickModel;
use App\Constant;
use App\Helpers\pdfBlock;
use App\Helpers\users as UserHelper;
use Illuminate\Support\Facades\Mail;
use QuickBooksOnline\API\DataService\DataService;
use App\Mail\NotifyMail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use \setasign\Fpdi\PdfParser\StreamReader;
use Config;
use PDF;
use DB;
use Session;
use Exception;
use Illuminate\Contracts\Session\Session as SessionSession;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function redirect()
    {
        if (Auth::id()) {
            $client = User::find(Auth::id());
            // if ($client->email_verified_at) { // Use on production 

            if (session('prod_id')) {
                $id = Session::get('prod_id');

                $data = product::find($id);

                $promo = promo::where('employee_id', '=', $id)->where('active_until', '>=', date('Y-m-d'))->get();
                $ppay = product_payments::where('destination_id', '=', $id)->where('pricing_plan_type', '=', Session::get('packageType'))->where('status','CURRENT')->first();
                // $proddet = product_details::where('product_id', '=', $id)->get();

                session()->forget('prod_id');
                return view('user.package', compact('data', 'ppay', 'promo'));
                //   return \Redirect::route('product', $idd);

            } else {
                $started = DB::table('applications')
                    ->select('pricing_plan_id', 'destination_id', 'client_id', 'first_payment_status', 'status')
                    ->where('applications.client_id', '=', Auth::user()->id)
                    ->orderBy('applications.id', 'desc')
                    ->first();

                //Quickbook
                Quickbook::updateTokenAccess();

                // $ppay = product_payments::where('destination_id', '=', $id)->first();
                // $package = DB::table('destinations')->orderBy(DB::raw('FIELD(name, "Poland", "Czech", "Malta", "Canada", "Germany")'))->get();
                $package = DB::table('pricing_plans')
                ->join('destinations', 'destinations.id', '=', 'pricing_plans.destination_id')
                ->where('pricing_plans.pricing_plan_type', 'BLUE_COLLAR')
                ->where('pricing_plans.status','CURRENT')
                ->orderBy(DB::raw('FIELD(destinations.name, "Poland", "Czech", "Malta", "Canada", "Germany")'))
                ->get();

                $promo = promo::where('active_until', '>=', date('Y-m-d'))->get();

                return view('user.home', compact('package', 'promo', 'started'));
            }
            // } else {
            //     Auth::logout();
            //     return view('auth.verify-email');
            // }
        } else {
            Session::flush();
            // $package = DB::table('destinations')->orderBy(DB::raw('FIELD(name, "Poland", "Czech", "Malta", "Canada", "Germany")'))->get();
            $package = DB::table('pricing_plans')
            ->join('destinations', 'destinations.id', '=', 'pricing_plans.destination_id')
            ->where('pricing_plans.pricing_plan_type', 'BLUE_COLLAR')
            ->where('pricing_plans.status','CURRENT')
            ->orderBy(DB::raw('FIELD(destinations.name, "Poland", "Czech", "Malta", "Canada", "Germany")'))
            ->get();
            $promo = promo::where('active_until', '>=', date('Y-m-d'))->get();

            return view('user.home', compact('package', 'promo'));
        }
    }

    public function index()
    {
        if (Auth::id()) {

            $started = DB::table('applications')
                ->select('pricing_plan_id', 'destination_id', 'client_id', 'first_payment_status', 'status')
                ->where('applications.client_id', '=', Auth::user()->id)
                ->orderBy('applications.id', 'desc')
                ->first();

            // $package = DB::table('destinations')->orderBy(DB::raw('FIELD(name, "Poland", "Czech", "Malta", "Canada", "Germany")'))->get();

            $package = DB::table('pricing_plans')
            ->join('destinations', 'destinations.id', '=', 'pricing_plans.destination_id')
            ->where('pricing_plans.pricing_plan_type', 'BLUE_COLLAR')
            ->where('pricing_plans.status','CURRENT')
            ->orderBy(DB::raw('FIELD(destinations.name, "Poland", "Czech", "Malta", "Canada", "Germany")'))
            ->get();

            $promo = promo::where('active_until', '>=', date('Y-m-d'))->get();

            return view('user.home', compact('package', 'promo', 'started'));
        } else {

            // $package = DB::table('destinations')->orderBy(DB::raw('FIELD(name, "Poland", "Czech", "Malta", "Canada", "Germany")'))->get();

            $package = DB::table('pricing_plans')
            ->join('destinations', 'destinations.id', '=', 'pricing_plans.destination_id')
            ->where('pricing_plans.pricing_plan_type', 'BLUE_COLLAR')
            ->where('pricing_plans.status','CURRENT')
            ->orderBy(DB::raw('FIELD(destinations.name, "Poland", "Czech", "Malta", "Canada", "Germany")'))
            ->get();
            // dd($package);
            $promo = promo::where('active_until', '>=', date('Y-m-d'))->get();

            return view('user.home', compact('package', 'promo'));
        }

        // try {
        //     $package = DB::table('destinations')->orderBy(DB::raw('FIELD(name, "Poland", "Czech", "Malta", "Canada", "Germany")'))->get();
        //     $promo = promo::where('active_until', '>=', date('Y-m-d'))->get();
        //     return view('user.home', compact('package', 'promo'));
        // } catch (Exception $e){
        //     Session::put('error', $e->getMessage());
        //     return view('user.home', compact('package', 'promo'));
        // }      

    }

    public function packageType($productId, Request $request)
    {
        Session::forget('packageType');
        Session::forget('myproduct_id');
        Session::forget('mypack_id');
        Session::forget('mySpouse');
        Session::forget('myKids');

        if (isset($request->parents)) {
            Session::put('mySpouse', $request['parents']);
            Session::put('myKids', $request['kid']);
        }

        Session::put('myproduct_id', $productId);
        // Session::put('mypack_id', $pack_id);
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
                ->where('pricing_plan_type', 'FAMILY_PACKAGE')
                ->where('no_of_parent', $parentt)
                ->where('no_of_children', $kids)
                ->where('status','CURRENT')
                ->orderBy('sub_total', 'asc')
                ->first();

            if ($request->response == 1) {
                return $famdet;
            }
        } else {
            $famdet = family_breakdown::where('destination_id', '=', $productId)
                ->where('pricing_plan_type', 'FAMILY_PACKAGE')
                ->where('status','CURRENT')
                ->orderBy('sub_total', 'asc')
                ->first();
        }

        $proddet = family_breakdown::where('destination_id', '=', $productId)->where('pricing_plan_type', 'BLUE_COLLAR')->where('status','CURRENT')->get();
        $whiteJobs = family_breakdown::where('destination_id', '=', $productId)->where('pricing_plan_type', 'WHITE_COLLAR')->where('status','CURRENT')->get();
        $canadaOthers = family_breakdown::where('destination_id', '=', $productId)->whereIn('pricing_plan_type', array('EXPRESS_ENTRY', 'STUDY_PERMIT'))->where('status','CURRENT')->get();
        // dd($canadaOthers);
        return view('user.package-type', compact('proddet', 'famdet', 'productId', 'whiteJobs', 'data', 'canadaOthers'));
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

        if (Session::has('mySpouse') && Session::get('packageType') == "FAMILY_PACKAGE") {
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
                // ->where('id','=', $pid)
                ->where('pricing_plan_type', '=', Session::get('packageType'))
                ->where('no_of_parent', '=', $parentt)
                ->where('no_of_children', '=', $kids)
                ->where('status','CURRENT')
                ->orderBy('sub_total', 'asc')
                ->first();
                
        } else {
            $ppay = family_breakdown::where('destination_id', '=', $id)
                // ->where('id','=', $pid) 
                ->where('pricing_plan_type', '=', Session::get('packageType'))
                ->where('status','CURRENT')
                // ->where('family_sub_id', '=', Session::get('fam_id'))      
                ->first();
                // dd($ppay);
        }

        session()->forget('prod_id');
        return view('user.package', compact('data', 'ppay', 'promo'));
    }


    public function signature(Request $request, $id)
    {
        /* Old Codes
        try {
            if (Auth::id()) {
                // Session::put('myproduct_id', $id);
                Session::put('mypay_option', $request->payall);
                $pid  = Session::get('myproduct_id');
                $data = product::find($id);
                $datas = Applicant::where('client_id', Auth::id())
                    ->where('destination_id', $pid)
                    ->where('work_permit_category', (Session::get('packageType')) ?? 'BLUE_COLLAR')
                    ->first();
                if (Session::has('myproduct_id')) {
                    $pid  = Session::get('myproduct_id');
                } else {
                    $pid = 1;
                }
                $appliedCountry = Product::find($pid);
                $pdet = null;
                if(Session::get('packageType') =="FAMILY_PACKAGE")
                    {
                        if (Session::get('mySpouse') == "yes") {
                            $mySpouse = 2;
                        } else {
                            $mySpouse = 1;
                        }
            
                        if (Session::get('myKids') == 0 || Session::get('myKids') == "none" || Session::get('myKids') == 5 || Session::get('myKids') == null) {
            
                            $children = 1;
                        } else {
                            $children = Session::get('myKids');
                        }
                        $pdet = DB::table('pricing_plans')
                        ->where('destination_id', '=', Session::get('myproduct_id'))
                        ->where('pricing_plan_type', '=', Session::get('packageType'))
                        ->where('no_of_parent', '=', $mySpouse)
                        ->where('no_of_children', '=', $children)
                                                    ->where('status', 'CURRENT')
                        ->first();
                } else {
                    $pdet = DB::table('pricing_plans')
                        ->where('destination_id', '=', Session::get('myproduct_id'))
                        ->where('pricing_plan_type', '=', Session::get('packageType'))
                                                    ->where('status', 'CURRENT')
                        ->first();
                }
                if ($datas === null) {
                    $data = new applicant();
                    $data->client_id = Auth::id();
                    $data->destination_id = $pid;
                    $data->work_permit_category = (Session::get('packageType')) ?? 'BLUE_COLLAR';
                    $data->application_stage_status = 1;
                    $data->applied_country = $appliedCountry->name;
                    $data->pricing_plan_id = $pdet->id;
                    $data->contract = $request->contract;
    
                    $res = $data->save();
                } else {
                    $datas->work_permit_category =  (Session::get('packageType')) ?? 'BLUE_COLLAR';
                    $datas->application_stage_status = 1;
                    $datas->destination_id = $pid;
                    $datas->applied_country = $appliedCountry->name;
                    $datas->contract = $request->contract;
                    $datas->pricing_plan_id = $pdet->id;
                    $res = $datas->save();
                }
                return view('user.signature', compact('data'));
            } else {
                // return redirect()->back()->with('message', 'You are not authorized');
                return redirect('home');
            }
        } catch (Exception $e) {
            return redirect('home')->with('info', $e->getMessage());
        }

        */

        if (Auth::id()) {
            Session::put('mypay_option', $request->payall);
            $data = product::find($id);
            return view('user.signature', compact('data'));
        } else {
            return redirect('home');
        }
    }

    public function upload(Request $request)
    {
        if (Auth::id()) {
            list($part_a, $image_parts) = explode(";base64,", $request->signed);
            $image_type_aux = explode("image/", $part_a);
            $image_type = $image_type_aux[1];
            $signate = Auth::user()->id . '_' . time() . '.' . $image_type;
            $signature = user::find(Auth::user()->id);

            if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                $signature->addMediaFromBase64($request->signed)->usingFileName($signate)->toMediaCollection(User::$media_collection_main_signture, env('MEDIA_DISK'));
            } else {
                $signature->addMediaFromBase64($request->signed)->usingFileName($signate)->toMediaCollection(User::$media_collection_main_signture, 'local');
            }
            // $signature->addMediaFromBase64($request->signed)->usingFileName($signate)->toMediaCollection(User::$media_collection_main_signture, env('MEDIA_DISK'));
            $signature->save();

            /* old Codes
            if (Session::get('mySpouse') == "yes") {
                $is_spouse = 1;
            } else {
                $is_spouse = 0;
            }

            if (Session::has('myKids')) {
                $children = Session::get('myKids');
            } else {
                $children = 0;
            }

            User::where('id', Auth::id())
                ->update([
                    'is_spouse' => $is_spouse,
                    'children_count' => $children
                ]);
            */


            $myCHildren = $mySpouse = null;
            $is_spouse = $children = 0;
            if (Session::get('packageType') == 'FAMILY_PACKAGE') {
                if (Session::get('mySpouse') == "yes") {
                    $is_spouse = 1;
                    $mySpouse = 2;
                } else {
                    $is_spouse = 0;
                    $mySpouse = 1;
                }
                if (Session::has('myKids')) {
                    $children = Session::get('myKids');
                    $myCHildren = $children;
                } else {
                    $myCHildren = $children = 0;
                }
            }

            if (Session::has('myproduct_id')) {
                $pid  = Session::get('myproduct_id');
            } else {
                $pid = 1;
            }

            $datas = Applicant::where('client_id', Auth::id())
                ->where('destination_id', $pid)
                ->where('work_permit_category', (Session::get('packageType')) ?? 'BLUE_COLLAR')
                ->first();
            $pricingPLanId = product_payments::where('pricing_plan_type', Session::get('packageType'))
                ->where('destination_id', $pid)
                ->where('no_of_parent', $mySpouse)
                ->where('no_of_children', $myCHildren)
                ->where('status','CURRENT')
                ->pluck('id')
                ->first();
            $user = User::where('id', Auth::id())
                ->update([
                    'is_spouse' => $is_spouse,
                    'children_count' => $children
                ]);

            if ($datas === null) {
                $data = new applicant();
                $data->client_id = Auth::id();
                $data->destination_id = $pid;
                $data->pricing_plan_id = $pricingPLanId;
                $data->work_permit_category = (Session::get('packageType')) ?? 'BLUE_COLLAR';
                $data->application_stage_status = 1;
                $data->destination_id = $pid;
                $data->applied_country = strtoupper(product::where('id', $pid)->pluck('name')->first());
                $data->contract = Session::get('contract');
                $res = $data->save();
            } else {
                $datas->pricing_plan_id = $pricingPLanId;
                $datas->work_permit_category =  (Session::get('packageType')) ?? 'BLUE_COLLAR';
                $datas->application_stage_status = 1;
                $datas->destination_id = $pid;
                $datas->applied_country = strtoupper(product::where('id', $pid)->pluck('name')->first());
                $datas->contract = Session::get('contract');
                $res = $datas->save();
            }

            if ($signature) {
                Session::put('payall', $request->payall);
                Session::put('infox', 'Signature is Successful!');
                Session::put('infox_sub', 'Proceed to application');
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
            // return redirect()->back()->with('message', 'You are not authorized');
            return redirect('home');
        }
    }

    public function myapplication()
    {
        if (Auth::id()) {
            Session::forget('discountapplied');

            $id = Auth::user()->id;
            Session::forget('payall');

            \DB::statement("SET SQL_MODE=''");

            $complete = DB::table('applications')
                ->where('client_id', '=', Auth::user()->id)
                // ->whereNotIn('status',  array('APPLICATION_COMPLETED','VISA_REFUSED', 'APPLICATION_CANCELLED','REFUNDED') )
                ->orderBy('id', 'desc')
                ->first();
            // {
            if ($complete) {
                $app_id = $complete->id;
                $p_id = $complete->destination_id;
                //   $hasSpouse = $complete->is_spouse;
                //   $children = $complete->children_count;
            } else {
                $app_id = 0;
                $p_id = 0;
                // $hasSpouse = $complete->is_spouse;
                // $children = $complete->children_count;
            }

            if (isset($hasSpouse) && $hasSpouse == 1) {
                $yesSpouse = 2;
            } else {
                $yesSpouse = 1;
            }

            if (!isset($children)) {
                $children = 0;
            }
            $families = DB::table('pricing_plans')
                ->where('no_of_children', '=', $children)
                ->where('no_of_parent', '=', $yesSpouse)
                ->where('pricing_plan_type', '=', 'FAMILY_PACKAGE')
                ->where('status', 'CURRENT')
                ->get();
            foreach ($families as $famili) {
                $famCode = $famili->id;
            }

            if (session()->get('myproduct_id') && session()->get('myproduct_id') == $p_id) {
            } else {
                Session::put('myproduct_id', $p_id);
            }

            if (isset($complete->work_permit_category)) {
                $packageType = $complete->work_permit_category;
            } elseif (Session::has('packageType')) {
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

            $due = DB::table('payments')
                ->where('application_id', '=', $app_id)
                ->where('payment_type',  '=', 'FIRST')
                ->where('payable_amount', '>', 'paid_amount')
                ->orderBy('id', 'desc')
                ->first();

            if (isset($due)) {
                $date = Carbon::parse($due->payment_date);
                $daysToAdd = 14;
                $date = $date->addDays($daysToAdd);
                $now = Carbon::now();

                $datetime1 = strtotime($date); // convert to timestamps
                $datetime2 = strtotime(now()); // convert to timestamps
                $dueDay = (int)(($datetime1 - $datetime2) / 86400);
                // $dueDay = $date->diffInDays($now);
                //  $dueDay = Carbon::parse($due->payment_date)->diffForHumans();

            } else {
                $dueDay = "";
            }

            $pays = DB::table('pricing_plans')
                ->join('applications', 'applications.pricing_plan_id', '=', 'pricing_plans.id')
                // ->select('applications.pricing_plan_id', 'applications.destination_id', 'pricing_plans.id', 'pricing_plans.pricing_plan_type', 'pricing_plans.total_price', 'pricing_plans.destination_id', 'pricing_plans.first_payment_price', 'pricing_plans.submission_payment_price', 'pricing_plans.second_payment_price', 'pricing_plans.third_payment_price', 'pricing_plans.total_price')
                ->select('applications.pricing_plan_id', 'applications.destination_id', 'pricing_plans.id', 'pricing_plans.pricing_plan_type', 'pricing_plans.sub_total', 'pricing_plans.destination_id', 'pricing_plans.first_payment_sub_total', 'pricing_plans.submission_payment_sub_total', 'pricing_plans.second_payment_sub_total', 'pricing_plans.third_payment_sub_total', 'pricing_plans.sub_total')
                ->where('pricing_plans.pricing_plan_type', '=', $packageType)
                ->where('applications.destination_id', '=', $p_id)
                ->where('applications.client_id', '=', $id)
                ->where('pricing_plans.status', 'CURRENT')
                ->orderBy('pricing_plans.id')
                ->first();
            // dd($pays);
            $paid = DB::table('applications')
                ->where('applications.destination_id', '=', $p_id)
                ->where('applications.client_id', '=', $id)
                // ->groupBy('payments.id')
                ->orderBy('applications.id', 'desc')
                ->first();
            // dd($paid);
            $prod = DB::table('destinations')
                ->join('applications', 'destinations.id', '=', 'applications.destination_id')
                ->select('destinations.name', 'destinations.id', 'destinations.full_payment_discount')
                ->where('applications.client_id', '=', $id)
                ->where('applications.destination_id', '=', $p_id)
                ->groupBy('destinations.id')
                ->first();

            $authUrl = '';
            return view('user.myapplication', compact('paid', 'pays', 'prod', 'authUrl', 'dueDay'));
        } else {
            return redirect('home');
        }
    }

    public function payment(Request $request)
    {
        // try {
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
                    $mySpouse = 2;
                } else {
                    $yesSpouse = 1;
                    $mySpouse = 1;
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
                if (isset($complete->work_permit_category) && $complete->second_payment_status == 'PENDING') {
                    $packageType = $complete->work_permit_category;
                } elseif (Session::has('packageType')) {
                    $packageType = Session::get('packageType');
                } else {
                    $packageType = $complete->work_permit_category;
                }

                $data = product::find(Session::get('myproduct_id'));

                $pays = DB::table('applications')
                    ->select('applications.pricing_plan_id', 'applications.total_price', 'applications.total_paid', 'applications.first_payment_status', 'applications.submission_payment_status', 'applications.second_payment_status', 'first_payment_price', 'first_payment_paid', 'first_payment_remaining', 'is_first_payment_partially_paid', 'submission_payment_price', 'submission_payment_paid', 'submission_payment_remaining', 'second_payment_price', 'second_payment_paid', 'second_payment_remaining')
                    ->where('applications.client_id', '=', Auth::user()->id)
                    ->where('applications.destination_id', '=', $id)
                    ->where('work_permit_category', $packageType)
                    ->orderBy('applications.id', 'desc')
                    // ->whereNotIn('status',  ['APPLICATION_COMPLETED','VISA_REFUSED', 'APPLICATION_CANCELLED','REFUNDED'] )
                    ->limit(1)
                    ->first();


                if (!$pays) {
                    return redirect('home');
                    die();
                }

                if ($packageType == "FAMILY_PACKAGE") {
                    $pdet = DB::table('pricing_plans')
                        ->where('destination_id', '=', Session::get('myproduct_id'))
                        ->where('pricing_plan_type', '=', $packageType)
                        ->where('no_of_parent', '=', $mySpouse)
                        ->where('no_of_children', '=', $children)
                        ->where('status', 'CURRENT')
                        ->first();
                } else {
                    $pdet = DB::table('pricing_plans')
                        ->where('destination_id', '=', Session::get('myproduct_id'))
                        ->where('pricing_plan_type', '=', $packageType)
                        ->where('status', 'CURRENT')
                        ->first();
                }

                // if ($pays->first_payment_status != "PARTIALLY_PAID"){
                    /* Newly Added starts here*/
                    $applicant = Applicant::where('client_id', Auth::id())
                        ->where('destination_id', $id)
                        ->where('work_permit_category', $packageType)
                        ->first();
                    // if ($payall == 0 || empty($payall)) {
                        if ($pays->first_payment_status != "PAID" || $pays->first_payment_status == null) {
                            if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                                $originalPdf = Storage::disk(env('MEDIA_DISK'))->url('Applications/Contracts/client_contracts/' . $applicant->contract);
                            } else {
                                $originalPdf = Storage::disk('local')->url('Applications/Contracts/client_contracts/' . $applicant->contract);
                                $originalPdf = ltrim($originalPdf, $originalPdf[0]);
                            }
                            $paymentType =  "FIRST";
                            $user = User::find(Auth::id());
                            $signatureUrl = (isset($user->getMedia(User::$media_collection_main_signture)[0])) ? $user->getMedia(User::$media_collection_main_signture)[0]->getUrl() : null;
                            if (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                                $signatureUrl = ltrim($signatureUrl, $signatureUrl[0]);
                            }
                            $result = pdfBlock::attachSignature($originalPdf, $signatureUrl, $data, $paymentType, $applicant);
                        } 
                    //     elseif ($pays->first_payment_status == "PAID" && $pays->submission_payment_status != "PAID") {
                    //         $originalPdf = (isset($applicant->getMedia(Applicant::$media_collection_main_1st_signature)[0])) ? $applicant->getMedia(Applicant::$media_collection_main_1st_signature)[0]->getUrl() : null;
                    //         if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                    //                 if (Storage::disk('s3')->exists($applicant->getMedia(Applicant::$media_collection_main_1st_signature)[0]->getPath())) {
                    //                 } else {
                    //                     $originalPdf = Storage::disk(env('MEDIA_DISK'))->url('Applications/Contracts/client_contracts/' . $applicant->contract);
                    //                 }
                    //             } else {
                    //                 if (File::exists($applicant->getMedia(Applicant::$media_collection_main_1st_signature)[0]->getPath())) {
                    //                 } else {
                    //                     $originalPdf = Storage::disk('local')->url('Applications/Contracts/client_contracts/' . $applicant->contract);
                    //                 }
                    //                 $originalPdf = ltrim($originalPdf, $originalPdf[0]);
                    //             }
                    //         $paymentType =  "SUBMISSION";
                    //     } elseif ($pays->submission_payment_status == "PAID" && $pays->second_payment_status != "PAID") {
                    //         $originalPdf = (isset($applicant->getMedia(Applicant::$media_collection_main_submission_signature)[0])) ? $applicant->getMedia(Applicant::$media_collection_main_submission_signature)[0]->getUrl() : null;
                    //         if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                    //             if (Storage::disk('s3')->exists($applicant->getMedia(Applicant::$media_collection_main_submission_signature)[0]->getPath())) {
                    //             } else {
                    //                 $originalPdf = Storage::disk(env('MEDIA_DISK'))->url('Applications/Contracts/client_contracts/' . $applicant->contract);
                    //             }
                    //         } else {
                    //             if (File::exists($applicant->getMedia(Applicant::$media_collection_main_1st_signature)[0]->getPath())) {
                    //             } else {
                    //                 $originalPdf = Storage::disk('local')->url('Applications/Contracts/client_contracts/' . $applicant->contract);
                    //             }
                    //             $originalPdf = ltrim($originalPdf, $originalPdf[0]);
                    //         }
                    //         $paymentType =  "SECOND";
                    //     } else {
                    //         if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                    //             $originalPdf = Storage::disk(env('MEDIA_DISK'))->url('Applications/Contracts/client_contracts/' . $applicant->contract);
                    //         } else {
                    //             $originalPdf = Storage::disk('local')->url('Applications/Contracts/client_contracts/' . $applicant->contract);
                    //             $originalPdf = ltrim($originalPdf, $originalPdf[0]);
                    //         }
                    //         $paymentType =  "FIRST";
                    //     }
                    // } else {
                    //     if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                    //         $originalPdf = Storage::disk(env('MEDIA_DISK'))->url('Applications/Contracts/client_contracts/' . $applicant->contract);
                    //     } else {
                    //         $originalPdf = Storage::disk('local')->url('Applications/Contracts/client_contracts/' . $applicant->contract);
                    //         $originalPdf = ltrim($originalPdf, $originalPdf[0]);
                    //     }
                    //     $paymentType = 'Full-Outstanding Payment';
                    // }
                    // $user = User::find(Auth::id());
                    // $signatureUrl = (isset($user->getMedia(User::$media_collection_main_signture)[0])) ? $user->getMedia(User::$media_collection_main_signture)[0]->getUrl() : null;
                    // if (File::exists($user->getMedia(User::$media_collection_main_signture)[0]->getPath())) {
                    // if (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                    //     $signatureUrl = ltrim($signatureUrl, $signatureUrl[0]);
                    // }
                    // $result = pdfBlock::attachSignature($originalPdf, $signatureUrl, $data, $paymentType, $applicant);
                    // }
                    /* Newly added endss here*/
                // }
                return view('user.payment-form', compact('data', 'pdet', 'pays', 'payall'));
            } else {
                // return redirect()->back()->with('message', 'You are not authorized');
                return redirect('home');
            }
        // } catch (Exception $e) {
        //     return redirect('home')->with('error', $e->getMessage());
        // }
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

            $server_output = curl_exec($ch);
            if ($server_output === false) {
                throw new Exception(curl_error($ch), curl_errno($ch));
            }
            curl_close($ch);

            return $server_output;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function addpayment(Request $request)
    {
        try {
            if (Auth::id()) {
    
            session()->forget('info');

            $id = Session::get('myproduct_id');
    

            $complete = DB::table('applications')
            ->where('client_id', '=', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->first();

            if (isset($complete->work_permit_category) && $complete->second_payment_status == 'PENDING') {
                $packageType = $complete->work_permit_category;
            } elseif (Session::has('packageType')) {
                $packageType = Session::get('packageType');
            } else {
                $packageType = $complete->work_permit_category;
            }

           
            $pdet = DB::table('pricing_plans')
            ->where('destination_id', '=', $id)
            ->where('pricing_plan_type', '=', $packageType)
            ->where('status', 'CURRENT')
            ->first();
     
            if($request->whichpayment == 'FIRST')
            {
                if($request->totalpay >= 1000)
                {
                    $amount = $request->totalpay;
                } else {
                    if($request->vats >0)
                    {
                        $amount = $pdet->first_payment_price;
                    } else {
                        $amount = $pdet->first_payment_sub_total;
                    }  
                }
            } else if($request->whichpayment == 'SUBMISSION'){
                if($request->vats >0)
                {
                    $amount = $pdet->submission_payment_price;
                } else {
                    $amount = $pdet->submission_payment_sub_total;
                }                
            } else if($request->whichpayment == 'SECOND'){
                if($request->vats >0)
                {
                    $amount = $pdet->second_payment_price;
                } else {
                    $amount = $pdet->second_payment_sub_total;
                }
            } else {
                if($request->vats >0)
                {
                    $amount = $pdet->total_price - $pdet->third_payment_price;
                } else {
                    $amount = $pdet->sub_total - $pdet->third_payment_sub_total;
                }                
            }

            $apply = DB::table('applications')
                ->where('destination_id', '=', $id)
                // ->whereNotIn('status',  ['APPLICATION_COMPLETED','VISA_REFUSED', 'APPLICATION_CANCELLED','REFUNDED'] )
                ->where('client_id', '=', Auth::user()->id)
                ->OrderBy('id', "DESC")
                ->first();

            /* Newly Added from here*/
            $destination = Product::find($id);
            $coupon = DB::table('coupons')
                ->where('location', '=', ($apply->embassy_country) ?? $request->embassy_appearance)
                ->where('employee_id', '=', $id)
                ->where('active_from', '<=', date('Y-m-d'))
                ->where('active_until', '>=', date('Y-m-d'))
                ->where('active', '=', 1)
                ->first();
            /* Newly added to this point*/

            $applicant_id = $apply->id;
            $vals = array(0, 1, 2);

            if (in_array($apply->application_stage_status, $vals) && (empty($apply->embassy_country) || $apply->embassy_country == null)) {
                // if ($apply->current_location == "Unites") {
                if($request->amount > 0){
                    $validator = Validator::make($request->all(), [
                        'totaldue' => 'required',
                        // 'totalpay' => 'numeric|gte:1000|lte:' . $request->totaldue,
                        'current_location' => 'required',
                        'embassy_appearance' => 'required',
                        'amount' => 'numeric|gte:1000|lte:' . $request->totaldue
    
                    ]);
                } else {
                    $validator = Validator::make($request->all(), [
                        'totaldue' => 'required',
                        'totalpay' => 'numeric|gte:1000|lte:' . $request->totaldue,
                        'current_location' => 'required',
                        'embassy_appearance' => 'required',
                    ]);
                }
                
                if ($validator->fails()) {
                    return back()->withErrors($validator)
                        ->withInput();
                }
            } else {
                if($request->amount > 0){
                    $validator = Validator::make($request->all(), [
                        'amount' => 'numeric|gte:1000',
                        'totaldue' => 'required',
                        'totalpay' => 'numeric'
                    ]);
                } else{
                    $validator = Validator::make($request->all(), [
                        'totaldue' => 'required',
                        'totalpay' => 'numeric'
                    ]);
                }
                if ($validator->fails()) {
                    return back()->withErrors($validator)
                        ->withInput();
                }
            }
            $thisPayment = $request->whichpayment;
            $thisVat = $request->vats;
            $thisPayment = $request->totaldue;
            $thisPaymentMade = $request->totalpay;
            if ($request->discount > 0) {
                $thisDiscount = $request->discount;
                $thisCode = strip_tags($request->discount_code);
            } else {
                $thisDiscount = 0;
                $thisCode = '';
            }
            $thisDay = date('Y-m-d');

            if ($request->totalpay == null || $request->totalpay == "" || $request->totalpay < 1000) {
                $totalpay = 0;
            } else {
                $totalpay = $request->totalpay;
            }
            $outstand = $request->totalpay + $thisVat;

            // if ($request->totaldue == $request->totalpay) {
            if ($request->totaldue == ($request->totalpay + $request->discount)) {
                $whatsPaid = "PAID";
            } elseif ($request->totaldue > ($request->totalpay + $request->discount) && ($request->totalpay + $request->discount) >= 1000) {
                if ($request->totalremaining == ($request->totalpay + $request->discount)) {
                    $whatsPaid = "PAID";
                } else {
                    $whatsPaid = "PARTIALLY_PAID";
                }
            } else {
                $whatsPaid = "PENDING";//??????
                $overPay = $request->totalpay - $request->totaldue;
            }

            $haveSpouse =  Session::get('mySpouse');
            $kids =  Session::get('myKids');

            $rre = user::where([
                ['id', '=', Auth::user()->id]
            ])->first();

            if ($rre === null) {
            } else {
                // $rre->country_of_residence =  $request->current_location;
                $rre->country_of_residence =  (strlen($request->current_location) > 0) ? $request->current_location : $rre->country_of_residence;
                $rre->save();
            }

            set_time_limit(0);

            /* OLD ONE
                $outletRef       = '15d885ec-682a-4398-89d9-247254d71c18'; // config('app.payment_reference'); 
                $apikey          = "MmM2ODJiOGMtOGFmNS00NzUyLTg2MjUtM2Y5MTg3OWU5YjRlOjViMzhjM2I5LTUyMDItNDBmZi1hNzAyLTFlYTIwZDkwYjhiMQ=="; //config('app.payment_api_key'); 

                // Test URLS 
                $idServiceURL  = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
                $txnServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/" . $outletRef . "/orders";

                // LIVE URLS 
                //$idServiceURL  = "https://identity.ngenius-payments.com/auth/realms/NetworkInternational/protocol/openid-connect/token";           // set the identity service URL (example only)
                //$txnServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders"; 

                */

            if (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                $outletRef       = config('app.payment_reference_local');
                $apikey          = config('app.payment_api_key_local');
                // Test URLS 
                $idServiceURL  = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
                $txnServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/" . $outletRef . "/orders";
            } else {
                $outletRef       = config('app.payment_reference');
                $apikey          = config('app.payment_api_key');
                // LIVE URLS 
                $idServiceURL  = "https://identity.ngenius-payments.com/auth/realms/NetworkInternational/protocol/openid-connect/token";           // set the identity service URL (example only)
                $txnServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/" . $outletRef . "/orders";
            }

            $tokenHeaders  = array("Authorization: Basic " . $apikey, "Content-Type: application/x-www-form-urlencoded");
            $tokenResponse = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
            $tokenResponse = json_decode($tokenResponse);
            $access_token  = $tokenResponse->access_token;

            $order = array();
            $successUrl = url('/') . '/payment/success';
            $failUrl =  url('/') . '/payment/fail';
            $order['action']                        = "PURCHASE";                      // Transaction mode ("AUTH" = authorize only, no automatic settle/capture, "SALE" = authorize + automatic settle/capture)
            $order['amount']['currencyCode']       = "AED";                           // Payment currency ('AED' only for now)
            $order['amount']['value']                = floor($amount * 100);              // Minor units (1000 = 10.00 AED)
            $order['language']                       = "en";                        // Payment page language ('en' or 'ar' only)
            $order['emailAddress']                    = "pwggroup@pwggroup.pl";
            $order['billingAddress']['firstName'] = "PWG";
            $order['billingAddress']['lastName']  = "Group";
            $order['billingAddress']['address1']  = "The Oberoi Center";
            $order['billingAddress']['city']        = "Business Bay";
            $order['billingAddress']['countryCode'] = "UAE";
            $order['merchantOrderReference'] = time();
            $order['merchantAttributes']['redirectUrl'] = $successUrl;
            $order['merchantAttributes']['skipConfirmationPage'] = true;
            $order['merchantAttributes']['cancelUrl']   = $failUrl;
            $order['merchantAttributes']['cancelText']  = 'Cancel';
            $order = json_encode($order);
            $orderCreateHeaders  = array("Authorization: Bearer " . $access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
            //$orderCreateResponse = invokeCurlRequest("POST", $txnServiceURL, $orderCreateHeaders, $payment);
            $orderCreateResponse = $this->invokeCurlRequest("POST", $txnServiceURL, $orderCreateHeaders, $order);
            $orderCreateResponse = json_decode($orderCreateResponse);

            // $paymentLink 		   = $orderCreateResponse->_links->payment->href; 
            // return Redirect::to($paymentLink);

            if (isset($orderCreateResponse->_links->payment->href)) {

                ###################################################################
                $ppd = payment::where([
                    ['application_id', '=', $applicant_id],
                    ['invoice_amount', $request->totalpay],
                    ['payment_type', $request->whichpayment]
                ])
                   
                    ->where(function ($query) use ($request) {
                        $query->where('paid_amount', $request->totalpay)
                            ->orWhere('paid_amount', NULL);
                    })
                    ->first();
                if ($ppd === null) {
                    $dat = new payment;

                    $dat->payment_type = $request->whichpayment;
                    $dat->application_id = $applicant_id;
                    $dat->payment_date = $thisDay;
                    $dat->payable_amount = $request->totaldue;
                    $dat->invoice_amount = $request->totalpay;
                    // $dat->remaining_amount = (isset($request->totalremaining)) ? $request->totalremaining : NULL;
                    $dat->remaining_amount = (isset($request->totalremaining)) ? NULL : $request->totaldue - $request->totalpay;
                    $dat->save();
                    Session::put('paymentId', $dat->id);
                } else {
                    Session::put('paymentId', $ppd->id);

                    if (isset($request->totalremaining) && $request->totalremaining > 0) {
                        $ppd->payment_type = "Balance on " . $request->whichpayment;
                    } else {
                        $ppd->payment_type = $request->whichpayment;
                    }
                    $ppd->application_id = $applicant_id;
                    $ppd->payment_date = $thisDay;
                    $ppd->payable_amount = $request->totaldue;
                    $ppd->invoice_amount = $request->totalpay;
                    $ppd->save();
                }

                $datas = applicant::where([
                    ['client_id', '=', Auth::user()->id],
                    ['destination_id', '=', $request->pid],
                ])
                    ->orderBy('id', 'Desc')
                    ->first();
                $paymentCreds = [
                    'whatsPaid' => $whatsPaid,
                    'thisPayment' => $thisPayment,
                    'thisPaymentMade' => $thisPaymentMade,
                    'totalremaining' => $request['totalremaining'],
                    'whichpayment' => $request['whichpayment'],
                    'datas' => $datas,
                    'totalpay' => $request->totalpay,
                    'discount' => $request->discount
                ];
                if ($datas === null) {
                    $data = new applicant;
                    if (in_array($apply->application_stage_status, $vals) && (empty($apply->embassy_country) || $apply->embassy_country == null)) {
                        $data->embassy_country = $request->embassy_appearance;
                    }
                    $data->pricing_plan_id = $request->ppid;

                    if ($request->whichpayment == 'FIRST') {
                        $data->first_payment_price = $thisPayment; //was remarked
                        $data->first_payment_paid = $thisPaymentMade; //was remarked
                        $data->first_payment_vat = $thisVat;
                        $data->first_payment_discount = $thisDiscount;
                    }  elseif ($request->whichpayment == 'SUBMISSION') {
                        $data->submission_payment_price = $thisPayment;
                        $data->submission_payment_paid = $thisPaymentMade;
                        $data->submission_payment_vat = $thisVat;
                        $data->submission_payment_discount = $thisDiscount;
                    } elseif ($request->whichpayment == 'SECOND') {
                        $data->second_payment_price = $thisPayment;
                        $data->second_payment_paid = $thisPaymentMade;
                        $data->second_payment_vat = $thisVat;
                        $data->second_payment_discount = $thisDiscount;
                        $data->coupon_code = $thisCode;
                        $res = $data->save();
                    } else {

                        // $data->second_payment_status = 'PAID';
                        $data->total_price = $thisPayment;
                        $data->total_vat = $thisVat;
                        $data->total_discount = $thisDiscount;
                        //Splits
                        $paysplit = DB::table('pricing_plans')
                            ->where('destination_id', '=', $request->pid)
                            ->where('id', ($apply->pricing_plan_id) ?? $request->ppid)
                            ->where('status', 'CURRENT')
                            ->first();

                        $paymentCreds['paysplit'] = $paysplit;

                        if (isset($paysplit)) {
                            //First Split


                            if ($thisDiscount > 0) {
                                // $firstDisc = ($request->third_p * $destination->full_payment_discount) / 100;
                                $firstDisc = $request->first_p * (Session::get('discountapplied') == 1) ?  $coupon->amount / 100 : $destination->full_payment_discount / 100;

                                // $firstVat = (($request->first_p - $firstDisc) * 5) / 100;
                            } else {
                                $firstDisc = ($request->first_p * ((Session::get('discountapplied') == 1) ? $coupon->amount : 0)) / 100;
                                // $firstVat = (($request->first_p )* 5) / 100;
                            }

                            if (isset($thisVat) && $thisVat > 0) {
                                $firstVat = ($paysplit->first_payment_price * 5) / 100;
                            } else {
                                $firstVat = 0;
                            }
                            $paymentCreds['firstVat'] = $firstVat;

                            // $data->first_payment_price = $paysplit->first_payment_price + $firstVat;
                            $data->first_payment_price = ($paysplit->first_payment_price - $firstDisc) + $firstVat;
                            $paymentCreds['paysplit']->first_payment_price = ($paysplit->first_payment_price - $firstDisc) + $firstVat;
                            $data->first_payment_vat = $firstVat;
                            $data->first_payment_discount = $firstDisc;

                            //Second Split
                            if ($thisDiscount > 0) {
                                // $secondDisc = ($request->second_p * $destination->full_payment_discount) / 100;
                                $secondDisc = ($request->second_p * ((Session::get('discountapplied') == 1) ? ($coupon->amount) : $destination->full_payment_discount)) / 100;
                                // $secondVat = (($request->second_p - $secondDisc) * 5) / 100;
                            } else {
                                $secondDisc = ($request->second_p * ((Session::get('discountapplied') == 1) ? $coupon->amount : 0)) / 100;
                                // $secondVat = ($request->second_p * 5) / 100;
                            }
                            if (isset($thisVat) && $thisVat > 0) {
                                // $secondVat = ($paysplit->submission_payment_price * 5) / 100;
                                $secondVat = (($request->second_p - $secondDisc) * 5) / 100;
                            } else {
                                $secondVat = 0;
                            }
                            $paymentCreds['secondVat'] = $secondVat;

                            // $data->submission_payment_price = $paysplit->submission_payment_price  + $secondVat;
                            $data->submission_payment_price = ($paysplit->submission_payment_price - $secondDisc) + $secondVat;
                            $paymentCreds['paysplit']->submission_payment_price = ($paysplit->submission_payment_price - $secondDisc) + $secondVat;

                            $data->submission_payment_vat = $secondVat;
                            $data->submission_payment_discount = $secondDisc;

                            //Third Split
                            if ($thisDiscount > 0) {
                                // $thirdDisc = ($request->third_p * $destination->full_payment_discount) / 100;
                                $thirdDisc = ($request->third_p * ((Session::get('discountapplied') == 1) ? ($coupon->amount) : $destination->full_payment_discount)) / 100;
                            } else {
                                $thirdDisc = ($request->third_p * ((Session::get('discountapplied') == 1) ? $coupon->amount : 0)) / 100;

                                // $thirdVat = ($request->third_p * 5) / 100;
                            }
                            if (isset($thisVat) && $thisVat > 0) {
                                // $thirdVat = ($paysplit->second_payment_price * 5) / 100;

                                $thirdVat = (($request->third_p - $thirdDisc) * 5) / 100;
                            } else {
                                $thirdVat = 0;
                            }
                            $paymentCreds['thirdVat'] = $thirdVat;

                            // $data->second_payment_price = $paysplit->second_payment_price + $thirdVat;
                            $data->second_payment_price = ($paysplit->second_payment_price - $thirdDisc) + $thirdVat;
                            $paymentCreds['paysplit']->second_payment_price = ($paysplit->second_payment_price - $thirdDisc) + $thirdVat;

                            $data->second_payment_vat = $thirdVat;
                            $data->second_payment_discount = $thirdDisc;
                        }
                    }

                    $data->coupon_code = $thisCode;
                    // $data->application_stage_status = 2;

                    $res = $data->save();
                } else {
                    if (in_array($apply->application_stage_status, $vals) && (empty($apply->embassy_country) || $apply->embassy_country == null)) {
                        $datas->embassy_country = $request->embassy_appearance;
                    }
                    $datas->pricing_plan_id = $request->ppid;

                    if ($request->whichpayment == 'FIRST') {
                        $datas->first_payment_price = $thisPayment;
                        // $datas->first_payment_paid = $thisPaymentMade;

                        $datas->first_payment_vat = $thisVat;
                        $datas->first_payment_discount = $thisDiscount;

                        if (isset($request->totalremaining) && $request->totalremaining > 0) {
                        } else {
                            $datas->first_payment_price = $thisPayment;
                        }
                    } elseif ($request->whichpayment == 'SUBMISSION') {
                        $datas->submission_payment_price = $thisPayment;
                        $datas->submission_payment_vat = $thisVat;
                        $datas->submission_payment_discount = $thisDiscount;
                    } elseif ($request->whichpayment == 'SECOND') {
                        $datas->second_payment_price = $thisPayment;
                        $datas->second_payment_vat = $thisVat;
                        $datas->second_payment_discount = $thisDiscount;
                    } else {
                        $datas->total_price = $thisPayment;
                        $datas->total_vat = $thisVat;
                        $datas->total_discount = $thisDiscount;
                        //Splits
                        $paysplit = DB::table('pricing_plans')
                            ->where('destination_id', '=', $request->pid)
                            ->where('id', ($apply->pricing_plan_id) ?? $request->ppid)
                            ->where('status', 'CURRENT')
                            ->first();
                        $paymentCreds['paysplit'] = $paysplit;

                        if (isset($paysplit)) {
                            //First Split
                            $firstDisc = 0;
                            if ($thisDiscount > 0) {
                                // $firstDisc = ($request->first_p * $destination->full_payment_discount) / 100;
                                $firstDisc = ($request->first_p * ((Session::get('discountapplied') == 1) ? ($coupon->amount) : $destination->full_payment_discount)) / 100;

                                // $firstVat = (($request->first_p - $firstDisc) * 5) / 100;
                            } else {
                                $firstDisc = ($request->first_p * ((Session::get('discountapplied') == 1) ? $coupon->amount : 0)) / 100;

                                // $firstVat = ($request->first_p * 5) / 100;
                            }
                            if (isset($thisVat) && $thisVat > 0) {
                                //$firstVat = ($paysplit->first_payment_price * 5) / 100;
                                $firstVat = (($request->first_p - $firstDisc) * 5) / 100;
                            } else {
                                $firstVat = 0;
                            }
                            $paymentCreds['firstVat'] = $firstVat;

                            // $datas->first_payment_price = $paysplit->first_payment_price + $firstVat;
                            $datas->first_payment_price = ($apply->first_payment_price > 0) ? $apply->first_payment_price : ($paysplit->first_payment_price - $firstDisc) + $firstVat;
                            $paymentCreds['paysplit']->first_payment_price = ($apply->first_payment_price) ?? ($paysplit->first_payment_price - $firstDisc) + $firstVat;

                            $datas->first_payment_vat = ($apply->first_payment_vat) ?? $firstVat;
                            $datas->first_payment_discount = $firstDisc;
                            $secondVat = 0;
                            $secondDisc = 0;
                            //Second Split
                            if ($thisDiscount > 0) {
                                // $secondDisc = ($request->second_p * $destination->full_payment_discount) / 100;
                                $secondDisc = ($request->second_p * ((Session::get('discountapplied') == 1) ? ($coupon->amount) : $destination->full_payment_discount)) / 100;

                                // $secondVat = (($request->second_p - $secondDisc) * 5) / 100;
                            } else {
                                $secondDisc = ($request->second_p * ((Session::get('discountapplied') == 1) ? $coupon->amount : 0)) / 100;

                                // $secondVat = ($request->second_p * 5) / 100;
                            }
                            if (isset($thisVat) && $thisVat > 0) {
                                //$secondVat = ($paysplit->submission_payment_price * 5) / 100;
                                $secondVat = (($request->second_p - $secondDisc) * 5) / 100;
                            }
                            // $datas->submission_payment_price = $paysplit->submission_payment_price + $secondVat;
                            $datas->submission_payment_price = ($apply->submission_payment_price > 0) ? ($apply->first_payment_price) : ($paysplit->submission_payment_price - $secondDisc) + $secondVat;
                            $paymentCreds['paysplit']->submission_payment_price = ($apply->submission_payment_price) ?? ($paysplit->submission_payment_price - $secondDisc) + $secondVat;

                            $datas->submission_payment_vat = ($apply->submission_payment_vat) ?? $secondVat;
                            $datas->submission_payment_discount = $secondDisc;
                            $paymentCreds['secondVat'] = $secondVat;
                            $thirdVat = 0;
                            $thirdDisc = 0;
                            //Third Split
                            if ($thisDiscount > 0) {
                                $thirdDisc = ($request->third_p * ((Session::get('discountapplied') == 1) ? ($coupon->amount) : $destination->full_payment_discount)) / 100;

                                // $thirdDisc = ($request->third_p * $destination->full_payment_discount) / 100;
                                // $thirdVat = (($request->third_p - $thirdDisc) * 5) / 100;

                            } else {
                                $thirdDisc = ($request->third_p * ((Session::get('discountapplied') == 1) ? $coupon->amount : 0)) / 100;
                                // $thirdVat = ($request->third_p * 5) / 100;
                            }
                            if (isset($thisVat) && $thisVat > 0) {
                                //$thirdVat = ($paysplit->second_payment_price * 5) / 100;
                                $thirdVat = (($request->third_p - $thirdDisc) * 5) / 100;
                            }
                            // $datas->second_payment_price = $paysplit->second_payment_price + $thirdVat;
                            $datas->second_payment_price = ($paysplit->second_payment_price - $thirdDisc) + $thirdVat;
                            $paymentCreds['paysplit']->second_payment_price = ($paysplit->second_payment_price - $thirdDisc) + $thirdVat;

                            $datas->second_payment_vat = $thirdVat;
                            $datas->second_payment_discount = $thirdDisc;
                            $paymentCreds['thirdVat'] = $thirdVat;
                        }
                    }
                    $datas->coupon_code = $thisCode;
                    // $datas->application_stage_status = 2;

                    $res = $datas->save();

                    // $paymentId = payment::where([
                    //             ['payment_type', '=', $request->whichpayment],
                    //             ['application_id', '=', $applicant_id],
                    //         ])
                    //         ->pluck('id')
                    //         ->first();
                    // Session::put('paymentId', $paymentId);
                }

                ###########################################################################

                $paymentLink  = $orderCreateResponse->_links->payment->href;
                Session::put('paymentCreds', $paymentCreds);
                return Redirect::to($paymentLink);
            } else {
                Session::forget('paymentCreds');
                return redirect()->back()->with('failed', $orderCreateResponse->errors[0]->message);
            }
            // }
        } else {
            Session::forget('paymentCreds');
            // return redirect()->back()->with('failed', 'You are not authorized');
            return redirect('home');
        }

        } catch (Exception $e) {
            return redirect('myapplication')->with($e->getMessage());
        }
    }


    public function paymentSuccess()
    {
        try {

            session_start();
            $id = Session::get('myproduct_id');
            $orderReference  = $_GET['ref'];

            if (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                // local
                $outletRef       = config('app.payment_reference_local');
                $apikey          = config('app.payment_api_key_local');
                $idServiceURL    = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
                $residServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/" . $outletRef . "/orders/" . $orderReference;
            } else {
                $outletRef           = config('app.payment_reference');
                $apikey          = config('app.payment_api_key');

                $idServiceURL    = "https://identity.ngenius-payments.com/auth/realms/Networkinternational/protocol/openid-connect/token";           // set the identity service URL (example only)
                $residServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/" . $outletRef . "/orders/" . $orderReference;
            }

            $tokenHeaders    = array("Authorization: Basic " . $apikey, "Content-Type: application/x-www-form-urlencoded");
            $tokenResponse   = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
            $tokenResponse   = json_decode($tokenResponse);
            $access_token      = $tokenResponse->access_token;

            $responseHeaders  = array("Authorization: Bearer " . $access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
            $orderResponse       = $this->invokeCurlRequest("GET", $residServiceURL, $responseHeaders, '');
            $paymentResponse = json_decode($orderResponse);
            if (isset($paymentResponse->_embedded->payment[0]->authResponse)) {
                $paymentResponse = $paymentResponse->_embedded->payment[0];

                if ($paymentResponse->authResponse->success == true && $paymentResponse->authResponse->resultCode == "00") {
                    $paymentDetails = Payment::where('id', Session::get('paymentId'))->first();
                    if (session()->has('paymentCreds')) {
                    } else {
                        return \Redirect::route('myapplication');
                    }
                    $paymentCreds = Session::get('paymentCreds');


                    $data = applicant::where([
                        ['client_id', '=', Auth::user()->id],
                        ['destination_id', '=', $id],
                    ])
                        ->orderBy('id', 'DESC')
                        ->first();

                    if ($paymentCreds['whichpayment'] == 'FIRST' || $paymentCreds['whichpayment'] == 'BALANCE_ON_FIRST') {
                        $data->first_payment_status = $paymentCreds['whatsPaid'];
                        if ($paymentCreds['whatsPaid'] == 'PARTIALLY_PAID') { // add in payment success
                            $data->first_payment_remaining =  $paymentCreds['thisPayment'] - $paymentCreds['thisPaymentMade']; // add in payment success
                            // $data->first_payment_remaining =  ($paymentCreds['thisPayment'] + $paymentCreds['discount']) - $paymentCreds['thisPaymentMade'];

                            $data->is_first_payment_partially_paid = 1; // add in payment success
                            $data->status = 'WAITING_FOR_BALANCE_ON_FIRST_PAYMENT'; // add in payment success
                        } else { // add in payment success
                            $data->first_payment_remaining = 0; // add in payment success

                            $data->is_first_payment_partially_paid = 0; // add in payment success
                            $data->status = 'DOCUMENT_SUBMITTED'; // add in payment success

                            $data->first_payment_verified_by_accountant = 1;
                            $data->first_payment_verified_by_cfo = 1;
                        }
                        if (isset($paymentCreds['totalremaining']) && $paymentCreds['totalremaining'] > 0) { // add in payment success
                            //     // $data->first_payment_price = $thisPayment;
                            $data->first_payment_paid = $paymentCreds['thisPaymentMade'] + $paymentCreds['totalremaining']; // add in payment success
                        } else { // add in payment success
                            $data->first_payment_price = $paymentCreds['thisPayment']; // add in payment success
                            $data->first_payment_paid = $paymentCreds['thisPaymentMade']; // add in payment success
                        }
                    } elseif ($paymentCreds['whichpayment'] == 'SUBMISSION') {
                        $data->submission_payment_paid = $paymentCreds['thisPaymentMade']; // add in payment success
                        $data->submission_payment_status = $paymentCreds['whatsPaid'];  // add in payment success
                        if($data->work_permit_status == "WORK_PERMIT_RECEIVED"){
                            $data->status = 'WAITING_FOR_EMBASSY_APPEARANCE';  // add in payment success
                        }
                        if ($paymentCreds['whatsPaid'] == 'PARTIALLY_PAID') { // add in payment success
                            $data->is_submission_payment_partially_paid = 1; // add in payment success
                        } // add in payment success
                        $data->submission_payment_verified_by_accountant = 1;
                        $data->submission_payment_verified_by_cfo = 1;
                    } elseif ($paymentCreds['whichpayment'] == 'SECOND') {
                        $data->second_payment_paid = $paymentCreds['thisPaymentMade']; // add in payment success
                        $data->second_payment_status = $paymentCreds['whatsPaid']; // add in payment success
                        $data->status = 'APPLICATION_COMPLETED'; // add in payment success
                        if ($paymentCreds['whatsPaid'] == 'PARTIALLY_PAID') { // add in payment success
                            $data->is_second_payment_partially_paid = 1; // add in payment success
                        } // add in payment success
                        $data->second_payment_verified_by_accountant = 1;
                        $data->second_payment_verified_by_cfo = 1;
                    } else {
                        $data->total_paid = $paymentCreds['thisPaymentMade']; // add in payment success
                        // $data->status = 'WAITING_FOR_EMBASSY_APPEARANCE'; // add in payment success
                        if ($paymentCreds['paysplit']) {
                            // $data->first_payment_paid = $paymentCreds['paysplit']->first_payment_price + $paymentCreds['firstVat']; // add in payment success
                            $data->first_payment_paid = ($data->first_payment_price) ?? $paymentCreds['paysplit']->first_payment_price; // add in payment success

                            $data->first_payment_status = 'PAID'; // add in payment success
                            // $data->submission_payment_paid = $paymentCreds['paysplit']->submission_payment_price + $paymentCreds['secondVat']; // add in payment success
                            $data->submission_payment_paid = ($data->submission_payment_price) ?? $paymentCreds['paysplit']->submission_payment_price; // add in payment success

                            $data->submission_payment_status = 'PAID'; // add in payment success
                            // $data->second_payment_paid = $paymentCreds['paysplit']->second_payment_price + $paymentCreds['thirdVat']; // add in payment success
                            $data->second_payment_paid = $paymentCreds['paysplit']->second_payment_price; // add in payment success
                            $data->second_payment_status = 'PAID'; // add in payment success
                        }
                        $data->first_payment_verified_by_accountant = 1;
                        $data->first_payment_verified_by_cfo = 1;
                        $data->submission_payment_verified_by_accountant = 1;
                        $data->submission_payment_verified_by_cfo = 1;
                        $data->second_payment_verified_by_accountant = 1;
                        $data->second_payment_verified_by_cfo = 1;
                        $data->status = 'DOCUMENT_SUBMITTED'; // add in payment success
                    }
                    $data->save();
                    $paymentDetails->update([
                        'paid_amount' => $paymentCreds['totalpay'],
                        'currency' => $paymentResponse->amount->currencyCode,
                        'bank_reference_no' => $paymentResponse->merchantOrderReference,
                        'transaction_id' => $paymentResponse->_id,
                    ]);
                    $monthYear = explode('-', $paymentResponse->paymentMethod->expiry);
                    $res = cardDetail::updateOrCreate([
                        'client_id' => Auth::id()
                    ], [
                        'card_number' => $paymentResponse->paymentMethod->pan,
                        'card_holder_name' => $paymentResponse->paymentMethod->cardholderName,
                        'month' => sprintf("%02d", $monthYear[1]), //$monthYear[1], //sprintf("%02d", $monthYear[1])
                        'year' =>  $monthYear[0],
                    ]);

                    if ($res) {
                        //Update Applicant status in APPPLICANT TABLE
                        $status = applicant::where([
                            ['client_id', '=', Auth::user()->id],
                            ['destination_id', '=', $id],
                        ])
                            ->orderBy('id', 'DESC')
                            ->first();
                        if ($status === null) {
                        } else {
                            if ($status->application_stage_status == 1) {
                                $status->application_stage_status = '2';
                                $status->save();
                            }
                        }
                        // Save Payment Info
                        $card = cardDetail::where('client_id', '=', Auth::user()->id)->first();

                        // Send Notifications on This Payment ##############
                        $email = Auth::user()->email;
                        $userID = Auth::user()->id;

                        if ($paymentDetails['payment_type'] == "FIRST" || $paymentDetails['payment_type'] == "BALANCE_ON_FIRST") {
                            $ems = "";
                        } else if ($paymentDetails['payment_type'] == "SUBMISSION") {
                            $ems = " You will be notified when your Work Permit is ready.";
                        } else {
                            $ems = " You will be notified when your embassy appearance date is set.";
                        }

                        // $criteria = ucFirst(strtolower($paymentDetails['payment_type'])) . " Payment Completed!";
                        // $message = "You have successfully made your " . $paymentDetails['payment_type'] . ". Check your receipt on 'My Application'" . $ems;

                        $paym = ucwords(strtolower(str_replace('_', ' ', $paymentDetails['payment_type'])));

                        $criteria = $paym . " Payment Completed!";
                        $message = "You have successfully made your " . $paym . " Payment. Check your receipt on 'My Application'. " . $ems;
              

                        $link = "";

                        $dataArray = [
                            'title' => $criteria . ' Mail from PWG Group',
                            'body' => $message,
                            'link' => $link,
                            'paymentType' => $paymentDetails['payment_type'],
                            'status' => 'payment'
                        ];

                        $check_noti = notifications::where('criteria', '=', $criteria)->where('client_id', '=', Auth::user()->id)->first();

                        if ($check_noti === null) {
                            $tday = date('Y-m-d');

                            DB::table('notifications')->insert(
                                ['client_id' => $userID, 'message' => $message, 'criteria' => $criteria, 'link' => $link, 'created_at' => $tday]
                            );

                            Mail::to($email)->send(new NotifyMail($dataArray));
                        }
                        // Notification Ends ############ 
                        $dest = product::find($id);
                        $dest_name = $dest->name;
                        $payment = $this->getPaymentName();

                        Quickbook::updateTokenAccess();
                        Quickbook::createInvoice($payment);

                        $msg = "Awesome! Payment Successful!";
                        Session::forget('paymentCreds');
                        return view('user.payment-success', compact('id'));
                    } else {
                        Session::forget('paymentCreds');
                        return \Redirect::route('payment-fail', $id);
                    }
                } else {
                    Session::forget('paymentCreds');
                    return \Redirect::route('payment-fail', $id);
                }
            } else {
                Session::forget('paymentCreds');
                return \Redirect::route('payment-fail', $id);
            }
        } catch (Exception $e) {
            return \Redirect::route('myapplication')->with('error', $e->getMessage());
        }
    }

    public function paymentFail()
    {
        //Undo Application payment info
        $pays = payment::where('id', Session::get('paymentId'))->first();

        $datas = applicant::where([
            ['client_id', '=', Auth::user()->id],
            ['id', '=', $pays->application_id],
        ])
        ->orderBy('id', 'DESC')
        ->first();

        if ($datas === null) {
        } else {
            if ($pays->payment_type == 'FIRST') {
                if ($datas->first_payment_status == 'PARTIALLY_PAID') {
                    // $datas->first_payment_paid = $datas->first_payment_paid - $pays->paid_amount;
                    //    $datas->first_payment_vat = 0;
                    //    $datas->first_payment_discount = 0;
                    $datas->first_payment_status = 'PARTIALLY_PAID';
                    // $datas->first_payment_remaining =  $datas->first_payment_remaining - $pays->paid_amount;
                } else {
                    $datas->first_payment_price = 0;
                    $datas->first_payment_paid = 0;
                    $datas->first_payment_vat = 0;
                    $datas->first_payment_discount = 0;
                    $datas->first_payment_status = 'PENDING';
                    $datas->first_payment_remaining =  0;
                    $datas->is_first_payment_partially_paid = 0;
                    $datas->status = 'PENDING';
                    //Undo Payment update
                    // Payment::where('id', Session::get('paymentId'))->delete();
                }
            } elseif ($pays->payment_type == 'BALANCE_ON_FIRST') {
                //    $datas->first_payment_price = 0;
                // $datas->first_payment_paid = $datas->first_payment_paid - $pays->paid_amount;
                //    $datas->first_payment_vat = 0;    
                //    $datas->first_payment_discount = 0;
                $datas->first_payment_status = 'PARTIALLY_PAID';
                // $datas->first_payment_remaining =  $datas->first_payment_remaining - $pays->paid_amount;
                //    $datas->is_first_payment_partially_paid = 0;
                //    $datas->status = 'PENDING';
            } elseif ($pays->payment_type == 'SUBMISSION') {
                $datas->submission_payment_price = 0;
                $datas->submission_payment_paid = 0;
                $datas->submission_payment_vat = 0;
                $datas->submission_payment_discount = 0;
                $datas->submission_payment_status = 'PENDING';
                $datas->status = 'PENDING';
                $datas->is_submission_payment_partially_paid = 0;
                // //Undo Payment update
                // Payment::where('id', Session::get('paymentId'))->delete();
            } elseif ($pays->payment_type == 'SECOND') {
                $datas->second_payment_price = 0;
                $datas->second_payment_paid = 0;
                $datas->second_payment_vat = 0;
                $datas->second_payment_discount = 0;
                $datas->second_payment_status = 'PENDING';
                $datas->status = 'PENDING';
                $datas->is_second_payment_partially_paid = 0;
                // //Undo Payment update
                // Payment::where('id', Session::get('paymentId'))->delete();
            } elseif ($pays->payment_type == 'Full-Outstanding Payment') {
                if ($datas->first_payment_status == 'PENDING') {
                    $datas->first_payment_price = 0;
                    $datas->first_payment_paid = 0;
                    $datas->first_payment_vat = 0;
                    $datas->first_payment_discount = 0;
                    $datas->first_payment_status = 'PENDING';
                    $datas->first_payment_remaining =  0;
                    $datas->is_first_payment_partially_paid = 0;
                }
                $datas->status = 'PENDING';
                $datas->submission_payment_price = 0;
                $datas->submission_payment_paid = 0;
                $datas->submission_payment_vat = 0;
                $datas->submission_payment_discount = 0;
                $datas->submission_payment_status = 'PENDING';
                $datas->status = 'PENDING';
                $datas->is_submission_payment_partially_paid = 0;
                $datas->second_payment_price = 0;
                $datas->second_payment_paid = 0;
                $datas->second_payment_vat = 0;
                $datas->second_payment_discount = 0;
                $datas->second_payment_status = 'PENDING';
                $datas->status = 'PENDING';
                $datas->is_second_payment_partially_paid = 0;
                $datas->total_price = 0;
                $datas->total_paid = 0;
                $datas->total_vat = 0;
                $datas->total_discount = 0;
                // //Undo Payment update
                // Payment::where('id', Session::get('paymentId'))->delete();
            }
            $datas->save();
        }
        //Undo Payment update
        Payment::where('id', Session::get('paymentId'))->delete();
        $id = Session::get('myproduct_id');
        return view('user.payment-fail', compact('id'));
    }


    public function getPromo(Request $request)
    {
        $response['status'] = false;
        $id = Session::get('myproduct_id');
        $coupon = DB::table('coupons')
            ->select('amount')
            ->where('code', '=', strip_tags($request->discount_code))
            ->where('employee_id', '=', $id)
            ->where('active_from', '<=', date('Y-m-d'))
            ->where('active_until', '>=', date('Y-m-d'))
            ->where('active', '=', 1)
            ->get();

        foreach ($coupon as $apply) {
            $my_discount = $apply->amount;
        }


        if ($coupon->first()) {

            $discountPercent = 'PROMO: ' . $my_discount . '%';
            $discountamt = ($my_discount *  $request->totaldue) / 100;

            $topaynow = $request->totaldue  - (($my_discount *  $request->totaldue) / 100);
            if ($request->vat > 0) {
                $vatNow = ($topaynow_temp *  5) / 100;
                $topaynow = $topaynow_temp + $vatNow;
            } else {
                $topaynow = $topaynow_temp;
                $vatNow = 0;
            }

            Session::put('haveCoupon', 1);
            Session::put('myDiscount', $my_discount);
            Session::put('discountapplied', 1);

            $response['myDiscount'] = $my_discount;
            $response['haveCoupon'] = 1;
            $response['discountamt'] = $discountamt;
            $response['topaynow'] = $topaynow;
            $response['vatNow'] = $vatNow;
            $response['discountPercent'] = $discountPercent;

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
            ->where('active', '=', 1)
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
            // return redirect()->back()->with('failed', 'You are not authorized');
            return redirect('home');
        }
    }

    public function contract($productId)
    {
        //     $user = User::find(Auth::id());
        //     $signatureUrl = (isset($user->getMedia(User::$media_collection_main_signture)[0])) ? $user->getMedia(User::$media_collection_main_signture)[0]->getUrl() : null;

        if (Auth::id()) {
            $originalPdf = null;
            $destination_file = null;
            $newFileName = null;

            $productName = DB::table('destinations')
                ->where('id', $productId)
                ->pluck('name')
                ->first();
            $productName = strtolower($productName);

            if ($productName == Constant::poland) {
                $originalPdf = "pdf/poland.pdf";
                $rand = UserHelper::getRandomString();
                $newFileName = 'contract' . Auth::id() . '-' . $rand . '-' . 'poland.pdf';
            } else if ($productName == Constant::czech) {
                $originalPdf = "pdf/czech.pdf";
                $rand = UserHelper::getRandomString();
                $newFileName = 'contract' . Auth::id() . '-' . $rand . '-' . 'czech.pdf';
            } else if ($productName == Constant::malta) {
                $originalPdf = "pdf/malta.pdf";
                $rand = UserHelper::getRandomString();
                $newFileName = 'contract' . Auth::id() . '-' . $rand . '-' . 'malta.pdf';
            } else if ($productName == Constant::canada) {
                if (Session::get('packageType') == Constant::CanadaExpressEntry) {
                    $originalPdf = "pdf/canada_express_entry.pdf";
                    $rand = UserHelper::getRandomString();
                    $newFileName = 'contract' . Auth::id() . '-' . $rand . '-' . 'canada_express_entry.pdf';
                } else if (Session::get('packageType') == Constant::CanadaStudyPermit) {
                    $originalPdf = "pdf/canada_study.pdf";
                    $rand = UserHelper::getRandomString();
                    $newFileName = 'contract' . Auth::id() . '-' . $rand . '-' . 'canada_study.pdf';
                } else if (Session::get('packageType') == Constant::BlueCollar) {
                    $originalPdf = "pdf/canada.pdf";
                    $rand = UserHelper::getRandomString();
                    $newFileName = 'contract' . Auth::id() . '-' . $rand . '-' . 'canada.pdf';
                }
            } else if ($productName == Constant::germany) {
                $originalPdf = "pdf/poland.pdf";
                $rand = UserHelper::getRandomString();
                $newFileName = 'contract' . Auth::id() . '-' . $rand . '-' . 'germany.pdf';
            } else {
                $originalPdf = "pdf/poland.pdf";
                $rand = UserHelper::getRandomString();
                $newFileName = 'contract' . Auth::id() . '-' . $rand . '-' . 'germany.pdf';
            }
            if ($newFileName && $originalPdf) {
                // $destination_file = 'pdf/'.$newFileName;
                // public_path('storage/Applications/Contracts/client_contracts/'.$newFileName);
                $destination_file = 'Applications/Contracts/client_contracts/' . $newFileName;
                $data = pdfBlock::mapDetails($originalPdf, $destination_file, $productName, Session::get('packageType'));
                Session::put('contract', $newFileName);
                Applicant::where('client_id', Auth::id())
                    ->where('destination_id', $productId)
                    ->where('work_permit_category', (Session::get('packageType')) ?? 'BLUE_COLLAR')
                    ->update([
                        'contract' => $newFileName
                    ]);
                // $fileUrl = Storage::disk('local')->url('Applications/Contracts/client_contracts/'.$newFileName);
                if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                    $fileUrl = Storage::disk(env('MEDIA_DISK'))->url('Applications/Contracts/client_contracts/' . $newFileName);
                } else {
                    $fileUrl = Storage::disk('local')->url('Applications/Contracts/client_contracts/' . $newFileName);
                }
                return view('user.contract', compact('productId', 'newFileName', 'fileUrl'));
            }
        } else {
            return redirect('home');
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
            'year' => 'required|numeric|digits:4|max:' . (date('Y') + 100)

        ]);

        if ($validator->fails()) {
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
                $data->card_holder_name = preg_replace("/[^A-Za-z- ]/", '', strip_tags($request->name));

                $data->card_number = $request->card_number;
                $data->month = sprintf("%02d", $request->month);  //sprintf("%02d", $monthYear[1])
                $data->year = $request->year;
                $data->cvv = $request->cvc;

                $data->save();
            } else {

                $datas->client_id = Auth::user()->id;
                $datas->card_holder_name = preg_replace("/[^A-Za-z- ]/", '', strip_tags($request->name));

                $datas->card_number = $request->card_number;
                $datas->month = sprintf("%02d", $request->month);
                $datas->year = $request->year;
                $datas->cvv = $request->cvc;

                $datas->save();
            }
        }
        return response()->json(['status' => 'Saved']);
    }

    public function mark_read(Request $request)
    {

        $notis = notifications::where('client_id', '=', Auth::user()->id)->get();

        if ($notis) {
            foreach ($notis as $noti) {
                $noti->status = 'Read';
                $noti->save();
            }
        }
        return response()->json(['status' => 'Cleared']);
    }

    public function getReceipt($ptype)
    {
        if (Auth::id()) {
            $apply = DB::table('applications')
                ->where('client_id', '=', Auth::user()->id)
                ->orderBy('id', 'DESC')
                ->first();

            $applicant_id = $apply->id;

            $user = DB::table('payments')
                ->where('application_id', $applicant_id)
                ->where('payment_type', $ptype)
                ->orderBy('id', 'DESC')
                ->get();

            $pricing = DB::table('pricing_plans')
                ->where('destination_id', $apply->destination_id)
                ->where('id', $apply->pricing_plan_id)
                ->where('status', 'CURRENT')
                ->first();

            $pdf = PDF::loadView('user.receipt', compact('user', 'apply', 'pricing'));

            return $pdf->stream("", array("Attachment" => false));
            // exit(0);
            // return $pdf->download('receipt.pdf');
        } else {
            return redirect('home');
        }
    }

    public function getInvoice($ptype = null)
    {
        Quickbook::updateTokenAccess();
        $dataService = Quickbook::connectQucikBook();

        //$payment = $dataService->Query("select * from Payment");
        $paymentDetails = Payment::where('id', Session::get('paymentId'))
            ->first();
        if(isset($ptype)) {
            $apply = Applicant::where('client_id', Auth::id())
                ->orderBy('id', 'DESC')
                ->first();

            $paymentDetailsBasedType  =  Payment::where('application_id', $apply->id)
                ->where('payment_type', $ptype)
                ->orderBy('id', 'DESC')
                ->first();
                // dd($apply->id);
            if ($paymentDetailsBasedType) {
            } else {
                $paymentDetailsBasedType  =  Payment::where('application_id', $apply->id)
                    ->orderBy('id', 'DESC')
                    ->first();
            }
            $paymentDetails =  $paymentDetailsBasedType;
        }
        // dd($paymentDetails);
        if ($paymentDetails->payment_type == 'Full-Outstanding Payment') {
            $filename = Auth::user()->name . '-' . $paymentDetails->payment_type . '-' . "Invoice.pdf";
            $invoice = $dataService->FindById("Invoice", $paymentDetails->invoice_id);
            if ($invoice) {
                $pdfData = $dataService->DownloadPDF($invoice, null, true);
            } else {
                return self::getInvoiceDevelop($paymentDetails->payment_type);
            }
        } else {
            if ($paymentDetails->payment_type == 'FIRST' || $paymentDetails->payment_type == 'BALANCE_ON_FIRST') {
                $firstPaymentDue = Payment::where('application_id', $paymentDetails->application_id)
                    ->where('payment_type', 'BALANCE_ON_FIRST')
                    ->count();
                if ($firstPaymentDue > 0) {
                    if ($ptype) {
                        $paymentDetails  =  Payment::where('application_id', $apply->id)
                            ->where('payment_type', $ptype)
                            ->first();
                        $filename = Auth::user()->name . '-' . $paymentDetails->payment_type . '-' . "Invoice.pdf";
                        $invoice = $dataService->FindById("Invoice", $paymentDetails->invoice_id);
                        if ($invoice) {
                            $pdfData = $dataService->DownloadPDF($invoice, null, true);
                        } else {
                            return self::getInvoiceDevelop($paymentDetails->payment_type);
                        }
                    } else {
                        $filename = Auth::user()->name . '-' . $paymentDetails->payment_type . '-' . "Receipt.pdf";
                        $reciept = $dataService->FindById("Payment", $paymentDetails->invoice_id);
                        $pdfData = $dataService->DownloadPDF($reciept, null, true);
                    }
                } else {
                    $filename = Auth::user()->name . '-' . $paymentDetails->payment_type . '-' . "Invoice.pdf";
                    $invoice = $dataService->FindById("Invoice", $paymentDetails->invoice_id);
                    if ($invoice) {
                        $pdfData = $dataService->DownloadPDF($invoice, null, true);
                    } else {
                        return self::getInvoiceDevelop($paymentDetails->payment_type);
                    }
                }
            } else {
                $filename = Auth::user()->name . '-' . $paymentDetails->payment_type . '-' . "Invoice.pdf";
                $invoice = $dataService->FindById("Invoice", $paymentDetails->invoice_id);
                if ($invoice) {
                    $pdfData = $dataService->DownloadPDF($invoice, null, true);
                } else {
                    return self::getInvoiceDevelop($paymentDetails->payment_type);
                }
            }
        }
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($pdfData));
        ob_clean();
        flush();
        echo $pdfData;
    }

    private function getPaymentName()
    {
        $applicant = Applicant::select('*')
            ->where('client_id', Auth::id())
            ->orderBy('id', 'DESC')
            ->first();
        $payment = Payment::where('application_id', $applicant->id)
            ->orderBy('id', 'DESC')
            ->pluck('payment_type')
            ->first();

        return $payment;
    }

    public static function getInvoiceDevelop($ptype)
    {
        if (Auth::id()) {
            $apply = DB::table('applications')
                ->where('client_id', '=', Auth::user()->id)
                ->orderBy('id', 'DESC')
                ->first();

            $applicant_id = $apply->id;

            $user = DB::table('payments')
                ->where('application_id', $applicant_id)
                ->where('payment_type', $ptype)
                ->orderBy('id', 'DESC')
                ->first();

            $pricing = DB::table('pricing_plans')
                ->where('destination_id', $apply->destination_id)
                ->where('id', $apply->pricing_plan_id)
                ->where('status', 'CURRENT')
                ->first();
                // dd($pricing);
            $pdf = PDF::loadView('user.invoice', compact('user', 'apply', 'pricing'));

            return $pdf->stream("", array("Attachment" => false));
            // return $pdf->download('receipt.pdf');
        } else {
            return redirect('home');
        }
    }

    public function getQuickbookToken()
    {
        $dataService = DataService::Configure(array(
            'auth_mode' => 'oauth2',
            'ClientID' => config('services.quickbook.client_id'),
            'ClientSecret' =>  config('services.quickbook.client_secret'),
            'RedirectURI' => config('services.quickbook.oauth_redirect_uri'),
            'scope' => config('services.quickbook.oauth_scope'),
            'baseUrl' => "development"
        ));

        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $parseUrl = self::parseAuthRedirectUrl(htmlspecialchars_decode($_SERVER['QUERY_STRING']));

        /*
         * Update the OAuth2Token
         */
        $accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($parseUrl['code'], $parseUrl['realmId']);
        $dataService->updateOAuth2Token($accessToken);

        /*
         * Setting the accessToken for session variable
         */
        Session::put('sessionAccessToken', $accessToken);
    }

    private static function parseAuthRedirectUrl($url)
    {
        parse_str($url, $qsArray);
        return array(
            'code' => $qsArray['code'],
            'realmId' => $qsArray['realmId']
        );
    }

    public static function checkQuickbook()
    {
        $data = QuickModel::first();
        if ($data) {
            return true;
        } else {
            return false;
        }
    }

    public function disconnectQuickbook()
    {
        return view('disconnect-quickbook');
    }

    public function terms()
    {
        return view('user.terms');
    }

    public function resendVerificationEmail(User $user)
    {
        $id = $user->id;
        $user = User::find($user->id);
        $user->sendEmailVerificationNotification();
        return view('auth.verify-email', compact('id'))->with('message', 'Please check your mail for verification mail.');
    }

    public function autocompleteAgent(Request $request)
    {        

        $data = DB::table('employees')
            ->select('name','sur_name', 'phone_number')
            ->where("name","LIKE","%{$request->str}%")
            ->where('is_active', '=', 1)
            ->whereRaw('name != ""')
            ->whereIn('designation_id', [1,33,35])
            ->orderBy('id','asc')
            ->get('query');

        return response()->json($data);
    }
}
