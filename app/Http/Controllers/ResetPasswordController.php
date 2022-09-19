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
        $request->validate([
            'email' => 'required|email|exists:clients',
        ]);
    
        $email = $request->email;
        $emailExist =  User::where('email', $email)->first();
        if($emailExist == null){
            return back()->withErrors(['msg' => 'The email not exist.']);
        } else {
            $token = rand(100000,999999);

            DB::table('clients')
            ->where('email', $email)
            ->update(
                [
                    'otp' => $token, 
                    'updated_at' => Carbon::now()
                ]
            );

            Mail::to($email)->send(new ResetPassword($token));
      
            return view('auth.reset-password', compact('email'));
        
        }
        
    }

    public function updatePassword(Request $request)
    {
        $reset = DB::table('clients')
                    ->where('email', $request->email)
                    ->where('otp', $request->otp)
                    ->first();
        $expiry  = Carbon::now()->subMinutes( 15 );
        if($reset){
            if ($reset->updated_at <= $expiry) {
                return redirect()->route('login');
            }
            $request->validate([
                'email' => 'required|email|exists:clients',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required',
          
            ]);
            User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);


            return view('auth.reset-password-success');
        } else {
            return redirect()->route('password.request')->with('falied', 'Please Check Your OTP!');
        }
        
    }

    protected function passwordRules()
    {
        return ['required', 'string', new Password, 'confirmed'];
    }

}
