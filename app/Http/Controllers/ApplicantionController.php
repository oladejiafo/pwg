<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Applicant;
use Doctrine\Common\Annotations\Annotation\Required;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ApplicantionController extends Controller
{

    public function index($productId)
    {
        if(Auth::id()) {
            return view('user.applicant', compact('productId'));
        } else {
            return back();
        }
    }

    /**
     * Store applicant details at step 3
     * @param Request
     *
     * @return void
     */
    public function storeApplicant(Request $request)
    {
        if(Auth::id()){
            $request->validate([
                'applied_country' => 'required',
                'job_type' => 'required',
                'cv' => 'required|mimes:pdf',
                'agent_phone' => 'required',
                'agent_name' => 'required',
                'embassy_country' => 'required',
                'agree' => 'required'
            ]);
            $file = $request->file('cv');
            $fileName = time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());

            $destinationPath = 'public/resumes';
            $file->storeAs($destinationPath, $fileName);

            Applicant::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->update([
                    'country' => $request->applied_country,
                    'job_type' => $request->job_type,
                    'resume' => $fileName,
                    'agent_phone_number' => $request->agent_phone,
                    'agent_name' => $request->agent_name,
                    'embassy_country' => $request->embassy_country,
                    'applicant_status' => 3
                ]);
            return Redirect::route('applicant.details', $request->pid);
        }
    }

    public function applicantDetails()
    {
        if(Auth::id()) {
            $user = User::find(Auth::id());
            // $response = Http::post('https://bo.pwggroup.ae/api/get-job-category-list');
            // $jobCategory = $response->body();
            // $jobCategories = json_decode($jobCategory, true);
            // dd($jobCategories);
            $jobCategories = [] ;
            return view('user.application-next', compact('user', 'jobCategories'))->with('success', 'Data saved successfully!');
        } else {
            return back();
        }
    }

    public function storeApplicantDetails(Request $request)
    {
        $response['status'] = false;
        try {
            $request->validate([
                'first_name' => 'required',
                'surname' => 'required',
                'dob' => 'required',
                'place_birth' => 'required',
                'country_birth' => 'required',
                'sex' => 'required',
                'civil_status' => 'required'
            ]);
    
            Applicant::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->update([
                    'first_name' => $request['first_name'],
                    'middle_name' => $request['middle_name'],
                    'surname' => $request['surname'],
                    'dob' => $request['dob'],
                    'place_birth' => $request['place_birth'],
                    'country_birth' => $request['country_birth'],
                    'citizenship' => $request['citizenship'],
                    'sex' => $request['sex'],
                    'civil_status' => $request['civil_status']
                ]);
                $response['status'] = true;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }   
        return $response;
    }

    public function storeHomeCountryDetails(Request $request)
    {
        $response['status'] = false;
        try {
            $request->validate([
                'passport_number' => 'Required',
                'passport_issue'=> 'required',
                'passport_expiry' => 'required',
                'issued_by' => 'Required',
                'passport_copy'=> 'required',
                
            ]);
            Applicant::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->update([

            ]);
            $response['status'] = true;
            return back()->with('success', 'Data saved successfully!');
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }
        return $response;        
    }

    public function applicantReview()
    {
        $user = User::find(Auth::id());
        // $response = Http::post('https://bo.pwggroup.ae/api/get-job-category-list');
        // $jobCategory = $response->body();
        // $jobCategories = json_decode($jobCategory, true);
        $jobCategories = [] ;
        return view('user.application-review', compact('user', 'jobCategories'))->with('success', 'Data saved successfully!');
    }
}
