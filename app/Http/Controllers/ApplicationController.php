<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Applicant;
use App\Models\ApplicantExperience;
use App\Constant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Doctrine\Common\Annotations\Annotation\Required;

class ApplicationController extends Controller
{

    public function applicant($productId)
    {
        if (Auth::id()) {
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
        if (Auth::id()) {
            $request->validate([
                'applied_country' => 'required',
                // 'job_type' => 'required',
                'cv' => 'required|mimes:pdf',
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
                    // 'job_type' => $request->job_type,
                    'resume' => $fileName,
                    'agent_code' => $request->agent_code,
                    'embassy_country' => $request->embassy_country,
                    'applicant_status' => 3
                ]);
            return Redirect::route('applicant.details', $request->pid);
        }
    }

    public function applicantDetails($productId = 1)
    {
        if (Auth::id()) {
            $user = User::find(Auth::id());
            $productId = 1;
            $applicantId = Applicant::where('user_id', Auth::id())
                                    ->where('product_id', $productId)
                                    ->pluck('id')
                                    ->first();
            return view('user.application-next', compact('user', 'productId', 'applicantId'))->with('success', 'Data saved successfully!');
        } else {
            return back();
        }
    }

    /**
     * Store applicant details at step 4
     * @param Request
     *
     * @return void
     */
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
            'citizenship' => 'required'
        ]);

        if ($validator->fails()) {
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
                'dob' => date('Y-m-d', strtotime($request['dob'])),
                'place_birth' => $request['place_birth'],
                'country_birth' => $request['country_birth'],
                'citizenship' => $request['citizenship'],
                'sex' => $request['sex'],
                'civil_status' => $request['civil_status']
            ]);
        return Response::json(array('success' => true), 200);
    }

    /**
     * Store applicant home country details as step 4
     * @param Request
     *
     * @return void
     */
    public function storeHomeCountryDetails(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'passport_number' => 'Required',
            'passport_issue' => 'required',
            'passport_expiry' => 'required',
            'issued_by' => 'Required',
            'home_country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'address_1' => 'required',
            'address_2' => 'required',
            'passport_copy' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200); // 400 being the HTTP code for an invalid request.
        }
        $file = $request->file('passport_copy');
        if($request->hasFile('passport_copy')){
            $fileName = time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            $destinationPath = 'public/passportCopy';
            $file->storeAs($destinationPath, $fileName);
        } else {
            $fileName = $request['passport_copy'];
        }
        Applicant::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->update([
                'passport_number'  => $request['passport_number'],
                'passport_date_issue' =>  date('Y-m-d', strtotime($request['passport_issue'])),
                'passport_date_expiry' => date('Y-m-d', strtotime($request['passport_expiry'])),
                'issued_by' => $request['issued_by'],
                'passport' => $fileName,
                'phone_number' => $request['home_phone_number'],
                'home_country' => $request['home_country'],
                'state' => $request['state'],
                'city' => $request['city'],
                'postal_code' => $request['postal_code'],
                'address_1' => $request['address_1'],
                'address_2' => $request['address_2']
            ]);
        return Response::json(array(
                    'success' => true,
                    'passport' => storage_path('passportCopy/'.$fileName)
                ),
             200);
    }

    public function applicantReview($productId)
    {
        $user = User::find(Auth::id());
        $applicant = Applicant::where('user_id', Auth::id())
                        ->where('product_id', $productId)
                        ->first();
        return view('user.application-review', compact('user', 'applicant', 'productId'))->with('success', 'Data saved successfully!');
    }

    /**
     * Store applicant current residence and work details as step 4
     * @param Request
     *
     * @return void
     */
    public function storeCurrentDetails(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'current_country' => 'required',
            'residence_id' => 'required',
            'visa_validity'  => 'required',
            'residence_copy' => 'required',
            'current_job' => 'required',
            'work_state' => 'required',
            'work_city' => 'required',
            'work_postal_code' => 'required',
            'work_street' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200); // 400 being the HTTP code for an invalid request.
        }
        if ($request->hasFile('residence_copy')) {
            $file = $request->file('residence_copy');
            $residenceCopy = time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            $destinationPath = 'public/residenceCopy';
            $file->storeAs($destinationPath, $residenceCopy);
        } else {
            $residenceCopy = $request->file('residence_copy');
        }
        $visaCopy = $request['visa_copy'];
        if ($request->hasFile('visa_copy')) {
            $file = $request->file('visa_copy');
            $visaCopy = time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            $destinationPath = 'public/visaCopy';
            $file->storeAs($destinationPath, $visaCopy);
        }
        Applicant::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->update([
                'current_residance_country' => $request->current_country,
                'current_residance_mobile' => $request->current_residance_mobile,
                'residence_id' => $request->residence_id,
                'id_validity' => date('Y-m-d', strtotime($request->visa_validity)),
                'residence_copy' => $residenceCopy,
                'visa_copy' => $visaCopy,
                'current_job' => $request->current_job,
                'work_state' => $request->work_state,
                'work_city' => $request->work_city,
                'work_postal_code' => $request->work_postal_code,
                'work_street_number' => $request->work_street,
                'company_name' => $request->company_name,
                'employer_phone_number' => $request->employer_phone,
                'employer_email' => $request->employer_email
            ]);
        return Response::json(array('success' => true), 200);
    }

    /**
     * Store applicant schengen visa details as step 4
     * @param Request
     *
     * @return response
     */
    public function storeSchengenDetails(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'is_schengen_visa_issued_last_five_year' => 'required',
            'is_finger_print_collected_for_Schengen_visa' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200); // 400 being the HTTP code for an invalid request.
        }
        $schengenCopy = null;
        if ($request->hasFile('schengen_copy')) {
            $file = $request->file('schengen_copy');
            $schengenCopy = time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            $destinationPath = 'public/schengenCopy';
            $file->storeAs($destinationPath, $schengenCopy);
        }
        Applicant::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->update([
                'is_schengen_visa_issued'  => $request->is_schengen_visa_issued_last_five_year,
                'schengen_visa' => $schengenCopy,
                'is_fingerprint_collected' => $request->is_finger_print_collected_for_Schengen_visa
            ]);
        return Response::json(array('success' => true), 200);
    }

     /**
     * Store applicant experience as step 4
     * @param Request
     *
     * @return response
     */
    public function addExperience(Request $request)
    {
        $exist = ApplicantExperience::where('job_category_three_id', $request['job_category_three_id'])
                                    ->where('job_category_four_id', $request['job_category_four_id'])
                                    ->first();
        if(!$exist) {
            $exp = new ApplicantExperience();
            $exp->applicant_id = $request['applicant_id'];
            $exp->job_title = $request['job_title'];
            $exp->job_category_one_id = $request['job_category_one_id'];
            $exp->job_category_two_id = $request['job_category_two_id'];
            $exp->job_category_three_id  = $request['job_category_three_id'];
            $exp->job_category_four_id   = $request['job_category_four_id'];
            $exp->created_by = Auth::id();
            $exp->save();
            return true;
        } else {
            return false;
        }
    }

     /**
     * get applicant added experience
     * @param Request
     *
     * @return response
     */
    public function getApplicantExperience(Request $request)
    {
        $exp = ApplicantExperience::where('applicant_id', $request->applicantId)->get();
        return $exp;
    }

    public function removeExperience(Request $request)
    {
        ApplicantExperience::where('id', $request['expId'])
                        ->where('applicant_id', $request['applicantId'])
                        ->delete();
        return true;
    }

     /**
     * Store applicant details as step 4
     * @param Request
     *
     * @return response
     */
    public function applicantReviewSubmit(Request $request)
    {
        Applicant::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->update([
                'applicant_status'=> 4
            ]);

        return Response::json(array('success' => true), 200);
    }   

    public function submitApplicantDetails(Request $request)
    {
        Applicant::where('id', $request['applicantId'])
                ->update(['applicant_status' => 5]);
        return true;
    }
}
