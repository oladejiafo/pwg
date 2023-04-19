<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\NetworkPartner;
use App\Models\NetworkPartnerCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class NetworkController extends Controller
{
    public function index()
    {   
        return view('network.partner');
    }

    public function storeNetworkPartner(Request $request)
    {
        $validated = $request->validate([
            'partner_code' => ['required', 'unique:network_partner'],
            'partner_name' => ['required'],
            'payment_type' => ['required'],
            'partner_location' => ['required'],
            'partner_phone_number' => ['required', 'string', 'min:10', 'unique:network_partner'],
            'partner_email' => ($request->partner_email != NULL) ? ['unique:network_partner'] : '',
        ]);
        $code = NetworkPartnerCode::where('code', '=', $request->partner_code)->exists();
        if ($code) {
            if ($request->payment_type == "Bank Payment" && !$request->filled(['bank_iban_number', 'bank_name', 'bank_swift_code'])) {
                return back()->withInput()->with('error', 'Please add bank details!');
            }
            $exist = NetworkPartner::where('partner_code', $request->partner_code)->exists();
            if ($exist) {
                return back()->withInput()->with('error', 'The code is already used!');
            }

            $data = array_merge($validated, [
                'partner_type' => "network",
                'payment_method' => $request->payment_type,
                'bank_iban_number' => optional($request)->bank_iban_number,
                'bank_name' => optional($request)->bank_name,
                'bank_swift_code' => optional($request)->bank_swift_code,
            ]);

            NetworkPartner::create($data);

            return back()->with('message', 'Partner details added successfully!');
        } else {
            return back()->withInput()->with('error', 'Invalid Code!');
        }
    }
}
