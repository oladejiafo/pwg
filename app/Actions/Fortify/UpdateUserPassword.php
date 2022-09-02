<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Illuminate\Support\Facades\Auth;
use App\Mail\ResetPassword;
use Carbon\Carbon; 
use DB;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        if(!isset($input['otp'])){
            Validator::make($input, [
                'current_password' => ['required', 'string'],
                'password' => $this->passwordRules(),
            ])->after(function ($validator) use ($user, $input) {
                if (! isset($input['current_password']) || ! Hash::check($input['current_password'], $user->password)) {
                    $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
                }
            })->validateWithBag('updatePassword');

            $token = rand(100000,999999);

            DB::table('password_resets')->insert(
                ['email' => Auth::user()->email, 'token' => $token, 'created_at' => Carbon::now()]
            );
            Mail::to(Auth::user()->email)->send(new ResetPassword($token));

        } else {
            $tokenData =  DB::table('password_resets')->where('email', Auth::user()->email)->latest('created_at')->first();
            Validator::make($input, [
                'current_password' => ['required', 'string'],
                'password' => $this->passwordRules(),
                'otp' => 'required'
            ])->after(function ($validator) use ($user, $input, $tokenData) {
                if (! isset($input['current_password']) || ! Hash::check($input['current_password'], $user->password)) {
                    $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
                }
                if($tokenData->token != $input['otp']){
                    $validator->errors()->add('otp', __('Please check the otp in your mail'));
                }
            })->validateWithBag('updatePassword');

            $user->forceFill([
                'password' => Hash::make($input['password']),
            ])->save();
        }
    }
}
