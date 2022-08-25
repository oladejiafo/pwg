<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\product;
use App\Models\product_payments;
use App\Models\payment;
use App\Models\product_details;
use DB;
use Session;
use Exception;

class HomeController extends Controller
{
    public function redirect()
    {

        if(session('prod_id'))
        {
          $idd = Session::get('prod_id');

          return \Redirect::route('product', $idd);

        } else{
                $package = product::all();
                return view('user.home', compact('package'));
        }            
        
    }

    public function index()
    {
        $package = product::all()->sortBy("id");
        return view('user.home', compact('package'));
    }

    public function product($id)
    {
        $data = product::find($id);
        $ppay = product_payments::where('product_id', '=', $id)->get();
        $proddet = product_details::where('product_id', '=', $id)->get();
        session()->forget('prod_id');
        return view('user.package', compact('data', 'ppay', 'proddet'));
    }

    public function signature(Request $request, $id)
    {
        if (Auth::id()) {
            Session::put('myproduct_id', $id);
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
            
            return \Redirect::route('referal', $request->pid)
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

                $pays = DB::table('applicants')
                    ->leftJoin('payments', 'payments.application_id', '=', 'applicants.id')
                    ->leftJoin('product_payments', 'product_payments.id', '=', 'payments.product_payment_id')
                    ->select('product_payments.*', 'payments.product_payment_id', 'payments.total')
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

            // } else if($applied == '2' || $applied == '3' || $applied == '4') {
            //     $productId = $id;
            //     return \Redirect::route('applicant', $productId)->with('failed', 'Payment Already Completed');
            // } else if($applied == '5') {
            //     $package = product::all();
            //     return view('user.home', compact('package'))->with('failed', 'Application Already Completed');
            // } else {
            //     $data = product::find($id);
            //     return view('user.referal-details', compact('data'))->with('failed', 'You are not done with Referral pls. Complete this section before you make payment');
            // }

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
            
            $request->validate([
                'card_number' => 'required',
                'card_holder_name' => 'required',
                'month' => 'required',
                'year' => 'required',
                'cvv' => 'required',
                'totalpay' => 'required'
            ]);

            // Save Payment Information
            $datas = payment::where([
                ['product_payment_id', '=', $request->ppid],
                ['payment_type', '=', $request->whichpayment],
                ['application_id', '=', $applicant_id],
            ])->first();
            if ($datas === null) {
                $data = new payment;
                $data->product_payment_id = $request->ppid;
                $data->application_id = $applicant_id;
                $data->card_holder_name = $request->card_holder_name;
                $data->total = $request->totalpay;
                $data->payment_status = 'Paid';
                $data->payment_type = $request->whichpayment;
    
                // if($request->save_card ==1) {
                    $data->save_card_info = $request->save_card;
                    $data->card_number = $request->card_number;
                    $data->month = $request->month;
                    $data->year = $request->year;
                    $data->cvv = $request->cvv;
                // }
                $res = $data->save();
            } else {
                $datas->product_payment_id = $request->ppid;
                $datas->application_id = $applicant_id;
                $datas->card_holder_name = $request->card_holder_name;
                $datas->total = $request->totalpay;
                $datas->payment_status = 'Paid';
                $datas->payment_type = $request->whichpayment;

                // if($request->save_card ==1) {
                    $datas->save_card_info = $request->save_card;
                    $datas->card_number = $request->card_number;
                    $datas->month = $request->month;
                    $datas->year = $request->year;
                    $datas->cvv = $request->cvv;
                // }
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
                $status->applicant_status = '2';
                $status->save();
            }
            if ($res) { 
                $productId = $id;
                $dest = product::find($request->pid);
                $dest_name = $dest->product_name;
    
                $msg="Awesome! Payment Successful!";

                return \Redirect::route('applicant', $request->pid)->with('info', $msg)->with('info_sub', 'You journey to ' .$dest_name. ' just began!');
              
            } else {
                return redirect()->back()->with('failed', 'Oppss! Something Went Wrong!');
            }
        } else {
            return redirect()->back()->with('failed', 'You are not authorized');
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

}
