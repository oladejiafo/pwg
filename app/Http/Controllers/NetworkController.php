<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\NetworkPartner;
use App\Models\NetworkPartnerCode;
use Illuminate\Http\Request;
use App\Mail\CongratulationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Swift_TransportException;
use DB;

class NetworkController extends Controller
{
    public function index()
    {   
        return view('network.partner');
    }

    public function storeNetworkPartner(Request $request)
    {
        try{
            $validated = $request->validate([
                'partner_code' => ['required', 'unique:network_partner'],
                'partner_name' => ['required'],
                'payment_type' => ['required'],
                'partner_location' => ['required'],
                'partner_phone_number' => ['required', 'string', 'min:10', 'unique:network_partner'],
                'partner_email' => ['required','unique:network_partner'],
                'partner_city' => ['required'],
                'global_mobility_consultant_code' => ['required']
            ]);
            $agent = DB::table('employees')->select('id')->where('agent_unique_code','=', $request->global_mobility_consultant_code)->first();
            if($agent){
                $code = NetworkPartnerCode::where('code', '=', $request->partner_code)
                                        ->first();
                if ($code) {
                    if($code->agent_code != NULL){
                        return back()->withInput()->with('error', 'Already Used!');
                    }
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
                        'partner_city' => $request->partner_city
                    ]);
                    
                    NetworkPartner::create($data);
    
                    $code->agent_code = $agent->id;
                    $code->save();
    
                    $dataArray = [
                        'title' => 'Congratulations on Your Partnership!',
                        'name' => $request->partner_name,
                    ];
                    Mail::to($request->partner_email)->send(new CongratulationMail($dataArray));
                    return redirect('https://pwggroup.ae/thank-you-for-partner-registration');
                } else {
                    return back()->withInput()->with('error', 'Invalid Code!');
                }
            } else {
                return back()->withInput()->with('error', 'Partner code is not assigned!');
            }
        } catch (Exception $e) {
            // Handle the Swift_TransportException here
            return redirect('https://pwggroup.ae/thank-you-for-partner-registration');
        }

    }

    public function checkGMCC(Request $request) {
        $agent = DB::table('employees')->select('id')->where('agent_unique_code','=', $request->gmc)->first();
        if($agent){
            return true;
        }  else {
            return false;
        }
    }

    public function networkPartnerCode($code)
    {
        $agent = DB::table('employees')->select('id')->where('agent_unique_code','=', $code)->first();
        if($agent){
            return view('network.partner-code', compact('code'));
        } else {
            return \Redirect::route('newtork.partner')->withInput()->with('error', 'Global Mobility Consultant code is not valid!');
        }
    }
}
