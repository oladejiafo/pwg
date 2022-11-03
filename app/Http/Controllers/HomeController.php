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
use Config;
use PDF;
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

            $promo = promo::where('active_until', '>=', date('Y-m-d'))->get();

            return view('user.home', compact('package', 'promo'));
        }
    }

    public function index()
    {

        // $package = DB::table('destinations')->orderBy(DB::raw('FIELD(name, "Poland", "Czech", "Malta", "Canada", "Germany")'))->get();
        // $promo = promo::where('active_until', '>=', date('Y-m-d'))->get();

        // return view('user.home', compact('package', 'promo'));

        try {
            $package = DB::table('destinations')->orderBy(DB::raw('FIELD(name, "Poland", "Czech", "Malta", "Canada", "Germany")'))->get();
            $promo = promo::where('active_until', '>=', date('Y-m-d'))->get();
            //Quickbook
            //Quickbook::checkRefreshToken();
            return view('user.home', compact('package', 'promo'));
        } catch (Exception $e){
            Session::put('error', $e->getMessage());
            return view('user.home', compact('package', 'promo'));
        }      

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
            // return redirect()->back()->with('message', 'You are not authorized');
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
            $signature->addMediaFromBase64($request->signed)->usingFileName($signate)->toMediaCollection(User::$media_collection_main_signture);

            $signature->save();

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

            if (Session::has('myproduct_id')) {
                $pid  = Session::get('myproduct_id');
            } else {
                $pid = 1;
            }

            $datas = Applicant::where('client_id', Auth::id())
                ->where('destination_id', $pid)
                ->where('work_permit_category', (Session::get('packageType')) ?? 'BLUE COLLAR')
                ->first();
            $appliedCountry = Product::find($pid);
            if ($datas === null) {
                $data = new applicant();
                $data->client_id = Auth::id();
                $data->destination_id = $pid;
                $data->work_permit_category = (Session::get('packageType')) ?? 'BLUE COLLAR';
                $data->application_stage_status = 1;
                $data->applied_country = $appliedCountry->name;
                $res = $data->save();
            } else {
                $datas->work_permit_category =  (Session::get('packageType')) ?? 'BLUE COLLAR';
                $datas->application_stage_status = 1;
                $datas->destination_id = $pid;
                $datas->applied_country = $appliedCountry->name;
                $res = $datas->save();
            }

            User::where('id', Auth::id())
                ->update([
                    'is_spouse' => $is_spouse,
                    'children_count' => $children
                ]);

            if ($res) {
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
                ->where('pricing_plan_type', '=', 'FAMILY PACKAGE')
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

            // $pays = DB::table('pricing_plans')
            //     ->join('applications', 'applications.destination_id', '=', 'pricing_plans.destination_id')
            //     ->select('applications.destination_id', 'pricing_plans.id', 'pricing_plans.pricing_plan_type', 'pricing_plans.total_price', 'pricing_plans.destination_id', 'pricing_plans.first_payment_price', 'pricing_plans.second_payment_price', 'pricing_plans.third_payment_price')
            //     ->where('pricing_plans.pricing_plan_type', '=', $packageType)
            //     ->where('applications.destination_id', '=', $p_id)
            //     ->where('applications.client_id', '=', $id)
            //     ->orderBy('pricing_plans.id')
            //     ->first();
            $pays = DB::table('pricing_plans')

                // ->join('applications', 'applications.destination_id', '=', 'pricing_plans.destination_id')
                // ->select('applications.destination_id', 'pricing_plans.id', 'pricing_plans.pricing_plan_type', 'pricing_plans.total_price', 'pricing_plans.destination_id', 'pricing_plans.first_payment_price', 'pricing_plans.second_payment_price', 'pricing_plans.third_payment_price')
                // ->where('pricing_plans.pricing_plan_type', '=', $packageType)
                // ->where('applications.destination_id', '=', $p_id)
                // ->where('applications.client_id', '=', $id)
                // ->orderBy('pricing_plans.id')
                // ->first();

                    ->join('applications', 'applications.pricing_plan_id', '=', 'pricing_plans.id')
                    ->select('applications.pricing_plan_id', 'applications.destination_id', 'pricing_plans.id', 'pricing_plans.pricing_plan_type', 'pricing_plans.total_price', 'pricing_plans.destination_id', 'pricing_plans.first_payment_price', 'pricing_plans.second_payment_price', 'pricing_plans.third_payment_price')
                    ->where('pricing_plans.pricing_plan_type', '=', $packageType)
                    ->where('applications.destination_id', '=', $p_id)
                    ->where('applications.client_id', '=', $id)
                    ->orderBy('pricing_plans.id')
                    ->first();
            // $paid = DB::table('payments')
            //     ->join('applications', 'payments.application_id', '=', 'applications.id')
            //     ->selectRaw('payments.*, applications.*, COUNT(payments.id) as count')
            //     ->where('applications.destination_id', '=', $p_id)
            //     ->where('applications.client_id', '=', $id)
            //     ->groupBy('payments.id')
            //     // ->groupBy('applicants.id')
            //     ->orderBy('applications.id', 'desc')
            //     // ->limit(1)
            //     ->first();


            $paid = DB::table('applications')
                ->where('applications.destination_id', '=', $p_id)
                ->where('applications.client_id', '=', $id)
                // ->groupBy('payments.id')
                ->orderBy('applications.id', 'desc')
                ->first();

            $prod = DB::table('destinations')
                ->join('applications', 'destinations.id', '=', 'applications.destination_id')
                ->select('destinations.name', 'destinations.id')
                ->where('applications.client_id', '=', $id)
                ->where('applications.destination_id', '=', $p_id)
                ->groupBy('destinations.id')
                ->first();

            $authUrl = '';
            // $dataService = DataService::Configure(array(
            //     'auth_mode' => 'oauth2',
            //     'ClientID' => config('services.quickbook.client_id'),
            //     'ClientSecret' =>  config('services.quickbook.client_secret'),
            //     'RedirectURI' =>  config('services.quickbook.oauth_redirect_uri'),
            //     'scope' => config('services.quickbook.oauth_scope'),
            //     'baseUrl' => "development"
            // ));

            // $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
            // $authUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();
            return view('user.myapplication', compact('paid', 'pays', 'prod', 'authUrl'));
        } else {
            return redirect('home');
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
            if (isset($complete->work_permit_category) && $complete->third_payment_status == 'PENDING') {
                $packageType = $complete->work_permit_category;
            } elseif (Session::has('packageType')) {
                $packageType = Session::get('packageType');
            } else {
                $packageType = $complete->work_permit_category;
            }

            $data = product::find(Session::get('myproduct_id'));

            $pays = DB::table('applications')
                ->select('applications.pricing_plan_id', 'applications.total_price', 'applications.total_paid', 'applications.first_payment_status', 'applications.second_payment_status', 'applications.third_payment_status', 'first_payment_price', 'first_payment_paid', 'first_payment_remaining', 'is_first_payment_partially_paid', 'second_payment_price', 'second_payment_paid', 'second_payment_remaining', 'third_payment_price', 'third_payment_paid', 'third_payment_remaining')
                ->where('applications.client_id', '=', Auth::user()->id)
                ->where('applications.destination_id', '=', $id)
                ->where('work_permit_category', $packageType)
                // ->whereNotIn('status',  ['APPLICATION_COMPLETED','VISA_REFUSED', 'APPLICATION_CANCELLED','REFUNDED'] )
                ->limit(1)
                ->first();

               
                if(!$pays)
                {
                    return redirect('home');
                    die();
                }
                
                if($packageType=="FAMILY PACKAGE")
                {
                    $pdet = DB::table('pricing_plans')
                    ->where('destination_id', '=', Session::get('myproduct_id'))
                    ->where('pricing_plan_type', '=', $packageType)
                    ->where('no_of_parent', '=', $mySpouse)
                    ->where('no_of_children', '=', $children)
                    ->first();
            } else {
                $pdet = DB::table('pricing_plans')
                    ->where('destination_id', '=', Session::get('myproduct_id'))
                    ->where('pricing_plan_type', '=', $packageType)
                    ->first();
            }

            return view('user.payment-form', compact('data', 'pdet', 'pays', 'payall'));
        } else {
            // return redirect()->back()->with('message', 'You are not authorized');
            return redirect('home');
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
        if (Auth::id()) {
            session()->forget('info');
            $amount = $request->totalpay;

            $id = Session::get('myproduct_id');

            $apply = DB::table('applications')
                ->where('destination_id', '=', $id)
                // ->whereNotIn('status',  ['APPLICATION_COMPLETED','VISA_REFUSED', 'APPLICATION_CANCELLED','REFUNDED'] )
                ->where('client_id', '=', Auth::user()->id)
                ->OrderBy('id', "DESC")
                ->first();
            $applicant_id = $apply->id;
            $vals = array(0, 1, 2);

            if (in_array($apply->application_stage_status, $vals) && (empty($apply->embassy_country) || $apply->embassy_country == null)) {
                $request->validate([
                    'totaldue' => 'required',
                    'totalpay' => 'numeric|gte:1000|lte:'.$request->totaldue,
                    'current_location' => 'required',
                    'embassy_appearance' => 'required'
                ]);
            } else {
                $request->validate([
                    'totaldue' => 'required',
                    'totalpay' => 'numeric'
                ]);
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
            // dd($request->vats);
            $outstand = $request->totalpay + $thisVat;

            if ($request->totaldue == $request->totalpay) {
                $whatsPaid = "Paid";
            } elseif ($request->totaldue > $request->totalpay && $request->totalpay >= 1000) {
                if ($request->totalremaining == $request->totalpay) {
                    $whatsPaid = "Paid";
                } else {
                    $whatsPaid = "Partial";
                }
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
            } else {
                $rre->country_of_residence =  $request->current_location;
                $rre->save();
            }

            set_time_limit(0);

            $outletRef       = '15d885ec-682a-4398-89d9-247254d71c18'; // config('app.payment_reference'); 
            $apikey          = "MmM2ODJiOGMtOGFmNS00NzUyLTg2MjUtM2Y5MTg3OWU5YjRlOjViMzhjM2I5LTUyMDItNDBmZi1hNzAyLTFlYTIwZDkwYjhiMQ=="; //config('app.payment_api_key'); 

            // Test URLS 
            $idServiceURL  = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
            $txnServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/" . $outletRef . "/orders";

            // LIVE URLS 
            //$idServiceURL  = "https://identity.ngenius-payments.com/auth/realms/NetworkInternational/protocol/openid-connect/token";           // set the identity service URL (example only)
            //$txnServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders"; 

            $tokenHeaders  = array("Authorization: Basic " . $apikey, "Content-Type: application/x-www-form-urlencoded");
            $tokenResponse = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
            $tokenResponse = json_decode($tokenResponse);
            // dd($tokenResponse);
            $access_token  = $tokenResponse->access_token;

            $order = array();
            $successUrl = url('/') . '/payment/success';
            $failUrl =  url('/') . '/payment/fail';

            $order['action']                        = "PURCHASE";                      // Transaction mode ("AUTH" = authorize only, no automatic settle/capture, "SALE" = authorize + automatic settle/capture)
            $order['amount']['currencyCode']       = "AED";                           // Payment currency ('AED' only for now)
            $order['amount']['value']                = ($amount) * 100;              // Minor units (1000 = 10.00 AED)
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
                    'totalpay' => $request->totalpay
                ];
                if ($datas === null) {
                    $data = new applicant;
                    if (in_array($apply->application_stage_status, $vals) && (empty($apply->embassy_country) || $apply->embassy_country == null)) {
                        $data->embassy_country = $request->embassy_appearance;
                    }
                    $data->pricing_plan_id = $request->ppid;

                    if ($request->whichpayment == 'First Payment') {
                        // $data->first_payment_price = $thisPayment;
                        // $data->first_payment_paid = $thisPaymentMade;
                        $data->first_payment_vat = $thisVat;
                        $data->first_payment_discount = $thisDiscount;
                    } elseif ($request->whichpayment == 'Second Payment') {
                        $data->second_payment_price = $thisPayment;
                        $data->second_payment_paid = $thisPaymentMade;
                        $data->second_payment_vat = $thisVat;
                        $data->second_payment_discount = $thisDiscount;
                    } elseif ($request->whichpayment == 'Third Payment') {
                        $data->third_payment_price = $thisPayment;
                        $data->third_payment_paid = $thisPaymentMade;
                        $data->third_payment_vat = $thisVat;
                        $data->third_payment_discount = $thisDiscount;
                        $data->coupon_code = $thisCode;
                        $res = $data->save();
                    } else {

                        $data->total_price = $thisPayment;
                        $data->total_vat = $thisVat;
                        $data->total_discount = $thisDiscount;
                        //Splits
                        $paysplit = DB::table('pricing_plans')
                            ->where('destination_id', '=', $request->pid)
                            ->first();

                        $paymentCreds['paysplit'] = $paysplit;

                        if (isset($paysplit)) {
                            //First Split
                            if (isset($thisVat) && $thisVat > 0) {
                                $firstVat = ($paysplit->first_payment_price * 5) / 100;
                            } else {
                                $firstVat = 0;
                            }
                            $paymentCreds['firstVat'] = $firstVat;

                            $data->first_payment_price = $paysplit->first_payment_price + $firstVat;
                            $data->first_payment_vat = $firstVat;
                            // $data->first_payment_discount = $thisDiscount;

                            //Second Split
                            if (isset($thisVat) && $thisVat > 0) {
                                $secondVat = ($paysplit->second_payment_price * 5) / 100;
                            } else {
                                $secondVat = 0;
                            }
                            $paymentCreds['secondVat'] = $secondVat;

                            $data->second_payment_price = $paysplit->second_payment_price + $secondVat;
                            $data->second_payment_vat = $secondVat;
                            // $data->second_payment_discount = $thisDiscount;

                            //Third Split
                            if (isset($thisVat) && $thisVat > 0) {
                                $thirdVat = ($paysplit->third_payment_price * 5) / 100;
                            } else {
                                $thirdVat = 0;
                            }
                            $paymentCreds['thirdVat'] = $thirdVat;

                            $data->third_payment_price = $paysplit->third_payment_price + $thirdVat;
                            $data->third_payment_vat = $thirdVat;
                            $data->third_payment_discount = $thisDiscount;
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

                    if ($request->whichpayment == 'First Payment') {
                        // $datas->first_payment_price = $thisPayment;
                        // $datas->first_payment_paid = $thisPaymentMade;

                        $datas->first_payment_vat = $thisVat;
                        $datas->first_payment_discount = $thisDiscount;

                        if (isset($request->totalremaining) && $request->totalremaining > 0) {
                        } else {
                            $datas->first_payment_price = $thisPayment;
                        }
                    } elseif ($request->whichpayment == 'Second Payment') {
                        $datas->second_payment_price = $thisPayment;
                        $datas->second_payment_vat = $thisVat;
                        $datas->second_payment_discount = $thisDiscount;
                    } elseif ($request->whichpayment == 'Third Payment') {
                        $datas->third_payment_price = $thisPayment;
                        $datas->third_payment_vat = $thisVat;
                        $datas->third_payment_discount = $thisDiscount;
                    } else {
                        $datas->total_price = $thisPayment;
                        $datas->total_vat = $thisVat;
                        $datas->total_discount = $thisDiscount;
                        //Splits
                        $paysplit = DB::table('pricing_plans')
                            ->where('destination_id', '=', $request->pid)
                            ->first();
                        $paymentCreds['paysplit'] = $paysplit;

                        if (isset($paysplit)) {
                            //First Split
                            if (isset($thisVat) && $thisVat > 0) {
                                $firstVat = ($paysplit->first_payment_price * 5) / 100;
                            }
                            $paymentCreds['firstVat'] = $firstVat;

                            $datas->first_payment_price = $paysplit->first_payment_price + $firstVat;
                            $datas->first_payment_vat = $firstVat;
                            // $datas->first_payment_discount = $thisDiscount;

                            //Second Split
                            if (isset($thisVat) && $thisVat > 0) {
                                $secondVat = ($paysplit->second_payment_price * 5) / 100;
                            }
                            $datas->second_payment_price = $paysplit->second_payment_price + $secondVat;
                            $datas->second_payment_vat = $secondVat;
                            // $datas->first_payment_discount = $thisDiscount;
                            $paymentCreds['secondVat'] = $secondVat;

                            //Third Split
                            if (isset($thisVat) && $thisVat > 0) {
                                $thirdVat = ($paysplit->third_payment_price * 5) / 100;
                            }
                            $datas->third_payment_price = $paysplit->third_payment_price + $thirdVat;
                            $datas->third_payment_vat = $thirdVat;
                            $datas->third_payment_discount = $thisDiscount;
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
    }


    public function paymentSuccess()
    {
        session_start();
        $id = Session::get('myproduct_id');
        $outletRef           = config('app.payment_reference');
        $apikey          = config('app.payment_api_key');
        $orderReference  = $_GET['ref'];
        //$orderReference  = 'd4008299-a923-4fde-9107-e0af33114549'; 
        //$idServiceURL    = "https://identity.ngenius-payments.com/auth/realms/Networkinternational/protocol/openid-connect/token";           // set the identity service URL (example only)
        //$residServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 

        $idServiceURL    = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
        $residServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/" . $outletRef . "/orders/" . $orderReference;


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
                $paymentCreds = Session::get('paymentCreds');
                $data = applicant::where([
                    ['client_id', '=', Auth::user()->id],
                    ['destination_id', '=', $id],
                ])
                    ->orderBy('id', 'DESC')
                    ->first();
                if ($paymentCreds['whichpayment'] == 'First Payment') {
                    $data->first_payment_status = $paymentCreds['whatsPaid'];
                    if ($paymentCreds['whatsPaid'] == 'Partial') { // add in payment success
                        $data->first_payment_remaining =  $paymentCreds['thisPayment'] - $paymentCreds['thisPaymentMade']; // add in payment success

                        $data->is_first_payment_partially_paid = 1; // add in payment success
                        $data->status = 'WAITING_FOR_BALANCE_ON_FIRST_PAYMENT'; // add in payment success
                    } else { // add in payment success
                        $data->first_payment_remaining = 0; // add in payment success

                        $data->is_first_payment_partially_paid = 0; // add in payment success
                        $data->status = 'WAITING_FOR_2ND_PAYMENT'; // add in payment success
                    }
                    if (isset($paymentCreds['totalremaining']) && $paymentCreds['totalremaining'] > 0) { // add in payment success
                        //     // $data->first_payment_price = $thisPayment;
                        $data->first_payment_paid = $paymentCreds['thisPaymentMade'] + $paymentCreds['totalremaining']; // add in payment success
                    } else { // add in payment success
                        $data->first_payment_price = $paymentCreds['thisPayment']; // add in payment success
                        $data->first_payment_paid = $paymentCreds['thisPaymentMade']; // add in payment success
                    }
                } elseif ($paymentCreds['whichpayment'] == 'Second Payment') {
                    $data->second_payment_paid = $paymentCreds['thisPaymentMade']; // add in payment success
                    $data->second_payment_status = $paymentCreds['whatsPaid'];  // add in payment success
                    $data->status = 'WAITING_FOR_3RD_PAYMENT';  // add in payment success
                    if ($paymentCreds['whatsPaid'] == 'Partial') { // add in payment success
                        $data->is_second_payment_partially_paid = 1; // add in payment success
                    } // add in payment success
                } elseif ($paymentCreds['whichpayment'] == 'Third Payment') {
                    $data->third_payment_paid = $paymentCreds['thisPaymentMade']; // add in payment success
                    $data->third_payment_status = $paymentCreds['whatsPaid']; // add in payment success
                    $data->status = 'WAITING_FOR_EMBASSY_APPEARANCE'; // add in payment success
                    if ($paymentCreds['whatsPaid'] == 'Partial') { // add in payment success
                        $data->is_third_payment_partially_paid = 1; // add in payment success
                    } // add in payment success
                } else {
                    $data->total_paid = $paymentCreds['thisPaymentMade']; // add in payment success
                    $data->status = 'WAITING_FOR_EMBASSY_APPEARANCE'; // add in payment success
                    if ($paymentCreds['paysplit']) {
                        $data->first_payment_paid = $paymentCreds['paysplit']->first_payment_price + $paymentCreds['firstVat']; // add in payment success
                        $data->first_payment_status = 'Paid'; // add in payment success
                        $data->second_payment_paid = $paymentCreds['paysplit']->second_payment_price + $paymentCreds['secondVat']; // add in payment success
                        $data->second_payment_status = 'Paid'; // add in payment success
                        $data->third_payment_paid = $paymentCreds['paysplit']->third_payment_price + $paymentCreds['thirdVat']; // add in payment success
                        $data->third_payment_status = 'Paid'; // add in payment success
                    }
                }
                $data->save();
                $paymentDetails->update([
                    'paid_amount' => $paymentCreds['totalpay'],
                    'currency' => $paymentResponse->amount->currencyCode,
                    'bank_reference_no' => $paymentResponse->authResponse->authorizationCode,
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

                    if ($paymentDetails['payment_type'] == "First Payment") {
                        $ems = "";
                    } else if ($paymentDetails['payment_type'] == "Second Payment") {
                        $ems = " You will be notified when your Work Permit is ready.";
                    } else {
                        $ems = " You will be notified when your embassy appearance date is set.";
                    }

                    $criteria = $paymentDetails['payment_type'] . " Completed!";
                    $message = "You have successfully made your " . $paymentDetails['payment_type'] . ". Kindly login to the PWG Client portal and check your receipt on 'My Application'" . $ems;

                    $link = "";

                    $dataArray = [
                        'title' => $criteria . ' Mail from PWG Group',
                        'body' => $message,
                        'link' => $link
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

                    //Quickbook::updateTokenAccess();
                    // Quickbook::createInvoice($payment);

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
            if ($pays->payment_type == 'First Payment') {
                $datas->first_payment_price = 0;
                $datas->first_payment_paid = 0;
                $datas->first_payment_vat = 0;
                $datas->first_payment_discount = 0;
                $datas->first_payment_status = 'PENDING';
                $datas->first_payment_remaining =  0;
                $datas->is_first_payment_partially_paid = 0;
                $datas->status = 'PENDING';
            } elseif ($pays->payment_type == 'Balance on First Payment') {
                //    $datas->first_payment_price = 0;
                $datas->first_payment_paid = $datas->first_payment_paid - $pays->paid_amount;
                //    $datas->first_payment_vat = 0;
                //    $datas->first_payment_discount = 0;
                $datas->first_payment_status = 'Partial';
                $datas->first_payment_remaining =  $datas->first_payment_remaining - $pays->paid_amount;
                //    $datas->is_first_payment_partially_paid = 0;
                //    $datas->status = 'PENDING';
            } elseif ($pays->payment_type == 'Second Payment') {
                $datas->second_payment_price = 0;
                $datas->second_payment_paid = 0;
                $datas->second_payment_vat = 0;
                $datas->second_payment_discount = 0;
                $datas->second_payment_status = 'PENDING';
                $datas->status = 'PENDING';
                $datas->is_second_payment_partially_paid = 0;
            } elseif ($pays->payment_type == 'Third Payment') {
                $datas->third_payment_price = 0;
                $datas->third_payment_paid = 0;
                $datas->third_payment_vat = 0;
                $datas->third_payment_discount = 0;
                $datas->third_payment_status = 'PENDING';
                $datas->status = 'PENDING';
                $datas->is_third_payment_partially_paid = 0;
            } elseif ($pays->payment_type == 'Full-Outstanding Payment') {
                $datas->first_payment_price = 0;
                $datas->first_payment_paid = 0;
                $datas->first_payment_vat = 0;
                $datas->first_payment_discount = 0;
                $datas->first_payment_status = 'PENDING';
                $datas->first_payment_remaining =  0;
                $datas->is_first_payment_partially_paid = 0;
                $datas->status = 'PENDING';
                $datas->second_payment_price = 0;
                $datas->second_payment_paid = 0;
                $datas->second_payment_vat = 0;
                $datas->second_payment_discount = 0;
                $datas->second_payment_status = 'PENDING';
                $datas->status = 'PENDING';
                $datas->is_second_payment_partially_paid = 0;
                $datas->third_payment_price = 0;
                $datas->third_payment_paid = 0;
                $datas->third_payment_vat = 0;
                $datas->third_payment_discount = 0;
                $datas->third_payment_status = 'PENDING';
                $datas->status = 'PENDING';
                $datas->is_third_payment_partially_paid = 0;
                $datas->total_price = 0;
                $datas->total_paid = 0;
                $datas->total_vat = 0;
                $datas->total_discount = 0;
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


            Session::put('haveCoupon', 1);
            Session::put('myDiscount', $my_discount);

            $response['myDiscount'] = $my_discount;
            $response['haveCoupon'] = 1;
            $response['discountamt'] = $discountamt;
            $response['topaynow'] = $topaynow;
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
        if (Auth::id()) {
            if(Session::get('myproduct_id') == Constant::Poland){
                $destinationPath = "pdf/poland-low.pdf";
                $rand = UserHelper::getRandomString();
                $newFileName = Auth::id().'-'.$rand.'-'.'poland.pdf';
                $originathpath = "pdf/".$newFileName;
                $data = pdfBlock::mapDetails($destinationPath, $originathpath);
                return view('user.contract', compact('productId'));
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
            // dd($datas);
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
                ->first();

            $pdf = PDF::loadView('user.receipt', compact('user', 'apply', 'pricing'));

            return $pdf->stream("", array("Attachment" => false));
            // return $pdf->download('receipt.pdf');
        } else {
            return redirect('home');
        }
    }

    public function getInvoice($ptype = null)
    {
        // QuickcheckRefreshTokenbook::updateTokenAccess();
        // $dataService = Quickbook::connectQucikBook();

        //$payment = $dataService->Query("select * from Payment");
        $paymentDetails = Payment::where('id', Session::get('paymentId'))
                                    ->first();
        if ($ptype) {
            $apply = Applicant::where('client_id', Auth::id())
                ->orderBy('id', 'DESC')
                ->first();

            $paymentDetailsBasedType  =  Payment::where('application_id', $apply->id)
                ->where('payment_type', $ptype)
                ->orderBy('id', 'DESC')
                ->first();
            if ($paymentDetailsBasedType) {
            } else {
                $paymentDetailsBasedType  =  Payment::where('application_id', $apply->id)
                    ->orderBy('id', 'DESC')
                    ->first();
            }
            $paymentDetails =  $paymentDetailsBasedType;
        }
        if ($paymentDetails->payment_type == 'Full-Outstanding Payment') {
            $filename = Auth::user()->name . '-' . $paymentDetails->payment_type . '-' . "Invoice.pdf";
            // $invoice = $dataService->FindById("Invoice", $paymentDetails->invoice_id);
            // if ($invoice) {
                // $pdfData = $dataService->DownloadPDF($invoice, null, true);
            // } else {
                return self::getInvoiceDevelop($paymentDetails->payment_type);
            // }
        } else {
            if ($paymentDetails->payment_type == 'First Payment') {
                $firstPaymentDue = Payment::where('application_id', $paymentDetails->application_id)
                    ->where('payment_type', 'First Payment')
                    ->count();
                if ($firstPaymentDue == 2) {
                    if ($ptype) {
                        $paymentDetails  =  Payment::where('application_id', $apply->id)
                            ->where('payment_type', $ptype)
                            ->first();
                        $filename = Auth::user()->name . '-' . $paymentDetails->payment_type . '-' . "Invoice.pdf";
                        // $invoice = $dataService->FindById("Invoice", $paymentDetails->invoice_id);
                        // if ($invoice) {
                        //     $pdfData = $dataService->DownloadPDF($invoice, null, true);
                        // } else {
                            return self::getInvoiceDevelop($paymentDetails->payment_type);
                        // }
                    } else {
                        $filename = Auth::user()->name . '-' . $paymentDetails->payment_type . '-' . "Receipt.pdf";
                        // $reciept = $dataService->FindById("Payment", $paymentDetails->invoice_id);
                        // $pdfData = $dataService->DownloadPDF($reciept, null, true);
                    }
                } else {
                    $filename = Auth::user()->name . '-' . $paymentDetails->payment_type . '-' . "Invoice.pdf";
                    // $invoice = $dataService->FindById("Invoice", $paymentDetails->invoice_id);
                    // if ($invoice) {
                    //     $pdfData = $dataService->DownloadPDF($invoice, null, true);
                    // } else {
                        return self::getInvoiceDevelop($paymentDetails->payment_type);
                    // }
                }
            } else {
                $filename = Auth::user()->name . '-' . $paymentDetails->payment_type . '-' . "Invoice.pdf";
                // $invoice = $dataService->FindById("Invoice", $paymentDetails->invoice_id);
                // if ($invoice) {
                //     $pdfData = $dataService->DownloadPDF($invoice, null, true);
                // } else {
                    return self::getInvoiceDevelop($paymentDetails->payment_type);
                // }
            }
        }
        // header('Content-Description: File Transfer');
        // header('Content-Type: application/pdf');
        // header('Content-Disposition: attachment; filename=' . $filename);
        // header('Content-Transfer-Encoding: binary');
        // header('Expires: 0');
        // header('Cache-Control: must-revalidate');
        // header('Pragma: public');
        // header('Content-Length: ' . strlen($pdfData));
        // ob_clean();
        // flush();
        // return $pdfData;
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
                ->first();
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
        Session::put('sessionAccessToken',$accessToken);
    }

    private static function parseAuthRedirectUrl($url)
    {
        parse_str($url, $qsArray);
        return array(
            'code' => $qsArray['code'],
            'realmId' => $qsArray['realmId']
        );
    }
}
