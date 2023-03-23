<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Application;
use App\Client;
use App\Models\Timer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\promo;
use App\Models\product;
use App\Models\product_payments;
use App\payment;
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
use Illuminate\Support\Facades\Artisan;
use Config;
use PDF;
use DB;
use Session;
use Exception;
use Illuminate\Contracts\Session\Session as SessionSession;
use Carbon\Carbon;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;

class HomeController extends Controller
{
    public function redirect()
    {
        $pricingPlan = UserHelper::getGeneralPricingPlan();
        if (Auth::id()) {

            $client = User::find(Auth::id());

            $complete = DB::table('applications')
                ->where('client_id', '=', Auth::user()->id)
                ->orderBy('id', 'desc')
                ->first();

            if (isset($complete) && $complete->destination_id > 0 && $complete->destination_id != null) {
                return \Redirect::route('myapplication');
            } elseif (Session::has('prod_id')) {
                $id = Session::get('prod_id');
                $data = product::find($id);

                $promo = promo::where('employee_id', '=', $id)->where('active_until', '>=', date('Y-m-d'))->get();
                $ppay = product_payments::where('destination_id', '=', $id)->where('pricing_plan_type', '=', Session::get('packageType'))->where('status', 'CURRENT')->first();

                session()->forget('prod_id');
                Session::put('myproduct_id', $id);

                // return view('user.package-type', compact('data', 'ppay', 'id'));
                return Redirect::to('payment_form/' . $id);
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
                    ->where('pricing_plans.status', 'CURRENT')
                    ->orderBy(DB::raw('FIELD(destinations.name, "Poland", "Czech", "Malta", "Canada", "Germany")'))
                    ->get();

                $promo = promo::where('active_until', '>=', date('Y-m-d'))->get();

                return view('user.home', compact('package', 'promo', 'started', 'pricingPlan'));
            }
        } else {
            Session::flush();
            // $package = DB::table('destinations')->orderBy(DB::raw('FIELD(name, "Poland", "Czech", "Malta", "Canada", "Germany")'))->get();
            $package = DB::table('pricing_plans')
                ->join('destinations', 'destinations.id', '=', 'pricing_plans.destination_id')
                ->where('pricing_plans.pricing_plan_type', 'BLUE_COLLAR')
                ->where('pricing_plans.status', 'CURRENT')
                ->orderBy(DB::raw('FIELD(destinations.name, "Poland", "Czech", "Malta", "Canada", "Germany")'))
                ->get();
            $promo = promo::where('active_until', '>=', date('Y-m-d'))->get();

            return view('user.home', compact('package', 'promo', 'pricingPlan'));
        }
    }

    public function index()
    {
        $pricingPlan = UserHelper::getGeneralPricingPlan();
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
                ->where('pricing_plans.status', 'CURRENT')
                ->orderBy(DB::raw('FIELD(destinations.name, "Poland", "Czech", "Malta", "Canada", "Germany")'))
                ->get();

            $promo = promo::where('active_until', '>=', date('Y-m-d'))->get();

            return view('user.home', compact('package', 'promo', 'started', 'pricingPlan'));
        } else {
            // $package = DB::table('destinations')->orderBy(DB::raw('FIELD(name, "Poland", "Czech", "Malta", "Canada", "Germany")'))->get();

            $package = DB::table('pricing_plans')
                ->join('destinations', 'destinations.id', '=', 'pricing_plans.destination_id')
                ->where('pricing_plans.pricing_plan_type', 'BLUE_COLLAR')
                ->where('pricing_plans.status', 'CURRENT')
                ->orderBy(DB::raw('FIELD(destinations.name, "Poland", "Czech", "Malta", "Canada", "Germany")'))
                ->get();
            // dd($package);
            $promo = promo::where('active_until', '>=', date('Y-m-d'))->get();

            return view('user.home', compact('package', 'promo', 'pricingPlan'));
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
                ->where('status', 'CURRENT')
                ->orderBy('sub_total', 'asc')
                ->first();

            if ($request->response == 1) {
                // dd($request->pyall);
                // $pyall=$request->pyall;
                return $famdet;
                // return $pyall;
            }
        } else {
            $famdet = family_breakdown::where('destination_id', '=', $productId)
                ->where('pricing_plan_type', 'FAMILY_PACKAGE')
                ->where('status', 'CURRENT')
                ->orderBy('sub_total', 'asc')
                ->first();
        }

