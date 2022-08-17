<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\product;
use App\Models\product_payments;
use App\Models\payment;
use App\Models\product_details;
use DB;
use Exception;

class HomeController extends Controller
{
    public function redirect()
    {
        // if (Auth::id()) {
        //     if (Auth::user()->usertype == 0) {
        //         $package = product::all();
        //         return view('user.home', compact('package'));
        //         //                return view('user.home');
        //     } else {
        $package = product::all();
        return view('user.home', compact('package'));
        //     }
        // } else {
        //     return redirect()->back();
        // }
    }

    public function index()
    {
        // if (Auth::id()) {
        //     return redirect('home');
        // } else {
        $package = product::all();
        return view('user.home', compact('package'));
        //}
    }

    public function product($id)
    {
        $data = product::find($id);
        $ppay = product_payments::where('product_id', '=', $id)->get();
        $proddet = product_details::where('product_id', '=', $id)->get();
  
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
            // Session::put('myproduct_id', $id);
            // Session::put('payall', $payall);
            // Session::get('variableName');
            $data = product::find($id);
            return view('user.referal-details', compact('data'));
        } else {
            return redirect()->back()->with('message', 'You are not authorized');
        }
    }

    public function upload(Request $request)
    {
        if (Auth::id()) {

            $signature = user::find($request->user_id);

       
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    //  print_r($image);
                    $imagename = time() . '.' . $image->getClientOriginalExtension();

                    $destinationPath = 'signature';
                    $image->move($destinationPath, $imagename);
                    $signature->signature = $imagename;
                }
                $signature->save();
                return \Redirect::route('referal', $request->pid);
            
           
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
                $data->applicant_status = 'In Progress';
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
                $datas->applicant_status = 'In Progress';
                $datas->product_id = $request->pid;
                if (Auth::id()) {
                    $datas->user_id = Auth::user()->id;
                    $datas->first_name = Auth::user()->name;
                }
                $res = $datas->save();
            }

            if ($res) {
                return \Redirect::route('payment', $request->pid); //->with('success', 'Referral Saved. Upload Signature to proceed')
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

            $paid = DB::table('payments')
                ->join('applicants', 'payments.application_id', '=', 'applicants.id')
                ->select('payments.*', 'applicants.*')
                ->where('applicants.user_id', '=', $id)
                ->groupBy('payments.id')
                ->groupBy('applicants.id')
                ->orderBy('applicants.id', 'desc')
                ->limit(1)
                ->get();

            $pays = DB::table('product_payments')
                ->join('applicants', 'applicants.product_id', '=', 'product_payments.product_id')
                ->select('product_payments.id', 'product_payments.payment', 'product_payments.amount', 'product_payments.product_id')
                ->where('applicants.user_id', '=', $id)
                ->groupBy('product_payments.id')
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
        if (Auth::id()) {
            $data = product::find(Session::get('myproduct_id'));
            $id = Session::get('myproduct_id');
            $payall = Session::get('payall'); //$request->payall;

            // Session::put('payall', $request->payall');

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

            return view('user.payment-form', compact('data', 'pdet', 'pays','payall'));
        } else {
            return redirect()->back()->with('message', 'You are not authorized');
        }
    }

    /**
     * 
     * 
     *Redirest to step 3 of Applicant details
     * 
     */
    public function applicant()
    {
        return view('user.applicant');
    }

    /**
     * Store applicant details at step 3
     * @param Request
     *
     * @return void
     */
    public function applicantDetails(Request $request)
    {
        $request->validate([
            'applied_country' => 'required',
            'job_type' => 'required',
            'cv' => 'required|mimes:pdf',
            'agent_phone' => 'required',
            'agent_name' => 'required',
            'embassy_country' => 'required',
            'agree' => 'required'
        ]);
        $file = $request->file('cv');
        $fileName = time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());

        $destinationPath = 'public/resumes';
        $file->storeAs($destinationPath, $fileName);

        Applicant::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->update([
                'country' => $request->applied_country,
                'job_type' => $request->job_type,
                'resume' => $fileName,
                'agent_phone_number' => $request->agent_phone,
                'agent_name' => $request->agent_name,
                'embassy_country' => $request->embassy_country,
            ]);

        return view('user.application-next')->with('success', 'Data saved successfully!');
    }

    public function addpayment(Request $request)
    {
        if (Auth::id()) {
            $request->validate([
                'card_number' => 'required',
                'card_holder_name' => 'required',
                'month' => 'required',
                'year' => 'required',
                'cvv' => 'required',
                'totalpay' => 'required'
            ]);

            // $data = new applicant;
            $datas = payment::where([
                ['product_payment_id', '=', $request->ppid],
                ['payment_type', '=', $request->whichpayment],
                ['application_id', '=', 1],
            ])->first();
            if ($datas === null) {
                $data = new payment;
                $data->product_payment_id = $request->ppid;
                $data->application_id = 1;
                $data->card_holder_name = $request->card_holder_name;
                $data->total = $request->totalpay;
                $data->payment_status = 'Paid';
                $data->payment_type = $request->whichpayment;
    
                if($request->get('save_card')) {
                    $data->save_card_info = $request->get('save_card');
                    $data->card_number = $request->card_number;
                    $data->month = $request->month;
                    $data->year = $request->year;
                    $data->cvv = $request->cvv;
                }
                $res = $data->save();
            } else {
                $datas->product_payment_id = $request->ppid;
                $datas->application_id = 1;
                $datas->card_holder_name = $request->card_holder_name;
                $datas->total = $request->totalpay;
                $datas->payment_status = 'Paid';
                $datas->payment_type = $request->whichpayment;

                if($request->get('save_card')) {
                    $datas->save_card_info = $request->get('save_card');
                    $datas->card_number = $request->card_number;
                    $datas->month = $request->month;
                    $datas->year = $request->year;
                    $datas->cvv = $request->cvv;
                }
                $res = $datas->save();
            }

            if ($res) {
                return view('user.applicant');
                // return \Redirect::route('/')->with('success', 'Payment Successful');
            } else {
                return redirect()->back()->with('failed', 'Oppss! Something Went Wrong!');
            }
        } else {
            return redirect()->back()->with('failed', 'You are not authorized');
        }
    }

}
