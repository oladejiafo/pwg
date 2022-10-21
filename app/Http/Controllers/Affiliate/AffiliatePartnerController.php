<?php

namespace App\Http\Controllers\Affiliate;

use App\Affiliate as AppAffiliate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Affiliate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Validator;
use Session;
use DB;
use Carbon\Carbon;

class AffiliatePartnerController extends Controller
{
    public function index()
    {
        return view('affiliate.dashboard');
    }

    public function affiliateLogin(){
        if(!Session::has('loginId'))
        {
            return view('affiliate.auth.login');
        } else {
            return back();
        }
    }

    public function affiliate_login(Request $request){
        $request->validate(([
            'auth' => 'required|email',
            'password' => 'required|min:8'
        ]));

        $affiliated = Affiliate::where('email', '=', $request->auth)->first();
        // dd($affiliated);
        if($affiliated){
            if(Hash::check($request->password, $affiliated->password)){
                $request->session()->put('loginId',$affiliated->id);
                $request->session()->put('loginName',$affiliated->first_name);
                return redirect('affiliate');
            } else {
                return back()->with('failed', 'wrong password');
            }
        } else {
            return back()->with('failed','wrong email');
        }
    }

    public function forgotPassword(){
        return view('affiliate.auth.forgot-password');
    }

    public function resetPassword(){
        return view('affiliate.auth.reset-password');
    }

    public function PasswordRequest(Request $request){
        $user = DB::table('affiliate')->where('email', '=', $request->email)
            ->first();
           
        //Check if the user exists
        if(!$user) {
            return redirect()->back()->withErrors(['email' => trans('User does not exist')]);
        }  else {
            $token = rand(100000, 999999);
            $email=$request->email;

            DB::table('affiliate')
                ->where('email', $request->email)
                ->update(
                    [
                        'otp' => $token,
                        'updated_at' => Carbon::now()
                    ]
                );
                Session::put('email',$email);
            Mail::to($request->email)->send(new ResetPassword($token));

            // return view('affiliate..auth.reset-password', compact('email'));
            return redirect()->route('affiliate.reset-password')->with('success', trans('A reset link has been sent to your email address.'));
            // ->with('success', trans('A reset link has been sent to your email address.'));
        }
    }

    public function passwordUpdate(Request $request)
    {
        $user = Affiliate::where('email','=', $request->email)->first();

        $validator = \Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => $this->passwordRules(),
        ])->after(function ($validator) use ($user, $request) {
            if (! isset($request['current_password']) || ! Hash::check($request['current_password'], $user->password)) {
                $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
            }
        });
        if ($validator->fails()) {
            return Response::json(array(
                'status' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200); // 400 being the HTTP code for an invalid request.
        }
        return redirect()->route('affiliate.affiliateLogin')->with('success', trans('A reset link has been sent to your email address.'));

    }

    public function affiliateLogout()
    {
        if(Session::has('loginId'))
        {
            Session::pull('loginId');
            return redirect('affiliate');
        }
    }

    public function affiliateRegister() 
    {
        if(!Session::has('loginId'))
        {
            return view('affiliate.auth.register');
        } else {
            return back();
        }
    }

    public function affiliate_register(Request $request){
        $request->validate(([
            'name' => 'required',
            'surname' => 'required',
            'phone_number' => 'required',
            'terms' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8'
        ]));

        $check = Affiliate::where('email', '=', $request->email)->first();
        
        if($check === null)
        {
            $affiliate = new Affiliate();
            $affiliate->first_name =$request->name;
            $affiliate->surname =$request->surname;
            $affiliate->email =$request->email;
            $affiliate->refferer_code = $request->refferer;
            $affiliate->phone_number =$request->phone_number;
            $affiliate->password = Hash::make($request->password);
            $res = $affiliate->save();
            if($res){
                $affiliated = Affiliate::where('email', '=', $request->email)->first();
                $request->session()->put('loginId',$affiliated->id);
                $request->session()->put('loginName',$affiliated->first_name);
                return redirect('affiliate');
            } else {
                return back();
            }
        } else {
            return back()->with('failed','This record exists already');
        }
    }

}
