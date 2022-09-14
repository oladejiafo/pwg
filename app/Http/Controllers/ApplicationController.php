<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Applicant;
use App\Models\ApplicantExperience;
use App\Models\FamilyDetail;
use App\Constant;
use App\Models\ChildrenDetail;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use App\Mail\NotifyMail;
use Doctrine\Common\Annotations\Annotation\Required;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use DB;

class ApplicationController extends Controller
{

    public function applicant($productId)
    {
        if (Auth::id()) {
            $completed = DB::table('applications')
                ->where('destination_id', '=', $productId)
                ->where('client_id', '=', Auth::user()->id)
                ->first();
            $levels = $completed->application_stage_status;
            return view('user.applicant', compact('productId', 'levels'));
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
                'cv' => 'required|mimes:pdf',
            ]);

            $client = User::find(Auth::id());
            $client->addMedia($request->file('cv'))->toMediaCollection(User::$media_collection_main_resume);

            $applicant = Applicant::where('client_id', Auth::id())
                            ->where('destination_id', $request->product_id)
                            ->first();
            $applicant->application_stage_status = 3;
            $applicant->assigned_agent_id = $request->agent_code;
            $applicant->save();
            return Redirect::route('applicant.details', $request->product_id);
        }
    }

    public function applicantDetails($productId)
    {
        if (Auth::id()) {
            $user = User::find(Auth::id());
            $applicant = Applicant::where('client_id', Auth::id())
                                    ->where('destination_id', $productId)
                                    ->first();
            // $dependent = FamilyDetail::where('product_id', $productId)
            //                         ->where('applicant_id', $applicant->id)
            //                         ->pluck('id')
            //                         ->first();
            $dependent = null;
            return view('user.application-next', compact('user', 'productId', 'applicant', 'dependent'))->with('info', 'Data saved successfully!');
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
                'name' => $request['first_name'],
                'middle_name' => $request['middle_name'],
                'sur_name' => $request['surname'],
                'date_of_birth' => date('Y-m-d', strtotime($request['dob'])),
                'place_of_birth' => $request['place_birth'],
                'country_of_birth' => $request['country_birth'],
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
                'passport_issue_date' =>  date('Y-m-d', strtotime($request['passport_issue'])),
                'passport_expiry' => date('Y-m-d', strtotime($request['passport_expiry'])),
                'passport_issued_by' => $request['issued_by'],
                'passport' => $fileName,
                'residence_mobile_number' => $request['home_phone_number'],
                'country_of_residence' => $request['home_country'],
                'state' => $request['state'],
                'city' => $request['city'],
                'postal_code' => $request['postal_code'],
                'address_line_1' => $request['address_1'],
                'address_line_2' => $request['address_2']
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
        // $test = $this->_updateApplicationStatus($productId, $applicant->id, 'applicant');
        $dependent = FamilyDetail::where('product_id', $productId)
                        ->where('applicant_id', $applicant->id)
                        ->first();

        $children = ChildrenDetail::where('applicant_id', $applicant->id)
                                ->get();
        return view('user.application-review', compact('user', 'applicant', 'productId', 'dependent', 'children'))->with('success', 'Data saved successfully!');
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
                'country' => $request->current_country,
                'phone_number' => $request->current_residance_mobile,
                'residence_id' => $request->residence_id,
                'visa_validity' => date('Y-m-d', strtotime($request->visa_validity)),
                'residence_copy' => $residenceCopy,
                'visa_copy' => $visaCopy,
                'work_state' => $request->work_state,
                'work_city' => $request->work_city,
                'work_postal_code' => $request->work_postal_code,
                'work_address' => $request->work_street,
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
                'is_schengen_visa_issued_last_five_year'  => $request->is_schengen_visa_issued_last_five_year,
                'schengen_visa' => $schengenCopy,
                'is_finger_print_collected_for_Schengen_visa' => $request->is_finger_print_collected_for_Schengen_visa
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
        if($request['userType'] == 'dependent'){
            $exist = ApplicantExperience::where('applicant_id', $request['applicant_id'])
                    ->where('dependant_id', $request['dependentId'])
                    ->where('job_category_three_id', $request['job_category_three_id'])
                    ->where('job_category_four_id', $request['job_category_four_id'])
                    ->first();
            if(!$exist) {
                $exp = new ApplicantExperience();
                $exp->applicant_id = $request['applicant_id'];
                $exp->dependant_id =  $request['dependentId'];
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
        } else {
            $exist = ApplicantExperience::where('applicant_id', $request['applicant_id'])
                    ->where('job_category_three_id', $request['job_category_three_id'])
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
    }

     /**
     * get applicant added experience
     * @param Request
     *
     * @return response
     */
    public function getApplicantExperience(Request $request)
    {
        $exp = ApplicantExperience::where('applicant_id', $request->applicantId)
                                    ->Where('dependant_id', null)
                                    ->get();
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
        $applicant =  Applicant::where('user_id', Auth::id())
                    ->where('product_id', $request->product_id)
                    ->first();

        Applicant::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->update([
                    'applicant_status'=> 5
                ]);

        // $this->_updateApplicationStatus($request->product_id,$applicant['id'], $request['user']);

        // Send Notifications on This Payment ##############
        $email = Auth::user()->email;
        $userID = Auth::user()->id;
        
        $criteria = "Application Completed!";
        $message = "You have completed and submitted your application successfully. Kindly login to the PWG Client portal and check your receipt on 'My Application' for further updates";

        $link = "";

        $dataArray = [
            'title' => $criteria .'Mail from PWG Group',
            'body' => $message,
            'link' => $link
        ];
    
        $check_noti = DB::table('notifications')
                        ->where('criteria', '=', $criteria)
                        ->where('client_id', '=', Auth::user()->id)
                        ->first();

        if ($check_noti === null) 
        {
            DB::table('notifications')->insert(
                    ['client_id' => $userID, 'message' => $message, 'criteria' => $criteria, 'link' => $link]
            );

            Mail::to($email)->send(new NotifyMail($dataArray));
            // Notification Ends ############ 
        }   
        return Response::json(array('success' => true), 200);
    }   

    public function submitApplicantDetails(Request $request)
    {
        $response['status'] = false;
        try{
            Applicant::where('id', $request['applicantId'])
                ->update(['applicant_status' => 4]);

            $this->_updateApplicationStatus($request->product_id, $request['applicantId'], $request['user']);
            $response['status'] = true;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }
        return $response;
    }

    public function storeDependentDetails(Request $request)
    {
        // dd($request);
        $validator = \Validator::make($request->all(), [
            'dependent_first_name' => 'required',
            'dependent_surname' => 'required',
            'dependent_email' => 'required',
            'dependent_phone_number' => 'required',
            'dependent_resume' => 'required',
            'dependent_dob' => 'required',
            'dependent_place_birth' =>  'required',
            'dependent_country_birth' => 'required',
            'dependent_sex' => 'required',
            'dependent_civil_status' => 'required',
            'dependent_citizenship' => 'required'
        ]);
        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200); // 400 being the HTTP code for an invalid request.
        }
        $resumes = null;
        if ($request->hasFile('dependent_resume')) {
            $file = $request->file('dependent_resume');
            $resumes = time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            $destinationPath = 'public/resumes';
            $file->storeAs($destinationPath, $resumes);
        }

        FamilyDetail::updateOrCreate([
                'applicant_id' => $request->applicant_id,
                'product_id' => $request->product_id,
            ],[     
                'first_name' => $request['dependent_first_name'],
                'middle_name' => $request['dependent_middle_name'],
                'surname' => $request['dependent_surname'],
                'email'  => $request['dependent_email'],
                'personal_phone_number' => $request['dependent_phone_number'],
                'dob' => date('Y-m-d', strtotime($request['dependent_dob'])),
                'place_birth' => $request['dependent_place_birth'],
                'country_birth' => $request['dependent_country_birth'],
                'citizenship' => $request['dependent_citizenship'],
                'sex' => $request['dependent_sex'],
                'civil_status' => $request['dependent_civil_status'],
                'resume' => $resumes
            ]);

       
        return Response::json(array(
            'dependentId' => $this->getFamilyId($request->applicant_id,  $request->product_id),
            'success' => true
        ), 200);
    }

    public function storeDependentHomeContryDetails(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'dependent_passport_number' => 'Required',
            'dependent_passport_issue' => 'required',
            'dependent_passport_expiry' => 'required',
            'dependent_issued_by' => 'Required',
            'dependent_home_country' => 'required',
            'dependent_state' => 'required',
            'dependent_city' => 'required',
            'dependent_postal_code' => 'required',
            'dependent_address_1' => 'required',
            'dependent_passport_copy' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200); // 400 being the HTTP code for an invalid request.
        }

        $file = $request->file('dependent_passport_copy');
        if($request->hasFile('dependent_passport_copy')){
            $fileName = time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            $destinationPath = 'public/passportCopy';
            $file->storeAs($destinationPath, $fileName);
        } else {
            $fileName = $request['dependent_passport_copy'];
        }

        FamilyDetail::where('applicant_id', $request->applicant_id)
            ->where('product_id', $request->product_id)
            ->update([
                'passport_number'  => $request['dependent_passport_number'],
                'passport_date_issue' =>  date('Y-m-d', strtotime($request['dependent_passport_issue'])),
                'passport_date_expiry' => date('Y-m-d', strtotime($request['dependent_passport_expiry'])),
                'issued_by' => $request['dependent_issued_by'],
                'passport' => $fileName,
                'phone_number' => $request['dependent_home_phone_number'],
                'home_country' => $request['dependent_home_country'],
                'state' => $request['dependent_state'],
                'city' => $request['dependent_city'],
                'postal_code' => $request['dependent_postal_code'],
                'address_1' => $request['dependent_address_1']
            ]);
        return Response::json(array(
            'dependentId' => $this->getFamilyId($request->applicant_id,  $request->product_id),
            'success' => true,
            'passport' => storage_path('passportCopy/'.$fileName)
        ),
        200);
    }

    public function storeSpouseCurrentDetails(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'dependent_current_country' => 'required',
            'dependent_residence_id' => 'required',
            'dependent_visa_validity'  => 'required',
            'dependent_residence_copy' => 'required',
            'dependent_current_job' => 'required',
            'dependent_work_state' => 'required',
            'dependent_work_city' => 'required',
            'dependent_work_postal_code' => 'required',
            'dependent_work_street' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200); // 400 being the HTTP code for an invalid request.
        }
        if ($request->hasFile('dependent_residence_copy')) {
            $file = $request->file('dependent_residence_copy');
            $residenceCopy = time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            $destinationPath = 'public/residenceCopy';
            $file->storeAs($destinationPath, $residenceCopy);
        } else {
            $residenceCopy = $request->file('dependent_residence_copy');
        }
        $visaCopy = $request['dependent_visa_copy'];
        if ($request->hasFile('dependent_visa_copy')) {
            $file = $request->file('dependent_visa_copy');
            $visaCopy = time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            $destinationPath = 'public/visaCopy';
            $file->storeAs($destinationPath, $visaCopy);
        }

        FamilyDetail::where('applicant_id', $request['applicant_id'])
            ->where('product_id', $request->product_id)
            ->update([
                'current_residance_country' => $request->dependent_current_country,
                'current_residance_mobile' => $request->dependent_current_residance_mobile,
                'residence_id' => $request->dependent_residence_id,
                'id_validity' => date('Y-m-d', strtotime($request->dependent_visa_validity)),
                'residence_copy' => $residenceCopy,
                'visa_copy' => $visaCopy,
                'current_job' => $request->dependent_current_job,
                'work_state' => $request->dependent_work_state,
                'work_city' => $request->dependent_work_city,
                'work_postal_code' => $request->dependent_work_postal_code,
                'work_street_number' => $request->dependent_work_street,
                'company_name' => $request->dependent_company_name,
                'employer_phone_number' => $request->dependent_employer_phone,
                'employer_email' => $request->dependent_employer_email
            ]);
        return Response::json(array(
            'dependentId' => $this->getFamilyId($request->applicant_id,  $request->product_id),
            'success' => true
        ), 200);
    }

    public function storeSpouseSchenegenDetails(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'is_dependent_schengen_visa_issued_last_five_year' => 'required',
            'is_dependent_finger_print_collected_for_Schengen_visa' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200); // 400 being the HTTP code for an invalid request.
        }
        $schengenCopy = null;
        if ($request->hasFile('dependent_schengen_copy')) {
            $file = $request->file('dependent_schengen_copy');
            $schengenCopy = time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            $destinationPath = 'public/schengenCopy';
            $file->storeAs($destinationPath, $schengenCopy);
        }
        FamilyDetail::where('applicant_id', $request->applicant_id)
            ->where('product_id', $request->product_id)
            ->update([
                'is_schengen_visa_issued'  => $request->is_dependent_schengen_visa_issued_last_five_year,
                'schengen_visa' => $schengenCopy,
                'is_fingerprint_collected' => $request->is_dependent_finger_print_collected_for_Schengen_visa
            ]);

        return Response::json(array(
            'dependentId' => $this->getFamilyId($request->applicant_id,  $request->product_id),
            'success' => true
        ), 200);
    }

    public function getDependentExperience(Request $request)
    {
        // dd($request);
        $exp = ApplicantExperience::where('applicant_id', $request->applicantId)
                            ->where(function ($query) use ($request) {
                                return $query->Where('dependant_id', $request->dependentId)
                                    ->where('dependant_id', '>', 0 );
                            })
                            ->get();
        return $exp;
    }

    public function storeChildrenDetails(Request $request)
    {
        
        for($i = 1; $i <= $request['childrenCount']; $i++ ){
            $validator = \Validator::make($request->all(), [
                "child_".$i."_first_name" => 'required',
                "child_".$i."_surname" => 'required',
                "child_".$i."_dob" => 'required',
                "child_".$i."_gender" => 'required',
            ]);
            if ($validator->fails()) {
                return Response::json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()
    
                ), 200); // 400 being the HTTP code for an invalid request.
            }
        }
        
        ChildrenDetail::where('applicant_id', $request['applicant_id'])->delete();
        for($i = 1; $i <= $request['childrenCount']; $i++ ){
            ChildrenDetail::create([
                'product_id' => $request['product_id'],
                'applicant_id' => $request['applicant_id'],
                'first_name' => $request['child_'.$i.'_first_name'],
                'middle_name' => $request['child_'.$i.'_middle_name'],
                'surname' => $request['child_'.$i.'_surname'],
                'dob' => date('Y-m-d', strtotime($request['child_'.$i.'_dob'])),
                'gender' => $request['child_'.$i.'_gender'],
                'status' => 1
            ]);
        }

        Applicant::where('id', $request['applicant_id'])
                ->update(['applicant_status' =>  4]);

        return Response::json(array(
            'success' => true
        ), 200);
    }

    private static function getFamilyId($applicant_id, $product_id)
    {
        return FamilyDetail::where('applicant_id', $applicant_id)
                            ->where('product_id', $product_id)
                            ->pluck('id')
                            ->first();
    }

    public function updateApplicantStatus(Request $request)
    {
        $response['status'] = false;
        $response['status'] = $this->_updateApplicationStatus($request['product_id'], $request['id'], $request['userType']);
        return $response;
    }

    private static function _updateApplicationStatus($productId, $applicantId, $user)
    {
        if($user == 'applicant'){
            Applicant::where('id', $applicantId)
            ->update([
                'status' => 1,
            ]);
            return true;
        } else if($user == 'family') {
            FamilyDetail::where('product_id', $productId)
                        ->where('applicant_id', $applicantId)
                        ->update(['status' => 1]);
            return true;
        } else if($user == 'children') {
            ChildrenDetail::where('product_id', $productId)
                ->where('applicant_id', $applicantId)
                ->update(['status' => 1]);
            return true;
        }
    }

    public function checkApplicationStatus(Request $request)
    {
        $response['status'] = false;
        $applicant = Applicant::where('id', $request->id)
                                ->where('status', 1)
                                ->first();
        if($applicant){
            $response['status'] = true;
            if($applicant['visa_type'] == 'FAMILY PACKAGE'){
                if($applicant['is_spouse']){
                    $family = FamilyDetail::where('product_id', $request->product_id)
                                ->where('applicant_id', $request->id)
                                ->where('status', 1)
                                ->first();
                    if($family) {
                    } else {
                        $response['status'] = false;
                        $response['message'] = 'Family details should be completed before proceeding';
                    }
                }
                
                if($applicant['children_count']){
                    $children = ChildrenDetail::where('product_id', $request->product_id)
                                ->where('applicant_id', $request->id)
                                ->where('status', 1)
                                ->first();
                    if($children) {
                    } else {
                        $response['status'] = false;
                        $response['message'] = 'Children details should be completed before proceeding';
                    }
                }
            }
        } else {
            $response['message'] = 'Applicant details should be completed before proceeding';
        }

        return $response;
    }
}
