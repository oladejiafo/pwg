<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Fortify\Rules\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
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
        if ($emailExist == null) {
            return back()->withErrors(['msg' => 'The email not exist.']);
        } else {
            $token = rand(100000, 999999);

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
        $expiry  = Carbon::now()->subMinutes(15);
        if ($reset) {
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

    public function updateCurrentPassword(Request $request)
    {
        $user = User::find(Auth::id());
        if(!isset($request['otp'])){
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

            $token = rand(100000,999999);
            DB::table('clients')
                ->where('email', Auth::user()->email)
                ->update(
                    [
                        'otp' => $token,
                        'updated_at' => Carbon::now()
                    ]
                );
            Mail::to(Auth::user()->email)->send(new ResetPassword($token));
            return Response::json(array(
                'status' => true,
                'otp' => true

            ), 200);

        } else {
            $reset = DB::table('clients')
                ->where('email', $request->email)
                ->where('otp', $request->otp)
                ->first();
            $expiry  = Carbon::now()->subMinutes(15);
            if ($reset) {
                if($reset->updated_at <= $expiry){
                    return Response::json(array(
                        'status' => false,
                        'message' => 'Time expired for OTP'
        
                    ), 200);
                } else {
                    $validator = Validator::make($request->all(), [
                        'current_password' => ['required', 'string'],
                        'password' => $this->passwordRules(),
                        'otp' => 'required'
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
                    $user->forceFill([
                        'password' => Hash::make($request['password']),
                    ])->save();
                    return Response::json(array(
                        'status' => true,
                        'message' => 'Saved'
        
                    ), 200);
                }
            } else {
                return Response::json(array(
                    'status' => false,
                    'message' => 'Please Check Your OTP'
                ), 200);
            }
        }
    }
}
