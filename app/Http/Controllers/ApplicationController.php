<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Applicant;
use App\Models\ApplicantExperience;
use App\Models\JobCategoryOne;
use App\Models\JobCategoryFour;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use App\Mail\NotifyMail;
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
        session()->forget('info');

        // $url = "https://bo.pwggroup.ae/api/get-job-category-list";
        // $client = new \GuzzleHttp\Client();
        // $response = $client->request('Post', $url);
        // $jobs = json_decode($response->getBody());
        // dd($jobs);
        // foreach($jobs as $job)
        // {
        // //     // JobCategoryOne::create(
        // //     //     [
        // //     //         'name' => $job->name,
        // //     //     ]
        // //     // );

        //     foreach($job->job_category_two as $catOne)
        //     {
        //         // JobCategoryTwo::create([
        //         //     'job_category_one_id' => $job->id,
        //         //     'name' => $catOne->name
        //         // ]);
        // //         die;
        //         foreach($catOne->job_category_three as $cattwo)
        //         {
        //             JobCategoryThree::create([
        //                 'name' => $catOne->name,
        //                 'job_category_two_id' => $catOne->id,
        //             ]);

        //             // foreach($cattwo as $cat)
        //             // {
        //             //     JobCategoryFour::create([
        //             //         'job_category_three_id' => $cattwo->id,
        //             //         'name' => $cat->name,
        //             //         'description'  => $cat->description,
        //             //         'example_titles'  => $cat->example_titles,
        //             //         'main_duties'  => $cat->main_duties,
        //             //         'employement_requirements'  => $cat->employement_requirements
        //             //     ]);
        //             // }
        //         }
        //     }
        // }
        // die;

        if (Auth::id()) {
            $client = User::find(Auth::id());

            $applicant = Applicant::where('client_id', Auth::id())
                                    ->where('destination_id', $productId)
                                    ->first();

            $dependent = User::where('family_member_id', Auth::id())
                            ->where('is_dependent', 1)
                            ->first();

            return view('user.application-next', compact('client', 'productId', 'applicant', 'dependent'))->with('info', 'Data saved successfully!');
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

        User::where('id', Auth::id())
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
        $client = User::find(Auth::id());
        if($request->hasFile('passport_copy')){
            $fileName = time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            $client->addMedia($request->file('passport_copy'))->usingFileName($fileName)->toMediaCollection(User::$media_collection_main);
        } 
        $client->passport_number  = $request['passport_number'];
        $client->passport_issue_date =  date('Y-m-d', strtotime($request['passport_issue']));
        $client->passport_expiry = date('Y-m-d', strtotime($request['passport_expiry']));
        $client->passport_issued_by = $request['issued_by'];
        // $client->residence_mobile_number = $request['home_phone_number'];
        $client->country = $request['home_country'];
        $client->state = $request['state'];
        $client->city = $request['city'];
        $client->postal_code = $request['postal_code'];
        $client->address_line_1 = $request['address_1'];
        $client->address_line_2 = $request['address_2'];
        $client->save();

        return Response::json(array(
                    'success' => true,
                    'passport' => storage_path('passportCopy/'.$fileName)
                ),
             200);
    }

    public function applicantReview($productId)
    {
        $client = User::find(Auth::id());
        $applicant = Applicant::where('client_id',Auth::id())
                                ->where('destination_id', $productId)
                                ->first();
        $dependent = User::where('family_member_id', Auth::id())->where('is_dependent', 1)->first();
        $children = User::where('family_member_id', Auth::id())->where('is_dependent', 2)->get();
        // dd($user, $applicant, $dependent, $children);
        return view('user.application-review', compact('client', 'applicant', 'productId', 'dependent', 'children'))->with('success', 'Data saved successfully!');
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
          
            'residence_id' => 'required',
            'visa_validity'  => 'required',
            'residence_copy' => 'required',
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
        $client = User::find(Auth::id());
        if ($request->hasFile('residence_copy')) {
            $file = $request->file('residence_copy');
            $residenceCopy = time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            $client->addMedia($request->file('residence_copy'))->usingFileName($residenceCopy)->toMediaCollection(User::$media_collection_main_residence_id);
        } else {
            $residenceCopy = $request->file('residence_copy');
        }
        $visaCopy = $request['visa_copy'];
        if ($request->hasFile('visa_copy')) {
            $file = $request->file('visa_copy');
            $visaCopy = time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            $client->addMedia($request->file('visa_copy'))->usingFileName($visaCopy)->toMediaCollection(User::$media_collection_main_residence_visa);
        }
        $client->country_of_residence = $request->current_country;
        $client->residence_mobile_number = $request->current_residance_mobile;
        $client->residence_id = $request->residence_id;
        $client->visa_validity = date('Y-m-d', strtotime($request->visa_validity));
        $client->work_state = $request->work_state;
        $client->work_city = $request->work_city;
        $client->work_postal_code = $request->work_postal_code;
        $client->work_address = $request->work_street;
        $client->company_name = $request->company_name;
        $client->employer_phone_number = $request->employer_phone;
        $client->employer_email = $request->employer_email;
        $client->save();
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
        if($request['is_schengen_visa_issued_last_five_year']  == 'YES'){
            $validator = \Validator::make($request->all(), [
                'is_schengen_visa_issued_last_five_year' => 'required',
                'is_finger_print_collected_for_Schengen_visa' => 'required'
            ]);
        } else {
            $validator = \Validator::make($request->all(), [
                'is_schengen_visa_issued_last_five_year' => 'required',
            ]);
        }
        

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200); // 400 being the HTTP code for an invalid request.
        }
        $schengenCopy = null;
        $client = User::find(AUth::id());
        if ($request->hasFile('schengen_copy')) {
            $file = $request->file('schengen_copy');
            $schengenCopy = time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            $client->addMediaFromRequest('schengen_copy')->withCustomProperties(['mime-type' => 'image/jpeg'])->preservingOriginal()->usingFileName($schengenCopy)->toMediaCollection(User::$media_collection_main_schengen_visa);
        }
        
        $client->is_schengen_visa_issued_last_five_year  = $request->is_schengen_visa_issued_last_five_year;
        $client->is_finger_print_collected_for_Schengen_visa = $request->is_finger_print_collected_for_Schengen_visa;
        $client->save();
        
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
        // dd($request);
        if($request['userType'] == 'dependent'){
            $exist = ApplicantExperience::where('client_id', Auth::id())
                    ->where('job_category_three_id', $request['job_category_three_id'])
                    ->where('job_category_four_id', $request['job_category_four_id'])
                    ->first();
            if(!$exist) {
                $exp = new ApplicantExperience();
                $exp->client_id = Auth::id();
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
            $exist = ApplicantExperience::where('client_id', Auth::id())
                    ->where('job_category_three_id', $request['job_category_three_id'])
                    ->where('job_category_four_id', $request['job_category_four_id'])
                    ->first();
            if(!$exist) {
                $exp = new ApplicantExperience();
                $exp->client_id = Auth::id();
                $exp->job_title = $request['job_title'];
                $exp->job_category_one_id = (int)$request['job_category_one_id'];
                $exp->job_category_two_id = (int)$request['job_category_two_id'];
                $exp->job_category_three_id = (int)$request['job_category_three_id'];
                $exp->job_category_four_id = (int)$request['job_category_four_id'];
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
        $exp = ApplicantExperience::where('client_id', $request->applicantId)
                                    // ->Where('dependant_id', null)
                                    ->get();
        return $exp;
    }

    public function removeExperience(Request $request)
    {
        ApplicantExperience::where('id', $request['expId'])
                        ->where('client_id', $request['applicantId'])
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
        $applicant =  Applicant::where('client_id', Auth::id())
                    ->where('destination_id', $request->product_id)
                    ->first();

        Applicant::where('client_id', Auth::id())
                ->where('destination_id', $request->product_id)
                ->update([
                    'application_stage_status'=> 5
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
                ->update(['application_stage_status' => 4]);

            $this->_updateApplicationStatus($request->product_id, $request['applicantId'], $request['user']);
            $response['status'] = true;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }
        return $response;
    }

    public function storeDependentDetails(Request $request)
    {
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

        $data = User::where('family_member_id', Auth::id())
                        ->where('is_dependent', 1)
                        ->first();

        if($data){
            $data->name = $request['dependent_first_name'];
            $data->middle_name = $request['dependent_middle_name'];
            $data->sur_name = $request['dependent_surname'];
            $data->email  = $request['dependent_email'];
            $data->phone_number  = $request['dependent_phone_number'];
            $data->date_of_birth = date('Y-m-d', strtotime($request['dependent_dob']));
            $data->place_of_birth = $request['dependent_place_birth'];
            $data->country_of_birth = $request['dependent_country_birth'];
            $data->citizenship = $request['dependent_citizenship'];
            $data->sex = $request['dependent_sex'];
            $data->civil_status = $request['dependent_civil_status'];
        } else {
            $data = new User();
            $data->family_member_id = Auth::id();
            $data->is_dependent = 1;
            $data->name = $request['dependent_first_name'];
            $data->middle_name = $request['dependent_middle_name'];
            $data->sur_name = $request['dependent_surname'];
            $data->email  = $request['dependent_email'];
            $data->phone_number  = $request['dependent_phone_number'];
            $data->date_of_birth = date('Y-m-d', strtotime($request['dependent_dob']));
            $data->place_of_birth = $request['dependent_place_birth'];
            $data->country_of_birth = $request['dependent_country_birth'];
            $data->citizenship = $request['dependent_citizenship'];
            $data->sex = $request['dependent_sex'];
            $data->civil_status = $request['dependent_civil_status'];
        }
       
        if ($request->hasFile('dependent_resume')) {
            $data->addMedia( $request->file('dependent_resume'))->toMediaCollection(User::$media_collection_main_resume);
        }

        $data->save();
        return Response::json(array(
            'dependentId' => $this->getFamilyId(),
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

        $dependent = User::where('family_member_id', Auth::id())
                        ->where('is_dependent', 1)
                        ->first();
        if($dependent){
            $dependent->passport_number = $request['dependent_passport_number'];
            $dependent->passport_issue_date =  date('Y-m-d', strtotime($request['dependent_passport_issue']));
            $dependent->passport_expiry = date('Y-m-d', strtotime($request['dependent_passport_expiry']));
            $dependent->passport_issued_by = $request['dependent_issued_by'];
            $dependent->country = $request['dependent_home_country'];
            $dependent->state = $request['dependent_state'];
            $dependent->city = $request['dependent_city'];
            $dependent->postal_code = $request['dependent_postal_code'];
            $dependent->address_line_1 = $request['dependent_address_1'];
            $dependent->address_line_2 = $request['dependent_address_2'];
        } else {
            $dependent = new User();
            $dependent->family_member_id = Auth::id();
            $dependent->is_dependent = 1;
            $dependent->passport_number = $request['dependent_passport_number'];
            $dependent->passport_issue_date =  date('Y-m-d', strtotime($request['dependent_passport_issue']));
            $dependent->passport_expiry = date('Y-m-d', strtotime($request['dependent_passport_expiry']));
            $dependent->passport_issued_by = $request['dependent_issued_by'];
            $dependent->country = $request['dependent_home_country'];
            $dependent->state = $request['dependent_state'];
            $dependent->city = $request['dependent_city'];
            $dependent->postal_code = $request['dependent_postal_code'];
            $dependent->address_line_1 = $request['dependent_address_1'];
            $dependent->address_line_2 = $request['dependent_address_2'];
        }
       
        $file = $request->file('dependent_passport_copy');
        if($request->hasFile('dependent_passport_copy')){
            $fileName = time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            $dependent->addMedia($request->file('dependent_passport_copy'))->usingFileName($fileName)->toMediaCollection(User::$media_collection_main);
        } 

        $dependent->save();
        return Response::json(array(
            'dependentId' => $this->getFamilyId(),
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

        $dependent = User::where('family_member_id', Auth::id())
                        ->where('is_dependent', 1)
                        ->first();
        if($dependent){ 
            $dependent->country_of_residence = $request->dependent_current_country;
            $dependent->residence_mobile_number = $request->dependent_current_residance_mobile;
            $dependent->residence_id = $request->dependent_residence_id;
            $dependent->visa_validity = date('Y-m-d', strtotime($request->dependent_visa_validity));
            $dependent->work_state = $request->dependent_work_state;
            $dependent->work_city = $request->dependent_work_city;
            $dependent->work_postal_code = $request->dependent_work_postal_code;
            $dependent->work_address = $request->dependent_work_street;
            $dependent->company_name = $request->dependent_company_name;
            $dependent->employer_phone_number = $request->dependent_employer_phone;
            $dependent->employer_email = $request->dependent_employer_email;
        } else {
            $dependent = new User();
            $dependent->family_member_id = AUth::id();
            $dependent->is_dependent = 1;
            $dependent->country_of_residence = $request->dependent_current_country;
            $dependent->residence_mobile_number = $request->dependent_current_residance_mobile;
            $dependent->residence_id = $request->dependent_residence_id;
            $dependent->visa_validity = date('Y-m-d', strtotime($request->dependent_visa_validity));
            $dependent->work_state = $request->dependent_work_state;
            $dependent->work_city = $request->dependent_work_city;
            $dependent->work_postal_code = $request->dependent_work_postal_code;
            $dependent->work_address = $request->dependent_work_street;
            $dependent->company_name = $request->dependent_company_name;
            $dependent->employer_phone_number = $request->dependent_employer_phone;
            $dependent->employer_email = $request->dependent_employer_email;
        }
        if ($request->hasFile('dependent_residence_copy')) {
            $file = $request->file('dependent_residence_copy');
            $residenceCopy = time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            $dependent->addMedia($request->file('dependent_residence_copy'))->usingFileName($residenceCopy)->toMediaCollection(User::$media_collection_main_residence_id);
        } 
        $visaCopy = $request['dependent_visa_copy'];
        if ($request->hasFile('dependent_visa_copy')) {
            $file = $request->file('dependent_visa_copy');
            $visaCopy = time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            $dependent->addMedia($request->file('dependent_visa_copy'))->usingFileName($visaCopy)->toMediaCollection(User::$media_collection_main_residence_visa);
        }
        $dependent->save();
        return Response::json(array(
            'dependentId' => $this->getFamilyId(),
            'success' => true
        ), 200);
    }

    public function storeSpouseSchenegenDetails(Request $request)
    {
        if($request['is_schengen_visa_issued_last_five_year']  == 'YES'){
            $validator = \Validator::make($request->all(), [
                'is_dependent_schengen_visa_issued_last_five_year' => 'required',
                'is_dependent_finger_print_collected_for_Schengen_visa' => 'required',
            ]);
        } else {
            $validator = \Validator::make($request->all(), [
                'is_dependent_schengen_visa_issued_last_five_year' => 'required',
            ]);
        }

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200); // 400 being the HTTP code for an invalid request.
        }
        $dependent = User::where('family_member_id', Auth::id())
            ->where('is_dependent', 1)
            ->first();
        if($dependent){
            $dependent->is_schengen_visa_issued_last_five_year = $request->is_dependent_schengen_visa_issued_last_five_year;
            $dependent->is_finger_print_collected_for_Schengen_visa  = $request->is_dependent_finger_print_collected_for_Schengen_visa;
        } else {
            $dependent = new User();
            $dependent->family_member_id = AUth::id();
            $dependent->is_dependent = 1;
            $dependent->is_schengen_visa_issued_last_five_year = $request->is_dependent_schengen_visa_issued_last_five_year;
            $dependent->is_finger_print_collected_for_Schengen_visa  = $request->is_dependent_finger_print_collected_for_Schengen_visa;
        }
        
        if ($request->hasFile('dependent_schengen_copy')) {
            $file = $request->file('dependent_schengen_copy');
            $schengenCopy = time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            $dependent->addMediaFromRequest('schengen_copy')->withCustomProperties(['mime-type' => 'image/jpeg'])->preservingOriginal()->usingFileName($schengenCopy)->toMediaCollection(User::$media_collection_main_schengen_visa);
        }
        $dependent->save();
        return Response::json(array(
            'dependentId' => $this->getFamilyId(),
            'success' => true
        ), 200);
    }

    public function getDependentExperience(Request $request)
    {
        // dd($request);
        $exp = ApplicantExperience::where('client_id', $request->applicantId)
                            // ->where(function ($query) use ($request) {
                            //     return $query->Where('dependant_id', $request->dependentId)
                            //         ->where('dependant_id', '>', 0 );
                            // })
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
        
        User::where('family_member_id', Auth::id())->where('is_dependent', 2)->delete();
        for($i = 1; $i <= $request['childrenCount']; $i++ ){
            $child = new User();
            $child->family_member_id = AUth::id();
            $child->is_dependent = 2;
            $child->name = $request['child_'.$i.'_first_name'];
            $child->middle_name = $request['child_'.$i.'_middle_name'];
            $child->sur_name = $request['child_'.$i.'_surname'];
            $child->date_of_birth = date('Y-m-d', strtotime($request['child_'.$i.'_dob']));
            $child->sex = $request['child_'.$i.'_gender'];
            $child->client_submission_status = 1;
            $child->save();
        }  
        Applicant::where('id', $request['applicant_id'])
                ->update(['application_stage_status' =>  4]);

        return Response::json(array(
            'success' => true
        ), 200);
    }

    private static function getFamilyId()
    {
        return User::where('family_member_id', Auth::id())
                            ->where('is_dependent', 1)
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
            User::where('id', Auth::id())
            ->update([
                'client_submission_status' => 1,
            ]);
            return true;
        } else if($user == 'family') {
            User::where('family_member_id', Auth::id())
                        ->where('is_dependent', 1)
                        ->update(['client_submission_status' => 1]);
            return true;
        } else if($user == 'children') {
            User::where('family_member_id', Auth::id())
                    ->where('is_dependent', 2)
                    ->update(['client_submission_status' => 1]);
            return true;
        }
    }

    public function checkApplicationStatus(Request $request)
    {
        $response['status'] = false;
        $applicant = Applicant::where('client_id', Auth::id())
                        ->where('destination_id', $request->product_id)
                        ->first();
        
        if($applicant){
            $response['status'] = true;
            if($applicant['work_permit_category'] == 'FAMILY PACKAGE'){
                if(Auth::user()->is_spouse  == 1){
                    $family = User::where('family_member_id', Auth::id())
                                ->where('is_dependent', 1)
                                ->where('client_submission_status', 1)
                                ->first();
                    if($family) {
                    } else {
                        $response['status'] = false;
                        $response['message'] = 'Family details should be completed before proceeding';
                    }
                }
                
                if(Auth::user()->children_count > 0){
                    $children = User::where('family_member_id', Auth::id())
                                ->where('is_dependent', 2)
                                ->where('client_submission_status', 1)
                                ->get(); 
                        
                    if(count($children) == Auth::user()->children_count) {
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

    public function getJobCategories(Request $request, $status=null) 
    {
        $filters = $request->input('filters');
        $query = JobCategoryOne::with('jobCategoryTwo.jobCategoryThree.jobCategoryFour');
        if ($filters && isset($filters['search_keyword'])) {
            $query->select('job_category_one.*');
            $query->distinct();
            $query->join('job_category_two', 'job_category_one.id', 'job_category_two.job_category_one_id');
            $query->join('job_category_three', 'job_category_two.id', 'job_category_three.job_category_two_id');
            $query->join('job_category_four', 'job_category_three.id', 'job_category_four.job_category_three_id');

            $query->where(function($query) use($filters){

                $query = $query->where('job_category_one.name', 'like', '%'.$filters['search_keyword'] .'%');
                $query = $query->orWhere('job_category_two.name', 'like', '%'.$filters['search_keyword'] .'%');
                $query = $query->orWhere('job_category_three.name', 'like', '%'.$filters['search_keyword'] .'%');
                $query = $query->orWhere('job_category_four.name', 'like', '%'.$filters['search_keyword'] .'%');
            });
        }
        $jobCategoryList = $query->get();
        return $jobCategoryList;
    }


    public function getJobCategoryFourList(Request $request, $status=null)
    {
        $filters = $request->input('filters');
        $query = JobCategoryFour::orderBy('job_category_four.name', 'desc');
        if ($filters && isset($filters['search_keyword'])) {
            $query->select('job_category_four.*', 'job_category_two.id as job_category_two_id', 'job_category_one.id as job_category_one_id');
            $query->distinct();
            $query->join('job_category_three', 'job_category_three.id', 'job_category_four.job_category_three_id');
            $query->join('job_category_two', 'job_category_two.id', 'job_category_three.job_category_two_id');
            $query->join('job_category_one', 'job_category_one.id', 'job_category_two.job_category_one_id');
            $query->where(function($query) use($filters){

                $query = $query->where('job_category_one.name', 'like', '%'.$filters['search_keyword'] .'%');
                $query = $query->orWhere('job_category_two.name', 'like', '%'.$filters['search_keyword'] .'%');
                $query = $query->orWhere('job_category_three.name', 'like', '%'.$filters['search_keyword'] .'%');
                $query = $query->orWhere('job_category_four.name', 'like', '%'.$filters['search_keyword'] .'%');
                $query = $query->orWhere('job_category_four.description', 'like', '%'.$filters['search_keyword'] .'%');
                $query = $query->orWhere('job_category_four.example_titles', 'like', '%'.$filters['search_keyword'] .'%');
            });
        }
        $jobCategoryList = $query->get();
        return $jobCategoryList;
    }
}
