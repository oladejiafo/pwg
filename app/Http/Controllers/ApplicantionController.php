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
use Illuminate\Support\Facades\Response;


class ApplicantionController extends Controller
{

    public function applicanview($productId)
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
        $validator = \Validator::make($request->all(), [
            'first_name' => 'required',
            'surname' => 'required',
            'dob' => 'required',
            'place_birth' => 'required',
            'country_birth' => 'required',
            'sex' => 'required',
            'civil_status' => 'required',
            'citizenship'=> 'required'
        ]);

        if ($validator->fails())
        {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
        
            ), 200); // 400 being the HTTP code for an invalid request.
        }

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
        return Response::json(array('success' => true), 200);
    }

    public function storeHomeCountryDetails(Request $request)
    {
        $validator = \Validator::make($request->all(), [
                'passport_number' => 'Required',
                'passport_issue'=> 'required',
                'passport_expiry' => 'required',
                'issued_by' => 'Required',
                'passport_copy'=> 'required',
                'home_country' => 'required',
                'state' => 'required',
                'city' => 'required',
                'postal_code' => 'required',
                'address1' => 'required',
                'address2' => 'required'
            ]);
        
            if ($validator->fails())
            {
                return Response::json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()
            
                ), 200); // 400 being the HTTP code for an invalid request.
            }
            // if($request->hasFile('passport_copy')){
            //     $file = $request->file('passport_copy');
            //     dd($file);
            //  }
            //  die;
            // $fileName = time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());

            // $destinationPath = 'public/passportCopy';
            // $file->storeAs($destinationPath, $fileName);
            Applicant::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->update([
                    'passport_number'  => $request['passport_number'],
                    'passport_date_issue' => $request['passport_issue'],
                    'passport_date_expiry' => $request['passport_expiry'],
                    'issued_by' => $request['issued_by'],
                    'passport' => '',
                    'phone_number' => $request['home_phone_number'],
                    'home_country' => $request['home_country'],
                    'state' => $request['state'],
                    'city' => $request['city'],
                    'postal_code' => $request['postal_code'],
                    'address_1' => $request['address_1'],
                    'address_2' => $request['address_2']
                ]);
            $response['status'] = true;
            return Response::json(array('success' => true), 200);
        }

    public function applicantReview()
    {
        $user = User::find(Auth::id());
        // $response = Http::post('https://bo.pwggroup.ae/api/get-job-category-list');
        // $jobCategory = $response->body();
        // $jobCategories = json_decode($jobCategory, true);
        // $jobCategories = [] ;
        return view('user.application-review', compact('user', 'jobCategories'))->with('success', 'Data saved successfully!');
    }
}
