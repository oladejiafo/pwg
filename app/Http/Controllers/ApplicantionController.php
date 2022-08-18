<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Applicant;
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
        return view('user.applicant', compact('productId'));
    }

    /**
     * Store applicant details at step 3
     * @param Request
     *
     * @return void
     */
    public function storeApplicant(Request $request)
    {
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
            ]);
        return Redirect::route('applicant.details', $request->pid);
    }

    public function applicantDetails()
    {
        $user = User::find(Auth::id());
        $response = Http::post('https://bo.pwggroup.ae/api/get-job-category-list');
        $jobCategory = $response->body();
        $jobCategories = json_decode($jobCategory, true);
        // dd($jobCategories);
        return view('user.application-next', compact('user', 'jobCategories'))->with('success', 'Data saved successfully!');
    }

    public function storeApplicantDetails(Request $request)
    {
        dd($request);
    }
}
