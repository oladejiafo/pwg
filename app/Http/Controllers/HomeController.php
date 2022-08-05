<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\User;
use App\Models\product;
use App\Models\product_payments;

use App\Models\payment;
use App\Models\Applicant;

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
    // public function signup(){
    //     return view('auth.home');
    // }

    //     public function packageview($id){
    // if ($id) {
    //     $data = product::where('id', $id)->get();
    //     return view('user.package', compact('data'));
    // } else {
    //     return redirect()->back();
    // }
    //     }

    public function product($id)
    {
        $data = product::find($id);
        $ppay = product_payments::where('product_id', '=', $id)->get();
        // $ppay = DB::select( DB::raw(" SELECT * FROM product_payments WHERE product_id = '$id'"));

        return view('user.package', compact('data','ppay'));
    }

    public function signature($id)
    {
        $data = product::find($id);
        return view('user.signature', compact('data'));
    }

    public function upload(Request $request)
    {
        // $signature = new user;
        //Auth::user()->id;
        $signature = user::find($request->user_id);
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            //  print_r($image);
             $imagename = time().'.'.$image->getClientOriginalExtension();

             $destinationPath = 'signature';
             $image->move($destinationPath, $imagename);
            $signature->signature = $imagename;
        }


        $signature->save();
        return view('user.signature-upload-success')->with('pid',$request->p_id);
        
        // return redirect()->back()->with('message', 'Signature Appended Successfully');
    }

    public function myapplication() {
        $id = Auth::user()->id; 
        // $order = order::where('user_id', '=', $user_id)->get();
        // $data = Applicant::find($user_id);
        // // $paid = payment::where('application_id', '=', $order->id)->get();
        
        // $pays = product_payments::where('product_id', '=', $data->id)->get();

        $pays = DB::table('product_payments')
        ->join('applicants', 'product_payments.product_id', '=', 'applicants.id')
        ->where('applicants.user_id', '=', $id)
        ->get();

        $paid = DB::table('payments')
                    ->join('applicants', 'payments.id', '=', 'applicants.id')
                    ->where('applicants.user_id', '=', $id)
                    ->get();

        return view('user.myapplication', compact('paid', 'pays'));
    }

    
    public function affiliate()
    {
        return view('user.referal-details');
    }
}
