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
            $promo = promo::where('product_id', '=', $id)->where('validity', '>=', date('Y-m-d'))->get();
            $ppay = product_payments::where('product_id', '=', $id)->get();
            $proddet = product_details::where('product_id', '=', $id)->get();

            session()->forget('prod_id');
            return view('user.package', compact('data', 'ppay', 'proddet', 'promo'));
            //   return \Redirect::route('product', $idd);

        } else {
            $package = product::all()->sortBy("id");
            $promo = promo::where('validity', '>=', date('Y-m-d'))->get();
            return view('user.home', compact('package', 'promo'));
        }
    }

    public function index()
    {
        $package = product::all()->sortBy("id");
        $promo = promo::where('validity', '>=', date('Y-m-d'))->get();
        return view('user.home', compact('package', 'promo'));
    }

    public function packageType($productId, Request $request)
    {

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

            $famdet = family_breakdown::where('product_id', '=', $productId)
                ->where('visa_type', 'FAMILY PACKAGE')
                ->where('parent', $parentt)
                ->where('children', $kids)
                ->first();
            if ($request->response == 1) {
                return $famdet;
            }
        } else {
            $famdet = family_breakdown::where('product_id', '=', $productId)->where('visa_type', 'FAMILY PACKAGE')->first();
        }
      
        $proddet = product_details::where('product_id', '=', $productId)->where('visa_type', 'BLUE AND PINK COLLAR JOBS')->get();
        $whiteJobs = product_details::where('product_id', '=', $productId)->where('visa_type', 'WHITE COLLAR JOBS')->get();
        return view('user.package-type', compact('proddet', 'famdet', 'productId', 'whiteJobs', 'data'));
    }

    public function product(Request $request)
    {

        Session::put('packageType', $request->myPack);
        $id = Session::get('myproduct_id');

        session()->forget('totalCost');
        Session::put('totalCost', $request->cost);
        Session::put('fam_id', $request->fam_id);


        $data = product::find($id);
        $promo = promo::where('product_id', '=', $id)->where('validity', '>=', date('Y-m-d'))->get();

        if (Session::get('packageType') == "FAMILY PACKAGE") {
            $ppay = product_payments::where('product_id', '=', $id)
                ->where('product_payments.visa_type', '=', Session::get('packageType'))
                ->where('family_sub_id', '=', Session::get('fam_id'))
                ->get();
        } else {
            $ppay = product_payments::where('product_id', '=', $id)
                ->where('product_payments.visa_type', '=', Session::get('packageType'))
                // ->where('family_sub_id', '=', Session::get('fam_id'))      
                ->get();
        }
        $proddet = product_details::where('product_id', '=', $id)->get();

        session()->forget('prod_id');
        return view('user.package', compact('data', 'ppay', 'proddet', 'promo'));
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

        list($part_a, $image_parts) = explode(";base64,", $request->signed);

        $image_type_aux = explode("image/", $part_a);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts);

        $signate = time() . '.'.$image_type;

        $file = $folderPath . $signate;

        file_put_contents($file, $image_base64);

        $signature = user::find($request->user_id);
        $signature->signature = $signate;
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
        $datas = applicant::where([
            ['user_id', '=', Auth::user()->id],
            ['product_id', '=', $request->pid],
        ])->first();
        if ($datas === null) {
            $data = new applicant();

            $data->user_id = Auth::user()->id;
            $data->first_name = Auth::user()->name;
            $data->visa_type = Session::get('packageType');
            $data->is_spouse = $is_spouse;
            $data->children_count = $children;
            $data->applicant_status = 1;
            $data->product_id = $request->pid;


            $res = $data->save();
        } else {
            $datas->user_id = Auth::user()->id;
            $datas->first_name = Auth::user()->name;
            $datas->visa_type = Session::get('packageType');
            $datas->is_spouse = $is_spouse;
            $datas->children_count = $children;
            $datas->applicant_status = 1;
            $datas->product_id = $request->pid;

            $res = $datas->save();
        }

        if ($res) {
            return \Redirect::route('payment', $request->pid)
            ->with('info', 'Signature Uploaded Successfully!')
            ->with('info_sub', 'Proceed to application');
        } else {
            return redirect()->back()->with('failed', 'Oppss! Something went wrong.');
        }
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
                $applys = DB::table('applicants')
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

            $completed = DB::table('applicants')

            ->where('user_id', '=', Auth::user()->id)
            ->orderBy('id','desc')
            ->get();

            foreach($completed as $complete)
            // {
            // if($completed->first())
            {
              $app_id= $complete->id;
              $p_id= $complete->product_id;
              $hasSpouse = $complete->is_spouse;
              $children = $complete->children_count;
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

            $families = DB::table('family_breakdowns')
                ->where('children', '=', $children)
                ->where('parent', '=', $yesSpouse)
                ->where('visa_type', '=', 'FAMILY PACKAGE')
                ->get();

            foreach ($families as $famili) {
                $famCode = $famili->id;
            }

            if (session()->get('myproduct_id')) {
            } else {
                Session::put('myproduct_id', $p_id);
            }

            if (Session::has('packageType')) {
                $packageType = Session::get('packageType');
            } else {
                $packageType = $complete->visa_type;
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


            if ($packageType == "FAMILY PACKAGE") {
                $pays = DB::table('product_payments')
                    ->join('applicants', 'applicants.product_id', '=', 'product_payments.product_id')
                    ->select('product_payments.id', 'product_payments.payment', 'product_payments.amount', 'product_payments.product_id')
                    ->where('product_payments.visa_type', '=', $packageType)
                    ->where('family_sub_id', '=', $family_id)
                    ->where('applicants.user_id', '=', $id)
                    ->groupBy('product_payments.payment')
                    ->get();
            } else {
                $pays = DB::table('product_payments')
                    ->join('applicants', 'applicants.product_id', '=', 'product_payments.product_id')
                    ->select('product_payments.id', 'product_payments.payment', 'product_payments.amount', 'product_payments.product_id')
                    ->where('product_payments.visa_type', '=', $packageType)
                    ->where('applicants.user_id', '=', $id)
                    ->groupBy('product_payments.payment')
                    ->get();
            }

            $paid = DB::table('payments')
                ->join('applicants', 'payments.application_id', '=', 'applicants.id')
                ->selectRaw('payments.*, applicants.*, COUNT(payments.id) as count')

                ->where('applicants.user_id', '=', $id)
                ->groupBy('payments.id')
                // ->groupBy('applicants.id')
                ->orderBy('applicants.id', 'desc')
                // ->limit(1)
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
        $famCode = 0;
        if (Auth::id()) {

            $completed = DB::table('applicants')
                ->where('user_id', '=', Auth::user()->id)
                ->orderBy('id', 'desc')
                ->get();

            foreach ($completed as $complete) {
                $app_id = $complete->id;
                $p_id = $complete->product_id;
                $hasSpouse = $complete->is_spouse;
                $children = $complete->children_count;
            }
            if ($hasSpouse == 1) {
                $yesSpouse = 2;
            } else {
                $yesSpouse = 1;
            }

            $families = DB::table('family_breakdowns')
                ->where('children', '=', $children)
                ->where('parent', '=', $yesSpouse)
                ->where('visa_type', '=', 'FAMILY PACKAGE')
                ->get();

            foreach ($families as $famili) {
                $famCode = $famili->id;
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

            if (Session::has('packageType')) {
                $packageType = Session::get('packageType');
            } else {
                $packageType = $complete->visa_type;
            }


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
            $data = product::find(Session::get('myproduct_id'));

            $pays = DB::table('applicants')
                ->leftJoin('payments', 'payments.application_id', '=', 'applicants.id')
                ->leftJoin('product_payments', 'product_payments.id', '=', 'payments.product_payment_id')
                ->select('product_payments.*', 'payments.product_payment_id', 'payments.total', 'payments.total_paid', 'payments.payment_status')
                ->where('applicants.user_id', '=', Auth::user()->id)
                ->where('applicants.product_id', '=', $id)
                ->orderBy('payments.product_payment_id', 'desc')
                ->limit(1)
                ->get();


            if ($packageType == "FAMILY PACKAGE") {
                if (Session::has('fam_id')) {
                    $family_id = Session::get('fam_id');
                } else {
                    $family_id = $famCode;
                }
                $pdet = DB::table('product_payments')
                    ->where('product_id', '=', Session::get('myproduct_id'))
                    ->where('visa_type', '=', $packageType)
                    ->where('family_sub_id', '=',  $family_id)
                    // ->groupBy('product_payments.id')
                    ->get();
            } else {
                $pdet = DB::table('product_payments')
                    ->where('product_id', '=', Session::get('myproduct_id'))
                    ->where('visa_type', '=', $packageType)
                    // ->groupBy('product_payments.id')
                    ->get();
            }

            return view('user.payment-form', compact('data', 'pdet', 'pays', 'payall'));
        } else {
            return redirect()->back()->with('message', 'You are not authorized');
        }
    }

    public static function invokeCurlRequest($type, $url, $headers, $post) {
	
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);		

		if ($type == "POST") {
		
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		
		}

		$server_output = curl_exec ($ch);
		curl_close ($ch);
		
		return $server_output;
		
	}

    public function addpayment(Request $request)
    {
        if (Auth::id()) {
            $amount = $request->totalpay;
            $id = Session::get('myproduct_id');
            $applys = DB::table('applicants')
                ->where('product_id', '=', $id)
                ->where('user_id', '=', Auth::user()->id)
                ->get();

            foreach ($applys as $apply) {
                $applicant_id = $apply->id;
            }

            $validator = \Validator::make($request->all(), [
                'totaldue' => 'required',
                'totalpay' => 'numeric|gte:1000'
            ]);

            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            } else {
                if ($request->totalpay == null || $request->totalpay == "" || $request->totalpay < 1000) {
                    $totalpay = 0;
                } else {
                    $totalpay = $request->totalpay;
                }
                if ($request->totaldue == $request->totalpay) {
                    $whatsPaid = "Paid";
                } elseif ($request->totaldue > $request->totalpay && $request->totalpay > 1000) {
                    $whatsPaid = "Partial";
                } else {
                    $whatsPaid = "Paid";
                    $overPay = $request->totalpay - $request->totaldue;
                }
                
                payment::updateOrCreate([
                    'product_payment_id' => $request->ppid,
                    'payment_type' => $request->whichpayment,
                    'application_id' => $applicant_id
                ], [
                    'total' => $request->totaldue,
                    'total_paid' => $totalpay,
                    'payment_status' => $whatsPaid,

                ]);

                $datas = payment::where([
                    ['product_payment_id', '=', $request->ppid],
                    ['payment_type', '=', $request->whichpayment],
                    ['application_id', '=', $applicant_id],
                ])->first();

                set_time_limit(0);
                $outletRef 	 	 = config('app.payment_reference');   
                $apikey 		 = config('app.payment_api_key'); 

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
                $order['amount']['value'] 		 	  = ($amount * 100);                                   // Minor units (1000 = 10.00 AED)
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
                $paymentLink 		   = $orderCreateResponse->_links->payment->href; 
                header("Location: ".$paymentLink); 
                die;
            }
        } else {
            return redirect()->back()->with('failed', 'You are not authorized');
        }
    }

    /**
     * 
     * add payment some code
     */
    // public function addPaymentDetails($request)
    // {
    //     $id = Session::get('myproduct_id');

    //     // Send Notifications on This Payment ##############
    //     $email = Auth::user()->email;
    //     $userID = Auth::user()->id;

    //     if($request->whichpayment == "First Payment")
    //     {
    //         $ems = "";
    //     } else if($request->whichpayment == "Second Payment") {
    //         $ems = " You will be notified when your Work Permit is ready.";
    //     } else {
    //         $ems = " You will be notified when your embassy appearance date is set.";
    //     }

    //     $criteria = $request->whichpayment . " Completed!";
    //     $message = "You have successfully made your " .$request->whichpayment. ". Kindly login to the PWG Client portal and check your receipt on 'My Application'" . $ems;

    //     $link = "";
    //     // $msgBody="hellooooooo";

    //     $dataArray = [
    //         'title' => $criteria .' Mail from PWG Group',
    //         'body' => $message,
    //         'link' => $link
    //     ];

    //     DB::table('notifications')->insert(
    //             ['user_id' => $userID, 'message' => $message, 'criteria' => $criteria, 'link' => $link]
    //     );

    //     Mail::to($email)->send(new NotifyMail($dataArray));
    //     // Notification Ends ############ 
        
    //     //kjljkllk
    //     $productId = $id;
    //     $dest = product::find($request->pid);
    //     $dest_name = $dest->product_name;

    // }

    public function getPromo(Request $request)
    {
            $id = Session::get('myproduct_id');
            $coupon = DB::table('promos')
                ->select('discount_percent')
                ->where('promo_code', '=', $request->discount_code)
                ->where('product_id', '=', $id)
                ->where('validity', '>=', date('Y-m-d'))
                ->get();
            foreach ($coupon as $apply) {
                $my_discount = $apply->discount_percent;
            }


        if ($coupon->first()) {
            Session::put('myDiscount', $my_discount);
            Session::put('haveCoupon', 1);

            return response()->json(['status' => 'Success']);
            // return \Redirect::route('payment', $id);
        } else {
            Session::put('haveCoupon', 0);
            return response()->json(['status' => 'Invalid Discount/Promo Code']);
            // return \Redirect::route('payment', $id)->with('failed', 'Invalid Discount/Promo Code');

        }
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
            'card_number' => 'required|numeric|digits:16',
            'name' => 'required',
            'month' => 'required|numeric',
            'year' => 'required|numeric|digits:4|max:'.(date('Y')+100),
            'cvc' => 'required|numeric|digits:3'
        ]);

        if($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {

            // Save Payment Information
            $apply = DB::table('applicants')
            ->where('user_id', '=', Auth::user()->id)
            ->first();
            // $applicant_id = $apply->id;

            $datas = cardDetail::where('application_id', '=', $apply->id)->where('user_id', '=', Auth::user()->id)->first();
            if ($datas === null) {
                $data = new cardDetail();
                // $data->product_payment_id = $request->ppid;
                $data->application_id = $apply->id;
                $data->user_id = Auth::user()->id;
                $data->card_holder_name = $request->name;
            
                $data->card_number = $request->card_number;
                $data->month = $request->month;
                $data->year = $request->year;
                $data->cvv = $request->cvc;
            
                $data->save();
            } else {
                // $datas->product_payment_id = $request->ppid;
                $datas->application_id = $apply->id;
                $datas->user_id = Auth::user()->id;
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

           $notis = notifications::where('user_id', '=', Auth::user()->id)->get();

           if ($notis) {
                foreach($notis as $noti)
                {
                    $noti->status = 'Read';
                    $noti->save();
                }    
           }
            return response()->json(['status' => 'Cleared']);
}

    // public function notifications()
    // {
    //     if (Auth::id()) 
    //     {
    //         $notifications = DB::table('notifications')
    //                             ->where('user_id', '=', Auth::user()->id)
    //                             ->sortBy("id")
    //                             ->get();

    //         return view('user.notifications', compact('notifications'));
    //     } else {
    //         return redirect()->back()->with('failed', 'You are not authorized');
    //     }
    // }

    public function paymentSuccess($paymentId)
    {
        session_start();
    
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
                    'currency_code' => $paymentResponse->amount->currencyCode
                ]);
                $id = Session::get('myproduct_id');
                $monthYear = explode('-', $paymentResponse->paymentMethod->expiry);
                $res = cardDetail::updateOrCreate([
                    'user_id' => Auth::id(),
                    'application_id' => $paymentDetails['application_id'],
                ],[
                    'card_number' => $paymentResponse->paymentMethod->pan,
                    'card_holder_name' => $paymentResponse->paymentMethod->cardholderName,
                    'month' => $monthYear[0],
                    'year' =>  $monthYear[1],
                ]);

                if ($res) {
                    //Update Applicant status in APPPLICANT TABLE
                    $status = applicant::where([
                        ['user_id', '=', Auth::user()->id],
                        ['product_id', '=', $id],
                        ['id', '=', $paymentDetails['application_id ']],
                    ])->first();
                    if ($status === null) {
                    } else {
                        $status->applicant_status = '2';
                        $status->save();
                    }
                    // Save Payment Info
                    $card = cardDetail::where('application_id', '=', $paymentDetails['application_id '])->where('user_id', '=', Auth::user()->id)->first();

                    // Send Notifications on This Payment ##############
                    $email = Auth::user()->email;
                    $userID = Auth::user()->id;

                    if($paymentDetails['payment_type '] == "First Payment")
                    {
                        $ems = "";
                    } else if($paymentDetails['payment_type '] == "Second Payment") {
                        $ems = " You will be notified when your Work Permit is ready.";
                    } else {
                        $ems = " You will be notified when your embassy appearance date is set.";
                    }

                    $criteria = $paymentDetails['payment_type '] . " Completed!";
                    $message = "You have successfully made your " .$paymentDetails['payment_type ']. ". Kindly login to the PWG Client portal and check your receipt on 'My Application'" . $ems;

                    $link = "";
            
                    $dataArray = [
                        'title' => $criteria .' Mail from PWG Group',
                        'body' => $message,
                        'link' => $link
                    ];
                
                    $check_noti = notifications::where('criteria', '=', $criteria)->where('user_id', '=', Auth::user()->id)->first();

                    if ($check_noti === null) 
                    {

                        DB::table('notifications')->insert(
                                ['user_id' => $userID, 'message' => $message, 'criteria' => $criteria, 'link' => $link]
                        );
                
                        Mail::to($email)->send(new NotifyMail($dataArray));
                    } 
                    // Notification Ends ############ 
                    $dest = product::find($id);
                    $dest_name = $dest->product_name;

                    $msg = "Awesome! Payment Successful!";
                    return view('user.payment-success', compact('id'));
                } else {
                    return view('user.payment-fail', compact('id'));
                }
            } else {
                return view('user.payment-fail', compact('id'));
            }
        } else {
            return view('user.payment-fail', compact('id'));
        }
    }

    public function paymentFail($paymentId)
    {
        $id = Session::get('myproduct_id');
        Payment::where('id', $paymentId)->delete();
        return view('user.payment-fail', compact('id'));
    }

}
