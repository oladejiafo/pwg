<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\product;

class HomeController extends Controller
{
    public function redirect()
    {
        if (Auth::id()) {
            // if (Auth::user()->usertype == 0) {
            //     $doctor = doctor::all();
            //     return view('user.home', compact('doctor'));
            //     //                return view('user.home');
            // } else {
                return view('user.home');
            // }
        } else {
            return redirect()->back();
        }
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
        return view('user.package', compact('data'));
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
        return redirect()->back()->with('message', 'Signature Appended Successfully');
    }
}
