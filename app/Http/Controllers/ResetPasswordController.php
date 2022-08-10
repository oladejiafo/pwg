<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Fortify\Rules\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon; 
use DB;

class ResetPasswordController extends Controller
{

    public function forgotPassword(Request $request)
    {
        // dd($request);
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);
    
        $email = $request->email;
        $emailExist =  User::where('email', $email)->first();
        if($emailExist == null){
            return back()->withErrors(['msg' => 'The email not exist.']);
        } else {
            $token = rand(100000,999999);

            DB::table('password_resets')->insert(
                ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
            );


            // User::where('email', $email)->update([
            //     'otp' => $otp
            // ]);

            Mail::to($email)->send(new ResetPassword($token));
      
            return view('auth.reset-password', compact('email'));
        
        }
        
    }

    public function updatePassword(Request $request)
    {
        $reset = DB::table('password_resets')
                    ->where('email', $request->email)
                    ->where('token', $request->otp)
                    ->first();
        $expiry  = Carbon::now()->subMinutes( 60 );
        if($reset){
            if ($reset->created_at <= $expiry) {
                return redirect()->route('login');
            }
            $request->validate([
                'email' => 'required|email|exists:users',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required',
          
            ]);
            User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

            DB::table('password_resets')->where(['email'=> $request->email])->delete();

            return view('auth.reset-password-success');
        } else {
            return back()->withErrors(['otp' => 'Please recheck OTP.']);
        }
        
    }

    protected function passwordRules()
    {
        return ['required', 'string', new Password, 'confirmed'];
    }

}
