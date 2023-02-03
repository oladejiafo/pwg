<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        list($agent_name, $agent_phone) = explode(' - ', $input['agent']);

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:clients'],
            'phone_number' => ['required', 'numeric', 'min:10', 'unique:clients'],
            'signature' => ['string', 'max:255'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'name' => preg_replace("/[^A-Za-z- ]/", '', strip_tags($input['name'])),
            'email' => $input['email'],
            'phone_number' => preg_replace("/[^0-9+]/", '', strip_tags($input['phone_number'])),
            'password' => Hash::make($input['password']),
            'sales_agent_name_by_client' => $agent_name,
            'sales_agent_phone_number_by_client' => $agent_phone,
        ]);
    }
}
