<?php

namespace App\Actions\Fortify;

use App\Client;
use App\Models\NetworkPartnerCode;
use App\Models\Partner;
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
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:clients'],
            'phone_number' => ['required', 'string', 'min:10', 'unique:clients'],
            'signature' => ['string', 'max:255'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'agent' =>  'required_without_all:partner',
            'partner' => 'required_without_all:agent',
        ])->validate();

        // if(isset($input['agent']))
        // {
        //     list($agent_name, $agent_phone) = explode(' - ', $input['agent']);
        // } else {
        //     $agent_name=''; 
        //     $agent_phone='';
        // }
        $code = null;
        if($input['partner']){
            $code = NetworkPartnerCode::where('code', '=', $input['partner'])->first();
            if(!$code){
                $code = Partner::where('partner_code', '=', $input['partner'])->first();
                if (!$code) {
                    // Add a custom error message for the partner field
                    $validator = Validator::make([], []); // create a new validator instance
                    $validator->errors()->add('partner', 'The partner code is not valid.');
                    throw new \Illuminate\Validation\ValidationException($validator);
                }
            }    
        }
        $agent_name = $input['agent'];
        return Client::create([
            'name' => preg_replace("/[^A-Za-z- ]/", '', strip_tags($input['name'])),
            'email' => $input['email'],
            'phone_number' => preg_replace("/[^0-9+]/", '', strip_tags($input['phone_number'])),
            'password' => Hash::make($input['password']),
            'sales_agent_name_by_client' => $agent_name,
            'partner_code_provide_by_client' => $input['partner']
        ]);
    }
}
