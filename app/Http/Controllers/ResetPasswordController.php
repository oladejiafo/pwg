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
use Exception;
use Session;

class ResetPasswordController extends Controller
{

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email:rfc,dns|exists:clients',
        ]);
        $email = $request->email;
        $emailExist =  User::where('email', $email)->first();
        if ($emailExist == null) {
            return view('forgot-password')->with('error', 'The email not exist.');
        } else {
            $token = rand(100000, 999999);

            DB::table('clients')
                ->where('email', $email)
                ->update(
                    [
                        'otp' => $token,
                        'otp_expire_at' => Carbon::now()->addMinutes(15)
                    ]
                );
            Mail::to($email)->send(new ResetPassword($token));
            // Session::put('message', 'Please check your mail for OTP!');
            return view('auth.reset-password', compact('email'));
        }
    }

    protected function passwordRules()
    {
        return [
            'required',
            'string',
            'confirmed',
            (new Password)
                ->length(8)->requireSpecialCharacter()->requireNumeric()->requireUppercase(),
        ];
    }

    public function updatePassword(Request $request)
    {
        $email = $request->email;
        Session::forget('message');
        Session::forget('error');
        try {
            $reset = DB::table('clients')
                ->where('email', $request->email)
                ->where('otp', $request->otp)
                ->first();
            $expiry  = Carbon::now();
            if ($reset) {
                if ($expiry > $reset->otp_expire_at) {
                    Session::put('error', 'Oppss! Otp Expired');
                    return view('auth.forgot-password');
                }
                $request->validate([
                    'email' => 'required|email:rfc,dns|exists:clients',
                    'password' => $this->passwordRules(),
                    // 'confirm_password' => 'required|same:password'
                ]);

                User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);


                return view('auth.reset-password-success');
            } else {
                Session::put('error', 'Please check your OTP!');
                return view('auth.reset-password', compact('email'));
            }
        } catch (Exception $e) {
            
                Session::put('error', $e->getMessage());
                return view('auth.reset-password', compact('email'));
            
        }
    }


    public function updateCurrentPassword(Request $request)
    {
        $user = User::find(Auth::id());
        if (!isset($request['otp'])) {
            $validator = \Validator::make($request->all(), [
                'current_password' => ['required', 'string'],
                'password' => $this->passwordRules(),
            ])->after(function ($validator) use ($user, $request) {
                if (!isset($request['current_password']) || !Hash::check($request['current_password'], $user->password)) {
                    $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
                }
            });
            if ($validator->fails()) {
                return Response::json(array(
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 200); // 400 being the HTTP code for an invalid request.
            }

            $token = rand(100000, 999999);
            DB::table('clients')
                ->where('email', Auth::user()->email)
                ->update(
                    [
                        'otp' => $token,
                        'otp_expire_at' => Carbon::now()->addMinutes(15)
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
            $expiry  = Carbon::now();
            if ($reset) {
                if ($expiry > $reset->otp_expire_at) {
                    return Response::json(array(
                        'status' => false,
                        'message' => 'Otp Expired'

                    ), 200);
                } else {
                    $validator = Validator::make($request->all(), [
                        'current_password' => ['required', 'string'],
                        'password' => $this->passwordRules(),
                        'otp' => 'required'
                    ])->after(function ($validator) use ($user, $request) {
                        if (!isset($request['current_password']) || !Hash::check($request['current_password'], $user->password)) {
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
