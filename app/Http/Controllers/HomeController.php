<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\product;
use App\Models\product_payments;
use App\Models\payment;
use DB;

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

        return view('user.package', compact('data', 'ppay'));
    }

    public function signature($id)
    {
        if (Auth::id()) {
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
            return \Redirect::route('signature_success', $request->pid)->with('message', 'Uploaded');
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
            $data = new applicant;
            $data->referral_first_name = $request->referrer_first_name;
            $data->referral_last_name = $request->referrer_last_name;
            $data->coupon_code = $request->coupon_code;
            $data->current_residance_country = $request->current_location;
            $data->applicant_status = 0;
            $data->product_id = $request->pid;
            if (Auth::id()) {
                $data->user_id = Auth::user()->id;
                $data->first_name = Auth::user()->name;
            }
            $res = $data->save();

if ($res) {
    return \Redirect::route('signature', $request->pid)->with('success', 'ReferralSaved. Upload Signature to proceed');
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

            $paid = DB::table('applicants')
                ->join('payments', 'payments.application_id', '=', 'applicants.id')
                ->where('applicants.user_id', '=', $id)
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


    public function affiliate()
    {
        return view('user.payment-form');
    }
}