        $proddet = family_breakdown::where('destination_id', '=', $productId)->where('pricing_plan_type', 'BLUE_COLLAR')->where('status', 'CURRENT')->get();
        $whiteJobs = family_breakdown::where('destination_id', '=', $productId)->where('pricing_plan_type', 'WHITE_COLLAR')->where('status', 'CURRENT')->get();
        $canadaOthers = family_breakdown::where('destination_id', '=', $productId)->whereIn('pricing_plan_type', array('EXPRESS_ENTRY', 'STUDY_PERMIT'))->where('status', 'CURRENT')->get();
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
                ->where('status', 'CURRENT')
                ->orderBy('sub_total', 'asc')
                ->first();
        } else {
            $ppay = family_breakdown::where('destination_id', '=', $id)
                // ->where('id','=', $pid) 
                ->where('pricing_plan_type', '=', Session::get('packageType'))
                ->where('status', 'CURRENT')
                // ->where('family_sub_id', '=', Session::get('fam_id'))      
                ->first();
            // dd($ppay);
        }

        session()->forget('prod_id');
        return view('user.package', compact('data', 'ppay', 'promo'));
    }


    public function signature(Request $request, $id)
    {
        if (Auth::id()) {
            $data = product::find($id);
            return view('user.signature', compact('data'));
        } else {
            return redirect('home');
        }
    }

    public function upload(Request $request)
    {
        $user = User::find(Auth::id());
        $signatureUrl = (isset($user->getMedia(Client::$media_collection_main_signture)[0])) ? $user->getMedia(Client::$media_collection_main_signture)[0]->getUrl() : null;
        if (Auth::id() && $signatureUrl == null) {
            list($part_a, $image_parts) = explode(";base64,", $request->signed);
            $image_type_aux = explode("image/", $part_a);
            $image_type = $image_type_aux[1];
            $signate = Auth::user()->id . '_' . time() . '.' . $image_type;
            $signature = Client::find(Auth::user()->id);

            if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                $signature->addMediaFromBase64($request->signed)->usingFileName($signate)->toMediaCollection(Client::$media_collection_main_signture, env('MEDIA_DISK'));
            } else {
                $signature->addMediaFromBase64($request->signed)->usingFileName($signate)->toMediaCollection(Client::$media_collection_main_signture, 'local');
            }
            $signature->save();


            if ($signature) {
                $signatureUrl = (isset($signature->getMedia(Client::$media_collection_main_signture)[0])) ? $signature->getMedia(Client::$media_collection_main_signture)[0]->getUrl() : null;
                $response = [
                    'status' => true,
                    'url' => $signatureUrl
                ];
                return $response;
            } else {
                $response = [
                    'status' => false,
                ];
            }
        } else {
            $response = [
                'status' => false,
            ];
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
            Session::forget('packageTypeOpted');
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
                $pack_id = $complete->pricing_plan_id;
            } else {
                $app_id = 0;
                $p_id = 0;
                $pack_id = 0;
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
                // ->where('status', 'CURRENT')
                ->where('id', '=', $pack_id)
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

            $paym = DB::table('payments')
                ->where('application_id', '=', $app_id)
                ->whereIn('transaction_mode',   array('TRANSFER', 'DEPOSIT'))
                ->where('invoice_amount', '>', 0)

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
            } else {
                $dueDay = "";
            }
            //  $p_id=101;
            $pays = DB::table('pricing_plans')
                ->join('applications', 'applications.pricing_plan_id', '=', 'pricing_plans.id')
                // ->select('applications.pricing_plan_id', 'applications.destination_id', 'pricing_plans.id', 'pricing_plans.pricing_plan_type', 'pricing_plans.total_price', 'pricing_plans.destination_id', 'pricing_plans.first_payment_price', 'pricing_plans.submission_payment_price', 'pricing_plans.second_payment_price', 'pricing_plans.third_payment_price', 'pricing_plans.total_price')
                ->select('applications.pricing_plan_id', 'applications.destination_id', 'pricing_plans.id', 'pricing_plans.pricing_plan_type', 'pricing_plans.sub_total', 'pricing_plans.destination_id', 'pricing_plans.first_payment_sub_total', 'pricing_plans.submission_payment_sub_total', 'pricing_plans.second_payment_sub_total', 'pricing_plans.third_payment_sub_total', 'pricing_plans.sub_total')
                // ->where('pricing_plans.pricing_plan_type', '=', $packageType) //REMOVED NOW
                ->where('applications.destination_id', '=', $p_id)
                ->where('applications.client_id', '=', $id)
                // ->where('pricing_plans.status', 'CURRENT')
                ->where('pricing_plans.id', '=', $pack_id)
                ->orderBy('pricing_plans.id')
                ->first();

            $paid = DB::table('applications')
                ->where('applications.destination_id', '=', $p_id)
                ->where('applications.client_id', '=', $id)
                // ->where('pricing_plan_id', '=', $pack_id)
                // ->groupBy('payments.id')
                ->orderBy('applications.id', 'desc')
                ->first();

            $prod = DB::table('destinations')
                ->join('applications', 'destinations.id', '=', 'applications.destination_id')
                ->select('destinations.name', 'destinations.id', 'destinations.full_payment_discount')
                ->where('applications.client_id', '=', $id)
                ->where('applications.destination_id', '=', $p_id)
                ->groupBy('destinations.id')
                ->first();

            $authUrl = '';
            return view('user.myapplication', compact('paid', 'pays', 'prod', 'authUrl', 'dueDay', 'paym'));
        } else {
            return redirect('home');
        }
    }

    public function payment($productId, Request $request)
    {
        try {
            $famCode = 0;
            if (Auth::id()) {
                Session::forget('haveCoupon');
                Session::forget('myDiscount');
                Session::forget('discountapplied');
                $complete = DB::table('applications')
                    ->where('client_id', '=', Auth::user()->id)
                    // ->whereNotIn('status',  ['APPLICATION_COMPLETED','VISA_REFUSED', 'APPLICATION_CANCELLED','REFUNDED'] )
                    ->orderBy('id', 'desc')
                    ->first();
                if (isset($complete)) {
                    $app_id = $complete->id;
                    $p_id = $complete->destination_id;
                    $pack_id = $complete->pricing_plan_id;
                    $myPack = $complete->work_permit_category;
                } else {
                    $app_id = null;
                    $p_id = $request->pr_id;
                    if ($request->myPack == "BLUE_COLLAR") {
                        $pack_id = $request->blue_id;
                    } else if ($request->myPack == "FAMILY_PACKAGE") {
                        $pack_id = $request->fam_id;
                    } else if (Session::has('packageTypeOpted')) {
                        $pack_id = Session::get('pricingPlanId');
                    } else {
                        $pack_id = $request->fam_id;
                    }
                    $myPack = ($request->myPack) ?? Session::get('packageTypeOpted');
                }
                //Call Create Contract Function
                $fileUrl = self::createContract($p_id);


                if (session()->get('myproduct_id')) {
                    // } else if (isset($request->id)) {
                    //     Session::put('myproduct_id', $request->id);
                } else {
                    Session::put('myproduct_id', $p_id);
                }

                $id = Session::get('myproduct_id');

                if (Session::has('payall')) {
                    $payall = Session::get('payall'); //$request->payall;
                    // Session::forget('payall');
                } else if (isset($request->payall)) {
                    $payall = $request->payall;
                } else {
                    $payall = 0;
                }

                $data = product::find(Session::get('myproduct_id'));
                $paym = DB::table('payments')
                    ->where('application_id', '=', $app_id)
                    // ->whereIn('transaction_mode',   array('TRANSFER', 'DEPOSIT'))
                    ->where('invoice_amount', '>', 0)
                    ->where(function ($query) {
                        $query->where('paid_amount', '=', 0)
                            ->orWhereNull('paid_amount');
                    })
                    ->orderBy('id', 'desc')
                    ->first();
                $pays = DB::table('applications')
                    ->select('*')
                    // ->select('applications.pricing_plan_id', 'applications.total_price', 'applications.total_paid', 'applications.first_payment_status', 'applications.submission_payment_status', 'applications.second_payment_status', 'first_payment_price', 'first_payment_paid', 'first_payment_remaining', 'is_first_payment_partially_paid', 'submission_payment_price', 'submission_payment_paid', 'submission_payment_remaining', 'second_payment_price', 'second_payment_paid', 'second_payment_remaining', 'first_payment_verified_by_cfo', 'contract_1st_signature_status', 'coupon_code','second_payment_discount','submission_payment_discount')
                    ->where('applications.client_id', '=', Auth::user()->id)
                    ->where('applications.destination_id', '=', $id)
                    // ->where('work_permit_category', $packageType)
                    ->orderBy('applications.id', 'desc')
                    // ->whereNotIn('status',  ['APPLICATION_COMPLETED','VISA_REFUSED', 'APPLICATION_CANCELLED','REFUNDED'] )
                    ->limit(1)
                    ->first();
                $pdet = DB::table('pricing_plans')
                    ->where('id', '=', $pack_id)
                    ->first();
                return view('user.payment-form', compact('data', 'pdet', 'pays', 'payall', 'paym', 'fileUrl', 'myPack'));
            } else {
                return redirect('home');
            }
        } catch (Exception $e) {
            return redirect('home')->with('error', $e->getMessage());
        }
    }

    public function bank($ptype = null)
    {
        if (Auth::id() && $ptype != null) {

            $application = DB::table('applications')
                ->where('client_id', '=', Auth::user()->id)
                // ->whereNotIn('status',  ['APPLICATION_COMPLETED','VISA_REFUSED', 'APPLICATION_CANCELLED','REFUNDED'] )
                ->orderBy('id', 'desc')
                ->first();

            $app_id = $application->id;
            $productId = $application->destination_id;
            $pack_id = $application->pricing_plan_id;
            $paymentType = $ptype;

            $amount = 0;
            if (in_array($paymentType, ['FIRST', 'BALANCE_ON_FIRST'])) {
                $amount = $application->first_payment_remaining;
            } else if ($paymentType == 'SUBMISSION') {
                $amount = $application->submission_payment_remaining;
            } else if ($paymentType == 'SECOND') {
                $amount = $application->third_payment_remaining;
            }

            return view('user.bank-transfer', compact('productId', 'app_id', 'paymentType', 'amount'));
        } else {
            return redirect('user.payment-form');
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

    private static function createContract($pid)
    {
        $originalPdf = null;
        $destination_file = null;
        $newFileName = null;

        $productId = $pid;
        $productName = DB::table('destinations')
            ->where('id', $pid)
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
            $client = Client::find(Auth::id());
            $destination_file = 'Applications/Contracts/client_contracts/' . $newFileName;
            $data = pdfBlock::mapDetails($originalPdf, $destination_file, $productName, Session::get('packageType'), $client);
            Session::put('contract', $newFileName);
            Applicant::where('client_id', Auth::id())
                ->where('destination_id', $pid)
                ->where('work_permit_category', (Session::get('packageType')) ?? 'BLUE_COLLAR')
                ->update([
                    'contract' => $newFileName
                ]);

            if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                return $fileUrl = Storage::disk(env('MEDIA_DISK'))->url('Applications/Contracts/client_contracts/' . $newFileName);
            } else {
                return $fileUrl = Storage::disk('local')->url('Applications/Contracts/client_contracts/' . $newFileName);
            }
        }
    }

    private static function createAppliacation($pid, $pack_id)
    {
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


        $pricingPLan = product_payments::where('id', $pack_id)->first();

        $datas = Applicant::where('client_id', Auth::id())
            ->where('destination_id', $pid)
            ->where('pricing_plan_id', $pricingPLan->id)
            ->first();

        $user = User::where('id', Auth::id())
            ->update([
                'is_spouse' => $is_spouse,
                'children_count' => $children
            ]);

        if ($datas === null) {
            $data = new applicant();
            $data->client_id = Auth::id();
            // $data->destination_id = $pid;
            $data->pricing_plan_id = $pricingPLan->id;
            $data->work_permit_category = (Session::get('packageType')) ?? 'BLUE_COLLAR';
            $data->application_stage_status = 1;
            $data->destination_id = $pid;
            $data->applied_country = strtoupper(product::where('id', $pid)->pluck('name')->first());
            $data->contract = Session::get('contract');
            $data->is_job_offer_letter_delivered = 0;
            $data->is_workpermit_delivered = 0;
            $data->work_permit_status = 'WORK_PERMIT_NOT_APPLIED';
            $data->sub_total = $pricingPLan['sub_total'];
            $data->total_vat = $pricingPLan['total_vat'];
            $data->total_price = $pricingPLan['total_price'];
            $data->total_paid = 0;
            $data->total_remaining = $pricingPLan['total_price'];

            $data->first_payment_sub_total = $pricingPLan['first_payment_sub_total'];
            $data->first_payment_vat = $pricingPLan['first_payment_vat'];
            $data->first_payment_price = $pricingPLan['first_payment_price'];
            $data->first_payment_paid = 0;
            $data->first_payment_remaining = $pricingPLan['first_payment_price'];

            $data->submission_payment_sub_total = $pricingPLan['submission_payment_sub_total'];
            $data->submission_payment_vat = $pricingPLan['submission_payment_vat'];
            $data->submission_payment_price = $pricingPLan['submission_payment_price'];
            $data->submission_payment_paid = 0;
            $data->submission_payment_remaining = $pricingPLan['submission_payment_price'];

            $data->second_payment_sub_total = $pricingPLan['second_payment_sub_total'];
            $data->second_payment_vat = $pricingPLan['second_payment_vat'];
            $data->second_payment_price = $pricingPLan['second_payment_price'];
            $data->second_payment_paid = 0;
            $data->second_payment_remaining = $pricingPLan['second_payment_price'];


            $data->third_payment_sub_total = $pricingPLan['third_payment_sub_total'];
            $data->third_payment_vat = $pricingPLan['third_payment_vat'];
            $data->third_payment_price = $pricingPLan['third_payment_price'];
            $data->third_payment_paid = 0;
            $data->third_payment_remaining = $pricingPLan['third_payment_price'];
            $res = $data->save();
        } else {
            $datas->pricing_plan_id = ($datas->pricing_plan_id) ?? $pricingPLan->id;
            $datas->work_permit_category =  ($datas->work_permit_category) ?? (Session::get('packageType')) ?? 'BLUE_COLLAR';
            $datas->application_stage_status = ($datas->application_stage_status) ?? 1;
            $datas->destination_id = ($datas->destination_id) ?? $pid;
            $datas->applied_country = ($datas->applied_country) ?? strtoupper(product::where('id', $pid)->pluck('name')->first());
            $datas->contract = ($datas->contract) ?? Session::get('contract');
            $datas->work_permit_status = ($datas->work_permit_status) ?? 'WORK_PERMIT_NOT_APPLIED';
            $res = $datas->save();
        }

        ############## SIGNED CONTRACT ######################
        $applicant = Application::where('client_id', Auth::id())
            ->where('pricing_plan_id', $pack_id)
            ->first();

        $existing = DB::table('applications')
            ->select('first_payment_status')
            ->where('client_id', '=', Auth::user()->id)
            ->where('pricing_plan_id', $pack_id)
            ->orderBy('id', 'desc')
            ->limit(1)
            ->first();

        $data = product::find(Session::get('myproduct_id'));

        if (isset($existing) && ($existing->first_payment_status != "PAID" || $existing->first_payment_status == null)) {
            if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                $originalPdf = Storage::disk(env('MEDIA_DISK'))->url('Applications/Contracts/client_contracts/' . $applicant->contract);
            } else {
                $originalPdf = Storage::disk('local')->url('Applications/Contracts/client_contracts/' . $applicant->contract);
                $originalPdf = ltrim($originalPdf, $originalPdf[0]);
            }
            $paymentType =  "FIRST";
            $user = Client::find(Auth::id());

            $signatureUrl = (isset($user->getMedia(Client::$media_collection_main_signture)[0])) ? $user->getMedia(Client::$media_collection_main_signture)[0]->getUrl() : null;

            if (in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                $signatureUrl = ltrim($signatureUrl, $signatureUrl[0]);
            }
            $result = pdfBlock::attachSignature($originalPdf, $signatureUrl, $data, $paymentType, $applicant, $user);
        }
        return $applicant->id;
    }

    public static function payType(Request $request)
    {
        Session::forget('payall');

        if ($request->payall == 0) {
            $payall = 0;
            Session::put('payall', 0);
        } else {
            $payall = 1;
            Session::put('payall', 1);
        }
        return $payall;
    }

    public function addpayment(Request $request)
    {
        try {

            if (Auth::id()) {

                session()->forget('info');

                Session::put('packageType', $request->packageType);
                $user = Client::find(Auth::id());
                $signatureUrl = (isset($user->getMedia(Client::$media_collection_main_signture)[0])) ? $user->getMedia(Client::$media_collection_main_signture)[0]->getUrl() : null;
                if ($signatureUrl == null && $request->whichpayment == 'FIRST') {
                    if ($request->signed) {
                        list($part_a, $image_parts) = explode(";base64,", $request->signed);
                        $image_type_aux = explode("image/", $part_a);
                        $image_type = $image_type_aux[1];
                        $signate = Auth::user()->id . '_' . time() . '.' . $image_type;
                        $signature = Client::find(Auth::user()->id);

                        if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                            $signature->addMediaFromBase64($request->signed)->usingFileName($signate)->toMediaCollection(Client::$media_collection_main_signture, env('MEDIA_DISK'));
                        } else {
                            $signature->addMediaFromBase64($request->signed)->usingFileName($signate)->toMediaCollection(Client::$media_collection_main_signture, 'local');
                        }
                        $signature->save();
                    } else {
                        return back()->with('error', 'Oppss! Please provide signature.');
                    }
                }
                // //Call Create Contract Function
                // self::createContract($request->pid);

                //Call Create Application Function
                self::createAppliacation($request->pid, $request->ppid);

                $id = Session::get('myproduct_id');

                $complete = DB::table('applications')
                    ->where('client_id', '=', Auth::user()->id)
                    ->orderBy('id', 'desc')
                    ->first();
                $pack_id = $complete->pricing_plan_id;

                if (isset($complete->work_permit_category) && $complete->second_payment_status == 'PENDING') {
                    $packageType = $complete->work_permit_category;
                } elseif (Session::has('packageType')) {
                    $packageType = Session::get('packageType');
                } else {
                    $packageType = $complete->work_permit_category;
                }

                $pdet = DB::table('pricing_plans')
                    ->where('id', $pack_id)
                    ->first();
                if ($request->whichpayment == 'FIRST') {
                    if ($request->totalpay >= 1000) {
                        $amount = $request->totalpay;
                    } else {
                        if ($request->vats > 0) {
                            $amount = $pdet->first_payment_price;
                        } else {
                            $amount = $pdet->first_payment_sub_total;
                        }
                    }
                } else if ($request->whichpayment == 'BALANCE_ON_FIRST') {
                    $amount = $request->totalpay;
                } else if ($request->whichpayment == 'SUBMISSION') {
                    if ($request->vats > 0) {
                        $amount = $pdet->submission_payment_price;
                    } else {
                        $amount = $pdet->submission_payment_sub_total;
                    }
                } else if ($request->whichpayment == 'BALANCE_ON_SUBMISSION') {
                    $amount = $request->totalpay;
                } else if ($request->whichpayment == 'SECOND') {
                    if ($request->vats > 0) {
                        $amount = $pdet->second_payment_price;
                    } else {
                        $amount = $pdet->second_payment_sub_total;
                    }
                } else if ($request->whichpayment == 'BALANCE_ON_SECOND') {
                    $amount = $request->totalpay;
                } else if ($request->whichpayment == 'Full-Outstanding Payment') {
                    $amount = $request->totalpay;
                } else {
                    if ($request->vats > 0) {
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

                $applicant_id = ($apply) ? $apply->id : null;
                $vals = array(0, 1, 2);

                $payLimit = $request->totaldue - $request->vats;
                if ($request->amount > 0) {
                    $validator = Validator::make($request->all(), [
                        'amount' => 'numeric|gte:1000|lte:' . $payLimit,
                        'totaldue' => 'required',
                        'totalpay' => 'numeric',
                        'agree' => 'required'
                    ]);
                } else {
                    $validator = Validator::make($request->all(), [
                        'totaldue' => 'required',
                        'totalpay' => 'numeric',
                        'agree' => 'required'
                    ]);
                }
                if ($validator->fails()) {
                    return back()->withErrors($validator)
                        ->withInput();
                }
                if ($request->payoption == "Transfer" || $request->payoption == "Deposit") {

                    return \Redirect::route('bank', $request->whichpayment);
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
                if ($request->totaldue == ($request->totalpay + $request->discount)) {
                    $whatsPaid = "PAID";
                    // } elseif (($request->totaldue > ($request->totalpay + $request->discount)) && (($request->totalpay + $request->discount) >= 1000)) {
                } elseif (($request->totaldue > ($request->totalpay + $request->discount)) || (($request->totalpay + $request->discount) >= 1000)) {
                    if ($request->totalremaining == ($request->totalpay + $request->discount)) {
                        $whatsPaid = "PAID";
                    } else {
                        $whatsPaid = ($request->whichpayment == 'FIRST') ? "PARTIALLY_PAID" : "PAID";
                    }
                } else {
                    $whatsPaid = "PENDING"; //??????
                    $overPay = $request->totalpay - $request->totaldue;
                }
                if (Session::get('discountapplied') == 1) {
                    $couponCodeData = DB::table('coupons')->where('code', $request->discountCode)->get()->first();
                    if ($request->whichpayment == 'FIRST') {
                        $first_payment_discount = ($pdet->first_payment_sub_total * $couponCodeData->amount) / 100;
                        $topaynow_temp_first = ($pdet->first_payment_sub_total  - $first_payment_discount);
                        $first_payment_vat = ($topaynow_temp_first *  5) / 100;
                        $paidAmount = $topaynow_temp_first + $first_payment_vat;
                        if ($paidAmount == $request->totalpay) {
                            $whatsPaid = 'PAID';
                        }
                    } else if ($request->whichpayment == 'BALANCE_ON_FIRST') {
                        $whatsPaid = 'PAID';
                    }
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
                $order['amount']['value']                = floor($amount * 100);         // Minor units (1000 = 10.00 AED)
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


                if (isset($orderCreateResponse->_links->payment->href)) {
                    $datas = applicant::where([
                        ['client_id', '=', Auth::user()->id],
                        ['destination_id', '=', $request->pid],
                    ])
                        ->orderBy('id', 'Desc')
                        ->first();

                    // select(
                    //     'id', 'client_id', 'branch_id', 'pricing_plan_id', 'destination_id', 'status', 'work_permit_status', 'first_payment_status', 'submission_payment_status', 'second_payment_status', 'third_payment_status', 'is_first_payment_partially_paid', 'is_submission_payment_partially_paid', 'is_second_payment_partially_paid', 'is_third_payment_partially_paid', 'first_payment_verified_by_accountant', 'submission_payment_verified_by_accountant', 'second_payment_verified_by_accountant', 'third_payment_verified_by_accountant', 'first_payment_verified_by_cfo', 'submission_payment_verified_by_cfo', 'second_payment_verified_by_cfo', 'third_payment_verified_by_cfo', 'contract_1st_signature_status', 'contract_submission_signature_status', 'contract_2nd_signature_status', 'contract_3rd_signature_status', 'contract_1st_signature_at', 'contract_submission_signature_at', 'contract_2nd_signature_at', 'contract_3rd_signature_at', 'contract_1st_signature_verified_by_accountant', 'contract_submission_signature_verified_by_accountant', 'contract_2nd_signature_verified_by_accountant', 'contract_3rd_signature_verified_by_accountant', 'contract_1st_signature_verified', 'contract_submission_signature_verified', 'contract_2nd_signature_verified', 'contract_3rd_signature_verified', 'sub_total', 'total_vat', 'total_discount', 'total_price', 'total_paid', 'total_remaining', 'first_payment_sub_total', 'first_payment_vat', 'first_payment_discount', 'first_payment_price', 'first_payment_paid', 'first_payment_remaining', 'first_payment_agent_commision', 'first_payment_agent_commision_paid', 'submission_payment_sub_total', 'submission_payment_vat', 'submission_payment_discount', 'submission_payment_price', 'submission_payment_paid', 'submission_payment_remaining', 'submission_payment_agent_commision', 'submission_payment_agent_commision_paid', 'second_payment_sub_total', 'second_payment_vat', 'second_payment_discount', 'second_payment_price', 'second_payment_paid', 'second_payment_remaining', 'second_payment_agent_commision', 'second_payment_agent_commision_paid', 'third_payment_sub_total', 'third_payment_vat', 'third_payment_discount', 'third_payment_price', 'third_payment_paid', 'third_payment_remaining', 'third_payment_agent_commision', 'third_payment_agent_commision_paid', 'contract', 'embassy_country', 'application_stage_status', 'family_package_application_status', 'is_job_offer_letter_delivered', 'is_workpermit_delivered', 'first_payment_txn_mode', 'submission_payment_txn_mode', 'second_payment_txn_mode'
                    // )
                    $paymentCreds = [
                        'whatsPaid' => $whatsPaid,
                        'thisPayment' => $thisPayment,
                        'thisPaymentMade' => $thisPaymentMade,
                        'totalremaining' => $request['totalremaining'],
                        'whichpayment' => $request['whichpayment'],
                        'datas' => $datas['id'],
                        'totalpay' => $request->totalpay,
                        'discount' => $request->discount,
                        'totaldue' => $request->totaldue,
                        'totalremaining' => $request->totalremaining,
                        'pid' => $request->pid,
                        'couponApplied' => Session::get('discountapplied'),
                        'couponCode' => $request->discountCode,
                        'coupon' => $request->coupon
                    ];
                    //  dd($paymentCreds);

                    if ($datas === null) {
                        $data = new applicant;
                        if (in_array($apply->application_stage_status, $vals) && (empty($apply->embassy_country) || $apply->embassy_country == null)) {
                            $data->embassy_country = $request->embassy_appearance;
                        }
                        $data->pricing_plan_id = $request->ppid;

                        if ($request->whichpayment == 'FIRST') {
                            $data->first_payment_price = $thisPayment; //was remarked
                            // $data->first_payment_paid = $thisPaymentMade; //was remarked
                            $data->first_payment_vat = $thisVat;
                            // $data->first_payment_discount = $thisDiscount;
                            $data->total_price = $thisPayment + $pdet->third_payment_price;
                            $data->total_remaining = $thisPayment + $pdet->third_payment_price;
                            $data->total_vat = $thisVat;

                            $data->total_discount = 0;
                            $data->total_vat = $pdet->total_vat;
                            $data->total_price = $pdet->total_price;
                            $data->total_paid = 0;
                            $data->total_remaining = $pdet->total_price;
                        } elseif ($request->whichpayment == 'BALANCE_ON_FIRST') {
                            // $data->total_discount = 0;
                            // $data->total_vat = $pdet->total_vat;
                            // $data->total_price = $pdet->total_price;
                            $data->total_paid = $data->first_payment_paid;
                            $data->total_remaining = $pdet->total_price - $data->first_payment_paid;
                        } elseif ($request->whichpayment == 'SUBMISSION') {
                            $data->submission_payment_price = $thisPayment;
                            // $data->submission_payment_paid = $thisPaymentMade;
                            $data->submission_payment_vat = $thisVat;
                            // $data->submission_payment_discount = $thisDiscount;
                            // $data->total_discount = 0;
                            // $data->total_vat = $pdet->total_vat;
                            // $data->total_price = $pdet->total_price;
                            $data->total_paid = $data->first_payment_paid;
                            $data->total_remaining = $pdet->total_price - $data->first_payment_paid;
                        } elseif ($request->whichpayment == 'BALANCE_ON_SUBMISSION') {
                            // $data->total_discount = 0;
                            // $data->total_vat = $pdet->total_vat;
                            // $data->total_price = $pdet->total_price;
                            $data->total_paid = $data->first_payment_paid + $data->submission_payment_paid;
                            $data->total_remaining = $pdet->total_price - ($data->first_payment_paid + $data->submission_payment_paid);
                        } elseif ($request->whichpayment == 'SECOND') {
                            $data->second_payment_price = $thisPayment;
                            // $data->second_payment_paid = $thisPaymentMade;
                            // $data->second_payment_vat = ($data->second_payment_vat) ?? $thisVat;
                            // $data->second_payment_discount = $thisDiscount;
                            // $data->coupon_code = $thisCode;
                            $data->total_discount = 0;
                            // $data->total_vat = $pdet->total_vat;
                            // $data->total_price = $pdet->total_price;
                            $data->total_paid = $data->first_payment_paid + $data->submission_payment_paid;
                            $data->total_remaining = $pdet->total_price - ($data->first_payment_paid + $data->submission_payment_paid);
                            $res = $data->save();
                        } elseif ($request->whichpayment == 'BALANCE_ON_SECOND') {
                            // $data->total_discount = 0;
                            // $data->total_vat = $pdet->total_vat;
                            // $data->total_price = $pdet->total_price;
                            $data->total_paid = $data->first_payment_paid + $data->submission_payment_paid;
                            $data->total_remaining = $pdet->total_price - ($data->first_payment_paid + $data->submission_payment_paid);
                        } else {
                            // $data->second_payment_status = 'PAID';
                            $data->total_price = $thisPayment + $pdet->third_payment_price;
                            $data->total_remaining = $thisPayment + $pdet->third_payment_price;
                            $data->total_vat = $thisVat;

                            $data->total_discount = $thisDiscount;
                            // $data->total_remaining = $thisPayment + $pdet->third_payment_price;
                            //Splits
                            $paysplit = DB::table('pricing_plans')
                                ->where('destination_id', '=', $request->pid)
                                ->where('id', ($apply->pricing_plan_id) ?? $request->ppid)
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
                                $data->first_payment_price =  $paymentCreds['paysplit']->first_payment_price = ($paysplit->first_payment_sub_total - $firstDisc) + $firstVat;
                                // $data->first_payment_remaining = 
                                $data->first_payment_vat = $firstVat;
                                $data->first_payment_discount = $firstDisc;
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
                                    // $secondVat = ($paysplit->submission_payment_price * 5) / 100;
                                    $secondVat = (($request->second_p - $secondDisc) * 5) / 100;
                                } else {
                                    $secondVat = 0;
                                }
                                $paymentCreds['secondVat'] = $secondVat;

                                $data->submission_payment_price = $paymentCreds['paysplit']->submission_payment_price = $data->submission_payment_remaining = ($paysplit->submission_payment_sub_total - $secondDisc) + $secondVat;

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

                                $data->second_payment_price = $data->second_payment_remaining = $paymentCreds['paysplit']->second_payment_price = ($paysplit->second_payment_price - $thirdDisc) + $thirdVat;

                                $data->second_payment_vat = $thirdVat;
                                $data->second_payment_discount = $thirdDisc;
                            }
                        }

                        // $data->coupon_code = $thisCode;
                        // $data->application_stage_status = 2;

                        $res = $data->save();
                    } else {
                        if ((empty($apply->embassy_country) || $apply->embassy_country == null)) {
                            $datas->embassy_country = $request->embassy_appearance;
                        }
                        $datas->pricing_plan_id = $request->ppid;
                        $datas->total_discount = ($datas->coupon_code) ?  $datas->total_discount : 0;
                        $datas->total_vat = ($datas->coupon_code) ? $datas->total_vat : $pdet->total_vat;
                        $datas->total_price = ($datas->coupon_code) ? $datas->total_price : $pdet->total_price;
                        $datas->first_payment_vat = ($datas->coupon_code) ?  $datas->first_payment_vat : $pdet->first_payment_vat;
                        $datas->submission_payment_vat = ($datas->coupon_code) ? $datas->submission_payment_vat : $pdet->submission_payment_vat;
                        $datas->second_payment_vat = ($datas->coupon_code) ? $datas->second_payment_vat : $pdet->second_payment_vat;
                        if ($request->whichpayment == 'FIRST') {
                            $datas->total_paid = 0;
                            $datas->total_remaining = ($datas->coupon_code) ?  $datas->total_remaining : $pdet->total_price;
                        } else if ($request->whichpayment == 'BALANCE_ON_FIRST') {
                            $datas->total_paid = $datas->first_payment_paid;
                            $datas->total_remaining = ($datas->coupon_code) ?  $datas->total_remaining : ($pdet->total_price -  $datas->first_payment_paid);
                        } elseif ($request->whichpayment == 'SUBMISSION') {
                            $datas->total_paid = $datas->first_payment_paid;
                            $datas->total_remaining = ($datas->coupon_code) ?  $datas->total_remaining : ($pdet->total_price -  $datas->first_payment_paid);
                        } elseif ($request->whichpayment == 'BALANCE_ON_SUBMISSION') {
                            $datas->total_paid = $datas->first_payment_paid + $datas->submission_payment_paid;
                            $datas->total_remaining = ($datas->coupon_code) ?  $datas->total_remaining : ($pdet->total_price -  ($datas->first_payment_paid + $datas->submission_payment_paid));
                        } elseif ($request->whichpayment == 'SECOND') {
                            $datas->total_paid = $datas->first_payment_paid + $datas->submission_payment_paid;
                            $datas->total_remaining = ($datas->coupon_code) ?  $datas->total_remaining : ($pdet->total_price -  ($datas->first_payment_paid + $datas->submission_payment_paid));
                        } elseif ($request->whichpayment == 'BALANCE_ON_SECOND') {
                            $datas->total_paid = $datas->first_payment_paid + $datas->submission_payment_paid + $datas->second_payment_paid;
                            $datas->total_remaining = ($datas->coupon_code) ?  $datas->total_remaining : ($pdet->total_price -  ($datas->first_payment_paid + $datas->submission_payment_paid + $datas->second_payment_paid));
                        } else {
                            if (in_array($datas->first_payment_status, ['PAID', 'PARTIALLY_PAID'])) {
                                if (in_array($datas->submission_payment_status, ['PAID', 'PARTIALLY_PAID'])) {
                                    $datas->total_price = $datas->first_payment_paid +  $datas->submission_payment_paid + $thisPayment + $pdet->third_payment_price;
                                } else {
                                    $datas->total_price = $datas->first_payment_paid + $thisPayment + $pdet->third_payment_price;
                                }
                            } else {
                                $datas->total_price = $thisPayment + $pdet->third_payment_price;
                            }
                            // $datas->total_price = (in_array($datas->first_payment_status, ['PAID', 'PARTIALLY_PAID'])) ? ($datas->first_payment_paid + $thisPayment + $pdet->third_payment_price)  : $thisPayment + $pdet->third_payment_price;
                            if ($datas->submission_payment_status == 'PARTIALLY_PAID') {
                                $datas->total_vat = $datas->first_payment_vat + $datas->submission_payment_vat + $datas->third_payment_vat + $thisVat;
                            } else if ($datas->first_payment_status == 'PARTIALLY_PAID' || $datas->first_payment_status == 'PAID') {
                                $datas->total_vat = $datas->first_payment_vat + $thisVat;
                            } else {
                                $datas->total_vat = $thisVat;
                            }
                            // $datas->total_vat = $thisVat;
                            $datas->total_discount = $thisDiscount;
                            // $datas->total_remaining = $thisPayment + $pdet->third_payment_price;
                            //Splits
                            $paysplit = DB::table('pricing_plans')
                                ->where('destination_id', '=', $request->pid)
                                ->where('id', ($apply->pricing_plan_id) ?? $request->ppid)
                                // ->where('status', 'CURRENT')
                                // ->where('id', '=', $pack_id)
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
                                // $datas->first_payment_price = ($apply->first_payment_price > 0) ? $apply->first_payment_price : ($paysplit->first_payment_price - $firstDisc) + $firstVat;
                                // $paymentCreds['paysplit']->first_payment_price = ($apply->first_payment_price) ?? ($paysplit->first_payment_price - $firstDisc) + $firstVat;
                                if ($datas->first_payment_status == 'PENDING') {
                                    $paymentCreds['paysplit']->first_payment_price =  $datas->first_payment_price = ($datas->first_payment_sub_total - $firstDisc) + $firstVat;
                                    // $datas->first_payment_remaining =
                                    // $datas->first_payment_vat = ($apply->first_payment_vat) ?? $firstVat;
                                    $datas->first_payment_vat = $firstVat;
                                    $datas->first_payment_discount = $firstDisc;
                                }
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
                                // $datas->submission_payment_price = ($apply->submission_payment_price > 0) ? ($apply->first_payment_price) : ($paysplit->submission_payment_price - $secondDisc) + $secondVat;
                                // $paymentCreds['paysplit']->submission_payment_price = ($apply->submission_payment_price) ?? ($paysplit->submission_payment_price - $secondDisc) + $secondVat;
                                if ($datas->submission_payment_status == 'PENDING') {

                                    $paymentCreds['paysplit']->submission_payment_price = $datas->submission_payment_price = ($datas->submission_payment_sub_total - $secondDisc) + $secondVat;
                                    // $datas->submission_payment_remaining = ($datas->submission_payment_remaining > 0) ? ($datas->submission_payment_remaining) : ($datas->submission_payment_sub_total - $secondDisc) + $secondVat;

                                    // $datas->submission_payment_vat = ($apply->submission_payment_vat) ?? $secondVat;
                                    $datas->submission_payment_vat = $secondVat;

                                    $datas->submission_payment_discount = $secondDisc;
                                }
                                $paymentCreds['secondVat'] = $secondVat;

                                $thirdVat = 0;
                                $thirdDisc = 0;
                                //Third Split
                                if ($thisDiscount > 0) {
                                    $thirdDisc = ($datas->second_payment_sub_total * ((Session::get('discountapplied') == 1) ? ($coupon->amount) : $destination->full_payment_discount)) / 100;

                                    // $thirdDisc = ($request->third_p * $destination->full_payment_discount) / 100;
                                    // $thirdVat = (($request->third_p - $thirdDisc) * 5) / 100;

                                } else {
                                    $thirdDisc = ($datas->second_payment_sub_total * ((Session::get('discountapplied') == 1) ? $coupon->amount : 0)) / 100;
                                    // $thirdVat = ($request->third_p * 5) / 100;
                                }
                                if (isset($thisVat) && $thisVat > 0) {
                                    //$thirdVat = ($paysplit->second_payment_price * 5) / 100;
                                    $thirdVat = (($datas->second_payment_sub_total - $thirdDisc) * 5) / 100;
                                }
                                // $datas->second_payment_price = $paysplit->second_payment_price + $thirdVat;
                                // $datas->second_payment_price = ($paysplit->second_payment_price - $thirdDisc) + $thirdVat;
                                // $paymentCreds['paysplit']->second_payment_price = ($paysplit->second_payment_price - $thirdDisc) + $thirdVat;
                                $datas->second_payment_price = $paymentCreds['paysplit']->second_payment_price = ($datas->second_payment_sub_total - $thirdDisc) + $thirdVat;
                                // $datas->second_payment_remaining = ($datas->second_payment_remaining > 0) ? ($datas->second_payment_remaining) : ($datas->second_payment_sub_total - $secondDisc) + $secondVat;

                                $datas->second_payment_vat = $thirdVat;
                                $datas->second_payment_discount = $thirdDisc;
                                $paymentCreds['thirdVat'] = $thirdVat;
                            }
                        }

                        // $datas->coupon_code = $thisCode;
                        // $datas->application_stage_status = 2;

                        $res = $datas->save();
                    }
                    ###########################################################################
                    $paymentLink  = $orderCreateResponse->_links->payment->href;

                    Session::put('paymentCreds', $paymentCreds);

                    return Redirect::to($paymentLink);
                } else {
                    Session::forget('paymentCreds');
                    return redirect()->back()->with('failed', $orderCreateResponse->errors[0]->message);
                }
            } else {
                Session::forget('paymentCreds');
                // return redirect()->back()->with('failed', 'You are not authorized');
                return redirect('home');
            }
        } catch (Exception $e) {
            dd($e);
            return redirect('myapplication')->with($e->getMessage());
        }
    }

    public function submitBankTransfer(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'bank' => 'required',
                // 'datepayment' => 'required',
                // 'bank_reference' => 'required',
                // 'type_payment' => 'required',
                'imgInp' => 'required'
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)
                    ->withInput();
            }
            $user = Client::find(Auth::id());
            $signatureUrl = (isset($user->getMedia(Client::$media_collection_main_signture)[0])) ? $user->getMedia(Client::$media_collection_main_signture)[0]->getUrl() : null;
            // if ($request->whichpayment == 'FIRST') {
            // dd($signatureUrl);

            if ($signatureUrl == null && $request->whichpayment == 'FIRST') {
                return back()->with('error', 'Oppss! Please provide signature.');
            }

            Session::put('packageType', $request->packageType);

            // //Call Create Contract Function
            // self::createContract($request->pid);

            //Call Create Application Function
            $applicationId = self::createAppliacation($request->pid, $request->ppid);
            if ($request->hasFile('imgInp')) {
            } else {
                return back()->withErrors($validator)
                    ->withInput();
            }
            $applicationImg = null;

            // Payment::where('application_id', $request->applicationId)->where('payment_type', $request->whichpayment)->where('invoice_no', NULL)->where('bank_reference_no', NULL)->delete();
            $application = Application::find($applicationId);
            $application->status = ($application->status) ?? 'DOCUMENT_SUBMITTED'; // add in payment success

            $application->application_stage_status = ($application->application_stage_status == 5) ? 5 : 2;
            $paysplit = DB::table('pricing_plans')
                ->where('id', $application->pricing_plan_id)
                ->first();
            if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                $url = null;
                if ($request->whichpayment == 'FIRST' || $request->whichpayment == "BALANCE_ON_FIRST") {
                    $application->addMediaFromRequest('imgInp')->toMediaCollection(Application::$media_collection_main_1st_payment, env('MEDIA_DISK'));
                    $application->first_payment_txn_mode = ($application->is_first_payment_partially_paid == 1) ? 'BALANCE_TRANSFER' : 'TRANSFER';
                    $application->save();
                    $applicationImg = Application::find($applicationId);
                    $url =  $applicationImg->getMedia(Application::$media_collection_main_1st_payment)[0]->getFullUrl();
                } else if ($request->whichpayment == 'SUBMISSION' || $request->whichpayment == "BALANCE_ON_SUBMISSION") {
                    $application->addMediaFromRequest('imgInp')->toMediaCollection(Application::$media_collection_submission_payment, env('MEDIA_DISK'));
                    $application->submission_payment_txn_mode = ($application->is_first_payment_partially_paid == 1) ? 'BALANCE_TRANSFER' : 'TRANSFER';
                    $application->save();
                    $applicationImg = Application::find($applicationId);
                    $url =  $applicationImg->getMedia(Application::$media_collection_submission_payment)[0]->getFullUrl();
                } else if ($request->whichpayment == 'SECOND' || $request->whichpayment == "BALANCE_ON_SECOND") {
                    $application->addMediaFromRequest('imgInp')->toMediaCollection(Application::$media_collection_main_2nd_payment, env('MEDIA_DISK'));
                    $application->second_payment_txn_mode = ($application->is_first_payment_partially_paid == 1) ? 'BALANCE_TRANSFER' : 'TRANSFER';
                    $application->save();
                    $applicationImg = Application::find($applicationId);
                    $url =  $applicationImg->getMedia(Application::$media_collection_main_2nd_payment)[0]->getFullUrl();
                } else {
                    if (in_array($application->first_payment_stage_status, ['PAID', 'PARTIALLY_PAID'])) {
                        $application->addMediaFromRequest('imgInp')->toMediaCollection(Application::$media_collection_submission_payment, env('MEDIA_DISK'));
                        $application->addMediaFromRequest('imgInp')->toMediaCollection(Application::$media_collection_main_2nd_payment, env('MEDIA_DISK'));
                        $application->submission_payment_txn_mode = 'TRANSFER';
                        $application->second_payment_txn_mode = 'TRANSFER';
                        $application->save();
                        $applicationImg = Application::find($applicationId);
                        $url =  $applicationImg->getMedia(Application::$media_collection_main_2nd_payment)[0]->getFullUrl();
                    } else {
                        $application->addMediaFromRequest('imgInp')->toMediaCollection(Application::$media_collection_main_1st_payment, env('MEDIA_DISK'));
                        $application->addMediaFromRequest('imgInp')->toMediaCollection(Application::$media_collection_submission_payment, env('MEDIA_DISK'));
                        $application->addMediaFromRequest('imgInp')->toMediaCollection(Application::$media_collection_main_2nd_payment, env('MEDIA_DISK'));
                        $application->first_payment_txn_mode = 'TRANSFER';
                        $application->submission_payment_txn_mode = 'TRANSFER';
                        $application->second_payment_txn_mode = 'TRANSFER';
                        $application->save();
                        $applicationImg = Application::find($applicationId);
                        $url =  $applicationImg->getMedia(Application::$media_collection_main_2nd_payment)[0]->getFullUrl();
                    }
                }
            } else {
                $url = null;
                // dd($request->whichpayment);
                if ($request->whichpayment == 'FIRST' || $request->whichpayment == "BALANCE_ON_FIRST") {
                    $application->first_payment_txn_mode = ($application->is_first_payment_partially_paid == 1) ? 'BALANCE_TRANSFER' : 'TRANSFER';
                    $application->addMediaFromRequest('imgInp')->toMediaCollection(Application::$media_collection_main_1st_payment, 'local');
                    $application->save();
                    $applicationImg = Application::find($applicationId);

                    $url =  $applicationImg->getMedia(Application::$media_collection_main_1st_payment)[0]->getPath();
                } else if ($request->whichpayment == 'SUBMISSION' || $request->whichpayment == "BALANCE_ON_SUBMISSION") {
                    $application->submission_payment_txn_mode = ($application->is_submission_payment_partially_paid == 1) ? 'BALANCE_TRANSFER' : 'TRANSFER';
                    $application->addMediaFromRequest('imgInp')->toMediaCollection(Application::$media_collection_submission_payment, 'local');
                    $application->save();
                    $applicationImg = Application::find($applicationId);
                    $url =  $applicationImg->getMedia(Application::$media_collection_submission_payment)[0]->getPath();
                } else if ($request->whichpayment == 'SECOND' || $request->whichpayment == "BALANCE_ON_SECOND") {
                    $application->second_payment_txn_mode = ($application->is_second_payment_partially_paid == 1) ? 'BALANCE_TRANSFER' : 'TRANSFER';;
                    $application->addMediaFromRequest('imgInp')->toMediaCollection(Application::$media_collection_main_2nd_payment, 'local');
                    $application->save();
                    $applicationImg = Application::find($applicationId);
                    $url =  $applicationImg->getMedia(Application::$media_collection_main_2nd_payment)[0]->getPath();
                } else {
                    if (in_array($application->first_payment_stage_status, ['PAID', 'PARTIALLY_PAID'])) {
                        $application->addMediaFromRequest('imgInp')->toMediaCollection(Application::$media_collection_submission_payment, 'local');
                        $application->submission_payment_txn_mode = 'TRANSFER';
                        $application->second_payment_txn_mode = 'TRANSFER';
                        $application->save();
                        $application->addMediaFromRequest('imgInp')->toMediaCollection(Application::$media_collection_main_2nd_payment, 'local');
                        $applicationImg = Application::find($applicationId);
                        $url =  $applicationImg->getMedia(Application::$media_collection_submission_payment)[0]->getPath();
                    } else {
                        $application->first_payment_txn_mode = 'TRANSFER';
                        $application->submission_payment_txn_mode = 'TRANSFER';
                        $application->second_payment_txn_mode = 'TRANSFER';
                        $application->addMediaFromRequest('imgInp')->toMediaCollection(Application::$media_collection_main_1st_payment, 'local');
                        $application->save();
                        $applicationImg = Application::find($applicationId);
                        $url =  $applicationImg->getMedia(Application::$media_collection_main_1st_payment)[0]->getPath();
                        $application->addMedia($url)->preservingOriginal()->toMediaCollection(Application::$media_collection_submission_payment, 'local');
                        $application->addMedia($url)->preservingOriginal()->toMediaCollection(Application::$media_collection_main_2nd_payment, 'local');
                    }
                }
            }
            if (Session::get('discountapplied') == 1 && (($request->whichpayment == 'FIRST') ||  ($request->whichpayment == 'Full-Outstanding Payment') || ($request->whichpayment != 'BALANCE_ON_FIRST') || ($request->whichpayment != 'SUBMISSION' || $request->whichpayment != 'BALANCE_ON_SUBMISSION') || ($request->whichpayment != 'SECOND' || $request->whichpayment != 'BALANCE_ON_SECOND'))) {
                $couponCodeData = DB::table('coupons')->where('code', $request->code)->get()->first();
                $application->coupon = $request->couponDetails;
                $application->coupon_code = $request->code;

                $total = $paysplit->sub_total - $paysplit->third_payment_sub_total;
                $application->total_discount = ($total * $couponCodeData->amount) / 100;
                $totalTemp = $total - ($total * $couponCodeData->amount) / 100;
                $application->total_vat = (($totalTemp *  5) / 100) + ($paysplit->third_payment_vat);
                $application->total_remaining = $application->total_price = ($paysplit->sub_total - (($total * $couponCodeData->amount) / 100))  + (($totalTemp *  5) / 100);

                $topaynow_temp_first = $paysplit->first_payment_sub_total  - (($couponCodeData->amount *  $paysplit->first_payment_sub_total) / 100);
                $application->first_payment_discount = ($paysplit->first_payment_sub_total * $couponCodeData->amount) / 100;
                $application->first_payment_vat = ($topaynow_temp_first *  5) / 100;
                $application->first_payment_remaining = $application->first_payment_price = $topaynow_temp_first + ($topaynow_temp_first *  5) / 100;

                $topaynow_temp_submission = $paysplit->submission_payment_sub_total  - (($couponCodeData->amount *  $paysplit->submission_payment_sub_total) / 100);
                $application->submission_payment_discount = ($paysplit->submission_payment_sub_total * $couponCodeData->amount) / 100;
                $application->submission_payment_vat = ($topaynow_temp_submission *  5) / 100;
                $application->submission_payment_remaining = $application->submission_payment_price = $topaynow_temp_submission + ($topaynow_temp_submission *  5) / 100;

                $topaynow_temp_second = $paysplit->second_payment_sub_total  - (($couponCodeData->amount *  $paysplit->second_payment_sub_total) / 100);
                $application->second_payment_discount = ($paysplit->second_payment_sub_total * $couponCodeData->amount) / 100;
                $application->second_payment_vat = ($topaynow_temp_second *  5) / 100;
                $application->second_payment_remaining = $application->second_payment_price = $topaynow_temp_second + ($topaynow_temp_second *  5) / 100;
            }

            $application->save();
            // if ($payment->save()) {
            $dataArray = [
                'title' => 'New payment from ' . ucwords(Auth::user()->name),
                'client' => Auth::user()->email,
                'status' => 'newPayment',
                'body' => 'The applicant ' . Auth::user()->email . ' uploaded payment receipt. please verify!'
            ];
            if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                Mail::to(env('FINANCE_ACCOUNTANT'))->send(new NotifyMail($dataArray));
            } else {
                Mail::to('shamshera.hamza@pwggroup.pl')->send(new NotifyMail($dataArray));
            }

            $id = $request->productId;
            if ($application->application_stage_status != 5) {
                session::put('paymentMode', "TRANSFER");
                return Redirect::route('applicant.details', $application->destination_id);
            } else {
                return Redirect::route('myapplication', $application->destination_id)->with('infoMessage', 'Payment need to be confirmed!');
            }
            // return view('user.payment-confirm', compact('id'));
            // } else {
            //     return view('user.payment-confirm', compact('id'))->with('error', 'Something went wrong! Please try again');
            // }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
                    // $paymentDetails = Payment::where('id', Session::get('paymentId'))->first();
                    if (session()->has('paymentCreds')) {
                    } else {
                        $application = Applicant::where('client_id', '=', Auth::id())->orderBy('id', 'DESC')->first();
                        $dat = new payment;
                        $dat->application_id = $application->id;
                        $dat->payment_date =  date('Y-m-d');;
                        $dat->payable_amount = $paymentResponse->amount->value / 100;
                        $dat->invoice_amount = $paymentResponse->amount->value / 100;
                        $dat->bank_id = '8';
                        $dat->payment_verified_by_cfo = 0;
                        $dat->paid_amount = $paymentResponse->amount->value / 100;
                        $dat->currency = $paymentResponse->amount->currencyCode;
                        $dat->bank_reference_no = $paymentResponse->merchantOrderReference;
                        $dat->transaction_id = $paymentResponse->_id;
                        $dat->transaction_mode = 'CARD';
                        $dat->save();
                        return \Redirect::route('myapplication')->with('info', 'Payment have to be verified!');
                    }
                    $paymentCreds = Session::get('paymentCreds');
                    // dd($paymentCreds);
                    $data = applicant::where([
                        ['client_id', '=', Auth::user()->id],
                        ['destination_id', '=', $id],
                    ])
                        ->orderBy('id', 'DESC')
                        ->first();
                    $couponCodeData = null;
                    $pricing = DB::table('pricing_plans')->where('id', $data->pricing_plan_id)->first();
                    if ($paymentCreds['couponApplied'] ==  1 && (($paymentCreds['whichpayment'] == 'FIRST') ||  ($paymentCreds['whichpayment'] == 'Full-Outstanding Payment') || ($paymentCreds['whichpayment'] != 'BALANCE_ON_FIRST') || ($paymentCreds['whichpayment'] != 'SUBMISSION' || $paymentCreds['whichpayment'] != 'BALANCE_ON_SUBMISSION') || ($paymentCreds['whichpayment'] != 'SECOND' || $paymentCreds['whichpayment'] != 'BALANCE_ON_SECOND'))) {
                        $couponCodeData = DB::table('coupons')->where('code', $paymentCreds['couponCode'])->get()->first();
                        $data->coupon = $paymentCreds['coupon'];
                        $data->coupon_code = $paymentCreds['couponCode'];

                        $total = $pricing->sub_total - $pricing->third_payment_sub_total;
                        $data->total_discount = ($total * $couponCodeData->amount) / 100;
                        $totalTemp = $total - ($total * $couponCodeData->amount) / 100;
                        $data->total_vat = $totalVat = (($totalTemp *  5) / 100) + ($pricing->third_payment_vat);
                        $totalTemp = $totalTemp + $totalVat;
                        $data->total_remaining = $data->total_price = $totalTemp + $pricing->third_payment_sub_total;

                        $topaynow_temp_first = $pricing->first_payment_sub_total  - (($couponCodeData->amount *  $pricing->first_payment_sub_total) / 100);
                        $data->first_payment_discount = ($pricing->first_payment_sub_total * $couponCodeData->amount) / 100;
                        $data->first_payment_vat = ($topaynow_temp_first *  5) / 100;
                        $data->first_payment_remaining = $data->first_payment_price = $topaynow_temp_first + ($topaynow_temp_first *  5) / 100;

                        $topaynow_temp_submission = $pricing->submission_payment_sub_total  - (($couponCodeData->amount *  $pricing->submission_payment_sub_total) / 100);
                        $data->submission_payment_discount = ($pricing->submission_payment_sub_total * $couponCodeData->amount) / 100;
                        $data->submission_payment_vat = ($topaynow_temp_submission *  5) / 100;
                        $data->submission_payment_remaining = $data->submission_payment_price = $topaynow_temp_submission + ($topaynow_temp_submission *  5) / 100;

                        $topaynow_temp_second = $pricing->second_payment_sub_total  - (($couponCodeData->amount *  $pricing->second_payment_sub_total) / 100);
                        $data->second_payment_discount = ($pricing->second_payment_sub_total * $couponCodeData->amount) / 100;
                        $data->second_payment_vat = ($topaynow_temp_second *  5) / 100;
                        $data->second_payment_remaining = $data->second_payment_price = $topaynow_temp_second + ($topaynow_temp_second *  5) / 100;
                    }
                    if ($paymentCreds['whichpayment'] == 'FIRST' || $paymentCreds['whichpayment'] == 'BALANCE_ON_FIRST') {
                        if ($paymentCreds['whatsPaid'] == 'PARTIALLY_PAID') { // add in payment success
                            // $data->first_payment_remaining =  $paymentCreds['thisPayment'] - $paymentCreds['thisPaymentMade']; // add in payment success
                            // $data->first_payment_remaining =  ($paymentCreds['thisPayment'] + $paymentCreds['discount']) - $paymentCreds['thisPaymentMade'];
                            $data->first_payment_remaining = $data->first_payment_price - $paymentCreds['totalpay'];
                            $data->is_first_payment_partially_paid = 1; // add in payment success
                            $data->status = 'WAITING_FOR_BALANCE_ON_FIRST_PAYMENT'; // add in payment success
                            $data->first_payment_paid = $paymentCreds['totalpay'];
                        } else { // add in payment success
                            $data->first_payment_remaining = 0; // add in payment success

                            $data->is_first_payment_partially_paid = 0; // add in payment success
                            $data->status = 'DOCUMENTS_SUBMITTED'; // add in payment success
                            $data->first_payment_paid = ($data->first_payment_status == "PARTIALLY_PAID") ? $data->first_payment_paid + $paymentCreds['totalpay'] : $paymentCreds['totalpay'];

                            $data->first_payment_verified_by_accountant = 1;
                            $data->first_payment_verified_by_cfo = 1;
                        }
                        $data->first_payment_status = $paymentCreds['whatsPaid'];
                        $data->first_payment_price = $paymentCreds['thisPayment']; // add in payment success

                    } elseif ($paymentCreds['whichpayment'] == 'SUBMISSION' || $paymentCreds['whichpayment'] == 'BALANCE_ON_SUBMISSION') {

                        $data->submission_payment_paid = $data->submission_payment_paid + $paymentCreds['thisPaymentMade']; // add in payment success
                        $data->submission_payment_status = ($paymentCreds['whichpayment'] == 'BALANCE_ON_SUBMISSION') ? "PAID" : $paymentCreds['whatsPaid'];  // add in payment success
                        if ($data->work_permit_status == "WORK_PERMIT_RECEIVED") {
                            $data->status = 'WAITING_FOR_EMBASSY_APPEARANCE';  // add in payment success
                        }
                        if ($paymentCreds['whatsPaid'] == 'PARTIALLY_PAID') { // add in payment success
                            $data->is_submission_payment_partially_paid = 1; // add in payment success
                        } // add in payment success
                        $data->submission_payment_remaining = 0;
                        $data->submission_payment_verified_by_accountant = 1;
                        $data->submission_payment_verified_by_cfo = 1;
                        $data->is_submission_payment_partially_paid = 0; // add in payment success
                        // }
                    } elseif ($paymentCreds['whichpayment'] == 'SECOND' || $paymentCreds['whichpayment'] == 'BALANCE_ON_SECOND') {
                        $data->second_payment_paid = $data->second_payment_paid + $paymentCreds['thisPaymentMade']; // add in payment success
                        $data->second_payment_status = $paymentCreds['whatsPaid']; // add in payment success
                        if ($data->work_permit_status == "WAITING_FOR_EMBASSY_APPEARANCE") {
                            $data->status = 'WAITING_FOR_VISA';  // add in payment success
                        }
                        if ($paymentCreds['whatsPaid'] == 'PARTIALLY_PAID') { // add in payment success
                            $data->is_second_payment_partially_paid = 1; // add in payment success
                        } else {
                            $data->is_second_payment_partially_paid = 0; // add in payment success
                        }
                        $data->second_payment_remaining = 0;
                        $data->second_payment_verified_by_accountant = 1;
                        $data->second_payment_verified_by_cfo = 1;
                    } else {

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
                            $data->first_payment_remaining = 0;
                            $data->submission_payment_remaining = 0;
                            $data->second_payment_remaining = 0;
                        }

                        $data->first_payment_verified_by_accountant = 1;
                        $data->first_payment_verified_by_cfo = 1;
                        $data->submission_payment_verified_by_accountant = 1;
                        $data->submission_payment_verified_by_cfo = 1;
                        $data->second_payment_verified_by_accountant = 1;
                        $data->second_payment_verified_by_cfo = 1;

                        $data->is_first_payment_partially_paid = 0;
                        $data->is_submission_payment_partially_paid = 0;
                        $data->is_second_payment_partially_paid = 0;

                        $data->status = 'DOCUMENTS_SUBMITTED'; // add in payment success
                    }
                    $data->total_remaining = ($data->total_price - $data->total_paid) - $paymentCreds['thisPaymentMade'];
                    $data->total_paid = $data->total_paid + $paymentCreds['thisPaymentMade'];
                    // $data->total_remaining = $data->total_remaining - $paymentCreds['thisPaymentMade'];
                    $data->save();


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

                    $thisDay =  date('Y-m-d');
                    $ppd = payment::where([
                        ['application_id', '=', $data->id],
                        ['payment_type', $paymentCreds['whichpayment']]
                    ])
                        ->first();
                    $datas = applicant::where([
                        ['client_id', '=', Auth::user()->id],
                        ['destination_id', '=', $paymentCreds['pid']],
                    ])
                        ->orderBy('id', 'Desc')
                        ->first();
                    if ($ppd === null) {
                        $dat = new payment;

                        $dat->payment_type = $paymentCreds['whichpayment'];
                        $dat->application_id = $data->id;
                        $dat->payment_date = $thisDay;
                        $dat->payable_amount = ($paymentCreds['whichpayment'] == 'BALANCE_ON_FIRST') ? $paymentCreds['totalpay'] : $paymentCreds['totaldue'];
                        $dat->invoice_amount = $paymentCreds['totalpay'];

                        $dat->bank_id = '8';
                        $dat->payment_verified_by_cfo = 1;
                        $dat->paid_amount = $paymentCreds['totalpay'];
                        $dat->currency = $paymentResponse->amount->currencyCode;
                        $dat->bank_reference_no = $paymentResponse->merchantOrderReference;
                        $dat->transaction_id = $paymentResponse->_id;
                        $dat->transaction_mode = 'CARD';

                        $dat->remaining_amount = (isset($paymentCreds['totalremaining'])) ? NULL : $paymentCreds['totaldue'] - $paymentCreds['totalpay'];
                        // dd($dat);
                        $dat->save();
                        Session::put('paymentId', $dat->id);
                    } else {
                        Session::put('paymentId', $ppd->id);

                        if (isset($paymentCreds['totalremaining']) && $paymentCreds['totalremaining'] > 0) {
                            $ppd->payment_type = $paymentCreds['whichpayment'];
                        } else {
                            $ppd->payment_type = $paymentCreds['whichpayment'];
                        }
                        $ppd->application_id = $data->id;
                        $ppd->payment_date = $thisDay;
                        $ppd->payable_amount = ($paymentCreds['whichpayment'] == 'BALANCE_ON_FIRST') ? $paymentCreds['totalpay'] : $paymentCreds['totaldue'];
                        $ppd->invoice_amount = $paymentCreds['totalpay'];

                        $ppd->bank_id = 8;
                        $ppd->payment_verified_by_cfo = 1;
                        $ppd->paid_amount = $paymentCreds['totalpay'];
                        $ppd->currency = $paymentResponse->amount->currencyCode;
                        $ppd->bank_reference_no = $paymentResponse->merchantOrderReference;
                        $ppd->transaction_id = $paymentResponse->_id;
                        $ppd->transaction_mode = 'CARD';

                        $ppd->save();
                    }

                    $monthYear = explode('-', $paymentResponse->paymentMethod->expiry);

                    // Send Notifications on This Payment ##############
                    $email = Auth::user()->email;
                    $userID = Auth::user()->id;
                    if ((isset($ppd) && ($ppd['payment_type'] == "FIRST" || $ppd['payment_type'] == "BALANCE_ON_FIRST")) || (isset($dat) && ($dat['payment_type'] == "FIRST" || $dat['payment_type'] == "BALANCE_ON_FIRST"))) {
                        $ems = "";
                    } else if (isset($ppd) && ($ppd['payment_type'] == "SUBMISSION")) {
                        $ems = " You will be notified when your Work Permit is ready.";
                    } else {
                        $ems = " You will be notified when your embassy appearance date is set.";
                    }

                    $paym = ucwords(strtolower(str_replace('_', ' ', $paymentCreds['whichpayment'])));

                    if ($paym == "Full-outstanding Payment") {
                        $criteria = $paym . " Completed!";
                    } else {
                        $criteria = $paym . " Payment Completed!";
                    }
                    $message = "You have successfully made your " . $paym . " Payment. Check your receipt on 'My Application'. " . $ems;

                    $link = "";

                    $dataArray = [
                        'title' => $criteria . ' Mail from PWG Group',
                        'body' => $message,
                        'link' => $link,
                        'paymentType' => $paymentCreds['whichpayment'],
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
                    Session::forget('discountapplied');

                    if ($data->application_stage_status != 5) {
                        session::put('paymentMode', "NETWORK");
                        return Redirect::route('applicant.details', $data->destination_id);
                    } else {
                        return Redirect::route('myapplication', $data->destination_id)->with('message', 'Payment successfull!');
                    }
                    // return view('user.payment-success', compact('id'));

                } else {
                    Session::forget('paymentCreds');
                    return \Redirect::route('payment-fail', $id);
                }
            } else {
                Session::forget('paymentCreds');
                $error = $paymentResponse->_embedded->payment[0]->authResponse->resultMessage;
                Session::put('paymentError', $error);
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
        $id = Session::get('myproduct_id');

        if ($pays) {
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
            return view('user.payment-fail', compact('id'));
        } else {
            return view('user.payment-fail', compact('id'));
        }
    }

    public function getPromo(Request $request)
    {
        $response = [];
        $coupon = [];
        $coupon_code = $request->discount_code;
        if (isset($coupon_code)) {
            $coupon_code = strtolower($coupon_code);
            $coupon['code'] = $coupon_code;
            $couponCodeData = DB::table('coupons')->where('code', $coupon_code)->get()->first();

            if (
                $couponCodeData
                && $couponCodeData->code
                && $couponCodeData->active == true
            ) {

                if (isset($couponCodeData->employee_id) && $couponCodeData->employee_id) {

                    if ($couponCodeData->active_from > now()) {

                        $coupon['status'] = 'offer_not_started_yet';
                        $coupon['is_valid'] = false;
                        $topaynoww = $request->totaldue; //If no promo
                        $response['topaynow'] = $topaynoww;
                        $response['message'] = "Offer not started yet!";
                        $response['status'] = false;
                        $response['coupon'] = $coupon;
                    } else if ($couponCodeData->active_until < now()) {

                        $coupon['status'] = 'code_expired';
                        $coupon['is_valid'] = false;
                        Session::put('haveCoupon', 0);
                        $response['haveCoupon'] = 0;
                        $topaynoww = $request->totaldue; //If no promo
                        $response['topaynow'] = $topaynoww;
                        $response['message'] = "Code expired!";
                        $response['status'] = false;
                        $response['coupon'] = $coupon;
                    } else {

                        $couponUsage = Application::where(
                            [
                                ['coupon_code', '=', $coupon_code]
                            ]
                        )->get()->count();
                        if ($couponUsage == 0) {
                            Session::put('haveCoupon', 1);
                            Session::put('myDiscount', $couponCodeData->amount);
                            Session::put('discountapplied', 1);
                            $coupon['is_valid'] = true;
                            $coupon['status'] = 'not_used_yet';
                            $coupon['reward'] = $couponCodeData->reward;
                            $coupon['amount'] = $couponCodeData->amount;
                            $response['myDiscount'] = $couponCodeData->amount;
                            $response['haveCoupon'] = 1;
                            $discountamt = ($couponCodeData->amount *  $request->paynow) / 100;
                            $response['discountamt'] = $discountamt;
                            $topaynow_temp = $request->paynow  - (($couponCodeData->amount *  $request->paynow) / 100);
                            $vatNow = ($topaynow_temp *  5) / 100;
                            $topaynow = $topaynow_temp + $vatNow;
                            $response['topaynow'] = $topaynow;
                            $response['vatNow'] = $vatNow;
                            $discountPercent = 'PROMO: ' . $couponCodeData->amount . '%';
                            $response['discountPercent'] = $discountPercent;
                            $response['coupon'] = $coupon;
                            $response['status'] = true;
                            $response['message'] = "Coupon applied!";
                        } else {
                            $coupon['is_valid'] = false;
                            $coupon['status'] = 'already_used';
                            $topaynoww = $request->totaldue; //If no promo
                            Session::put('haveCoupon', 0);
                            $response['haveCoupon'] = 0;
                            $response['topaynow'] = $topaynoww;
                            $response['message'] = "Already used";
                            $response['status'] = false;
                            $response['coupon'] = $coupon;
                        }
                    }
                } else {
                    $coupon['is_valid'] = false;
                    $coupon['status'] = 'not_assigned_yet';
                    $topaynoww = $request->totaldue; //If no promo
                    Session::put('haveCoupon', 0);
                    $response['haveCoupon'] = 0;
                    $response['topaynow'] = $topaynoww;
                    $response['message'] = "Not assigned yet!";
                    $response['status'] = false;
                    $response['coupon'] = $coupon;
                }
            } else {
                $coupon['status'] = false;
                $coupon['status'] = 'invalid_code';
                $topaynoww = $request->totaldue; //If no promo
                Session::put('haveCoupon', 0);
                $response['haveCoupon'] = 0;
                $response['topaynow'] = $topaynoww;
                $response['message'] = "Inavlid code!";
                $response['status'] = false;
                $response['coupon'] = $coupon;
            }
        } else {
            $coupon['status'] = false;
            $coupon['status'] = 'invalid_code';
            $topaynoww = $request->totaldue; //If no promo
            Session::put('haveCoupon', 0);
            $response['haveCoupon'] = 0;
            $response['topaynow'] = $topaynoww;
            $response['message'] = "Please provide coupon code!";
            $response['status'] = false;
            $response['coupon'] = $coupon;
        }

        return $response;

        // $response['status'] = false;
        // $id = Session::get('myproduct_id');
        // $coupon = DB::table('coupons')
        //     ->select('amount')
        //     ->where('code', '=', strip_tags($request->discount_code))
        //     ->where('employee_id', '=', $id)
        //     ->where('active_from', '<=', date('Y-m-d'))
        //     ->where('active_until', '>=', date('Y-m-d'))
        //     ->where('active', '=', 1)
        //     ->get();

        // foreach ($coupon as $apply) {
        //     $my_discount = $apply->amount;
        // }


        // if ($coupon->first()) {

        //     $discountPercent = 'PROMO: ' . $my_discount . '%';
        //     $discountamt = ($my_discount *  $request->totaldue) / 100;

        //     $topaynow = $request->totaldue  - (($my_discount *  $request->totaldue) / 100);
        //     if ($request->vat > 0) {
        //         $vatNow = ($topaynow_temp *  5) / 100;
        //         $topaynow = $topaynow_temp + $vatNow;
        //     } else {
        //         $topaynow = $topaynow_temp;
        //         $vatNow = 0;
        //     }

        //     Session::put('haveCoupon', 1);
        //     Session::put('myDiscount', $my_discount);
        //     Session::put('discountapplied', 1);

        //     $response['myDiscount'] = $my_discount;
        //     $response['haveCoupon'] = 1;
        //     $response['discountamt'] = $discountamt;
        //     $response['topaynow'] = $topaynow;
        //     $response['vatNow'] = $vatNow;
        //     $response['discountPercent'] = $discountPercent;

        //     $response['status'] = true;


        //     // return \Redirect::route('payment', $id);
        // } else {
        //     $topaynoww = $request->totaldue; //If no promo
        //     Session::put('haveCoupon', 0);
        //     $response['haveCoupon'] = 0;
        //     $response['topaynow'] = $topaynoww;
        //     // return \Redirect::route('payment', $id)->with('failed', 'Invalid Discount/Promo Code');

        // }
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
                $client = Client::find(Auth::id());
                $destination_file = 'Applications/Contracts/client_contracts/' . $newFileName;
                $data = pdfBlock::mapDetails($originalPdf, $destination_file, $productName, Session::get('packageType'), $client);
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
                // ->where('status', 'CURRENT')
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
        if (isset($ptype)) {
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
                // ->where('status', 'CURRENT')
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
            ->select('name', 'sur_name', 'phone_number')
            ->where("name", "LIKE", "%{$request->str}%")
            ->where('is_active', '=', 1)
            ->whereRaw('name != ""')
            ->whereIn('designation_id', [1, 33, 35])
            ->orderBy('id', 'asc')
            ->get('query');

        return response()->json($data);
    }

    public function callSchdule(Request $request)
    {
        try {
            Artisan::call('send:offerletter');
            Artisan::call('week:delete');
            Artisan::call('clear:quickbookerror');
            Artisan::call('send:workPermit');
            Artisan::call('quickbook:invoice');
        } catch (exception $e) {
            echo $e;
        }
    }

    public function callQuickbookSchdule()
    {
        Artisan::call('quickbook:cron');
    }

    public function callReminderEmail()
    {
        Artisan::call('reminder:email');
    }

    public function updateFooterTimer(Request $request)
    {
        Timer::updateOrCreate([
            'id' => 1
        ], [
            'date' => $request->date
        ]);
    }

    public function updateContract()
    {
        $applications = Application::where('created_at', '>=', "2023-03-10")
            ->get();
        foreach ($applications as $application) {
            $pricingPlan = DB::table('pricing_plans')->where('id', $application->pricing_plan_id)->where('status', '=', "CURRENT")->where('is_active', 1)->first();
            if ($pricingPlan) {
                $client = Client::find($application->client_id);
                $productName = DB::table('destinations')
                    ->where('id', $application->destination_id)
                    ->pluck('name')
                    ->first();
                $productName = strtolower($productName);
                if ($productName == Constant::poland) {
                    $originalPdf = "pdf/poland.pdf";
                    $rand = UserHelper::getRandomString();
                    $newFileName = 'contract' . $client->id . '-' . $rand . '-' . 'poland.pdf';
                } else if ($productName == Constant::czech) {
                    $originalPdf = "pdf/czech.pdf";
                    $rand = UserHelper::getRandomString();
                    $newFileName = 'contract' . $client->id . '-' . $rand . '-' . 'czech.pdf';
                } else if ($productName == Constant::malta) {
                    $originalPdf = "pdf/malta.pdf";
                    $rand = UserHelper::getRandomString();
                    $newFileName = 'contract' . $client->id . '-' . $rand . '-' . 'malta.pdf';
                } else if ($productName == Constant::canada) {
                    if ($application->work_permit_category == Constant::CanadaExpressEntry) {
                        $originalPdf = "pdf/canada_express_entry.pdf";
                        $rand = UserHelper::getRandomString();
                        $newFileName = 'contract' . $client->id . '-' . $rand . '-' . 'canada_express_entry.pdf';
                    } else if ($application->work_permit_category == Constant::CanadaStudyPermit) {
                        $originalPdf = "pdf/canada_study.pdf";
                        $rand = UserHelper::getRandomString();
                        $newFileName = 'contract' . $client->id . '-' . $rand . '-' . 'canada_study.pdf';
                    } else if ($application->work_permit_category == Constant::BlueCollar) {
                        $originalPdf = "pdf/canada.pdf";
                        $rand = UserHelper::getRandomString();
                        $newFileName = 'contract' . $client->id . '-' . $rand . '-' . 'canada.pdf';
                    }
                } else if ($productName == Constant::germany) {
                    $originalPdf = "pdf/poland.pdf";
                    $rand = UserHelper::getRandomString();
                    $newFileName = 'contract' . $client->id . '-' . $rand . '-' . 'germany.pdf';
                } else {
                    $originalPdf = "pdf/poland.pdf";
                    $rand = UserHelper::getRandomString();
                    $newFileName = 'contract' . $client->id . '-' . $rand . '-' . 'germany.pdf';
                }
                if ($newFileName && $originalPdf) {
                    // $destination_file = 'pdf/'.$newFileName;
                    // public_path('storage/Applications/Contracts/client_contracts/'.$newFileName);
                    $destination_file = 'Applications/Contracts/client_contracts/' . $newFileName;
                    $data = pdfBlock::mapDetails($originalPdf, $destination_file, $productName, $application->work_permit_category, $client);
                    Applicant::where('id', $application->id)
                        ->update([
                            'contract' => $newFileName
                        ]);
                }
            }
        }
        $applications = Application::where('created_at', '>=', "2023-03-10")
            ->get();
        foreach ($applications as $application) {
            $pricingPlan = DB::table('pricing_plans')->where('id', $application->pricing_plan_id)->where('status', '=', "CURRENT")->where('is_active', 1)->first();
            if ($pricingPlan) {
                $client = Client::find($application->client_id);
                $originalPdf = Storage::disk(env('MEDIA_DISK'))->url('Applications/Contracts/client_contracts/' . $application->contract);

                $paymentType =  "FIRST";
                $user = Client::find($client->id);
                $data = product::find($application->destination_id);

                $signatureUrl = (isset($user->getMedia(Client::$media_collection_main_signture)[0])) ? $user->getMedia(Client::$media_collection_main_signture)[0]->getUrl() : null;


                $result = pdfBlock::attachSignature($originalPdf, $signatureUrl, $data, $paymentType, $application, $user);
            }
        }
    }

    public function addPassportDetails($id)
    {
        $applicant = Application::find($id);
        pdfBlock::mapMoreInfo($applicant);
    }
}
