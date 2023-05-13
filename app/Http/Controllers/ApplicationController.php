<?php

namespace App\Http\Controllers;

use App\Client;
use App\Application;
use App\Models\ApplicantExperience;
use App\Models\JobCategoryOne;
use App\Models\JobCategoryFour;
use App\Models\JobCategoryThree;
use App\Models\JobCategoryTwo;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use App\Mail\NotifyMail;
use DB;
use Session;
use App\Helpers\pdfBlock;
use App\Constant;
use QuickBooksOnline\API\Facades\Employee;

class ApplicationController extends Controller
{

    public function applicant($productId)
    {
        if (Auth::id()) {
            session()->forget('info');
            $completed = DB::table('applications')
                ->where('destination_id', '=', $productId)
                ->where('client_id', '=', Auth::user()->id)
                ->orderBy('id', 'DESC')
                ->first();
            if (isset($completed->application_stage_status)) {
                $levels = $completed->application_stage_status;
            } else {
                $levels = 4;
            }
            return view('user.application-next', compact('productId', 'levels'));
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
            ]);

            $client = Client::find(Auth::id());
            $client->addMedia($request->file('cv'))->toMediaCollection(Client::$media_collection_main_resume, env('MEDIA_DISK'));

            $applicant = Application::where('client_id', Auth::id())
                ->where('destination_id', $request->product_id)
                ->orderBy('id', 'DESC')
                ->first();
            $agentCode = DB::table('employees')->where('agent_unique_code', $request->agent_code)->pluck('id')->first();
            $applicant->application_stage_status = 3;
            $applicant->assigned_agent_id = $applicant->assigned_agent_id
                ?? $agentCode
                ?? $request->agent_code
                ?? null;
            $applicant->save();
            return Redirect::route('applicant.details', $request->product_id);
        }
    }

    public function applicantDetails($productId)
    {
        Session::forget('info');
        if (Auth::id()) {
            if (isset($productId)) {
            } else {
                $productId =  Session::get('myproduct_id');
            }

            $client = Client::find(Auth::id());
            $applicant = Application::where('client_id', Auth::id())
                ->where('destination_id', $productId)
                ->orderBy('id', 'DESC')
                ->first();

            $dependent = Client::where('family_member_id', Auth::id())
                ->where('is_dependent', 1)
                ->pluck('id')
                ->first();

            $client = Client::find(Auth::id()); //check this line ???

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
            'email' => 'required | email:rfc,dns',
            'phone_number' => 'required',
            'place_birth' => 'required',
            'country_birth' => 'required',
            'sex' => 'required',
            'civil_status' => 'required',
            'citizenship' => 'required',
            'cv' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(array(
                'status' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200); // 400 being the HTTP code for an invalid request.
        }
        $client = Client::find(Auth::id());
        if ($request->hasFile('cv')) {
            if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                $client->addMedia($request->file('cv'))->toMediaCollection(Client::$media_collection_main_resume, env('MEDIA_DISK'));
            } else {
                $client->addMedia($request->file('cv'))->toMediaCollection(Client::$media_collection_main_resume, 'local');
            }
            $client->save();
        }
        Client::where('id', Auth::id())
            ->update([
                'name' => $request['first_name'],
                'middle_name' => $request['middle_name'],
                'sur_name' => $request['surname'],
                'email' => $request['email'],
                'phone_number' => $request['phone_number'],
                'date_of_birth' => date('Y-m-d', strtotime($request['dob'])),
                'place_of_birth' => $request['place_birth'],
                'country_of_birth' => $request['country_birth'],
                'citizenship' => $request['citizenship'],
                'sex' => $request['sex'],
                'civil_status' => $request['civil_status'],
            ]);


        $applicant = Application::where('client_id', Auth::id())
            ->where('destination_id', $request->product_id)
            ->orderBy('id', 'DESC')
            ->first();
        $applicant->assigned_agent_id = ($applicant->assigned_agent_id) ?? (($request->agent_code != null) ? strip_tags($request->agent_code) : null);
        $applicant->sales_agent_name_by_client = ($request->agent_name != null) ? strip_tags($request->agent_name) : null;
        $applicant->save();

        return Response::json(array(
            'status' => true
        ), 200);
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
                'status' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200); // 400 being the HTTP code for an invalid request.
        }

        $file = $request->file('passport_copy');
        $client = Client::find(Auth::id());
        $fileName = '';
        if ($request->hasFile('passport_copy')) {
            $fileName = Auth::user()->id . '_' . time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                $client->addMedia($request->file('passport_copy'))->usingFileName($fileName)->toMediaCollection(Client::$media_collection_main, env('MEDIA_DISK'));
            } else {
                $client->addMedia($request->file('passport_copy'))->usingFileName($fileName)->toMediaCollection(Client::$media_collection_main, 'local');
            }
        }

        $client->passport_number  = $request['passport_number'];
        $client->passport_issue_date =  date('Y-m-d', strtotime($request['passport_issue']));
        $client->passport_expiry = date('Y-m-d', strtotime($request['passport_expiry']));
        $client->passport_issued_by = $request['issued_by'];
        $client->country = $request['home_country'];
        $client->state = $request['state'];
        $client->city = $request['city'];
        $client->postal_code = $request['postal_code'];
        $client->address_line_1 = $request['address_1'];
        $client->address_line_2 = $request['address_2'];
        $client->save();

        return Response::json(
            array(
                'status' => true,
                'passport' => storage_path('passportCopy/' . $fileName)
            ),
            200
        );
    }

    public function applicantReview($productId)
    {
        if (Auth::id()) {
            $client = Client::find(Auth::id());
            $applicant = Application::where('client_id', Auth::id())
                ->where('destination_id', $productId)
                ->orderBy('id', 'DESC')
                ->first();
            $dependent = Client::where('family_member_id', Auth::id())->where('is_dependent', 1)->first();
            $children = Client::where('family_member_id', Auth::id())->where('is_dependent', 2)->get();
            if ($applicant->application_stage_status != '5' && $applicant->application_stage_status != '4') {
                return Redirect::route('applicant.details', $productId)->with('error', 'You have to complete applicant details first!');
            }

            return view('user.application-review', compact('client', 'applicant', 'productId', 'dependent', 'children'))->with('success', 'Data saved successfully!');
        } else {
            return redirect('home');
        }
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
            'work_state' => 'required',
            'work_city' => 'required',
            'work_postal_code' => 'required',
            'work_street' => 'required',
            'current_location' => 'required',
            'embassy_appearance' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(array(
                'status' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200); // 400 being the HTTP code for an invalid request.
        }
        $client = Client::find(Auth::id());
        if ($request->hasFile('residence_copy')) {
            $file = $request->file('residence_copy');
            $residenceCopy = Auth::user()->id . '_' . time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                $client->addMedia($request->file('residence_copy'))->usingFileName($residenceCopy)->toMediaCollection(Client::$media_collection_main_residence_id, env('MEDIA_DISK'));
            } else {
                $client->addMedia($request->file('residence_copy'))->usingFileName($residenceCopy)->toMediaCollection(Client::$media_collection_main_residence_id, 'local');
            }
        } else {
            $residenceCopy = $request->file('residence_copy');
        }
        $visaCopy = $request['visa_copy'];
        if ($request->hasFile('visa_copy')) {
            $file = $request->file('visa_copy');
            $visaCopy = Auth::user()->id . '_' . time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                $client->addMedia($request->file('visa_copy'))->usingFileName($visaCopy)->toMediaCollection(Client::$media_collection_main_residence_visa, env('MEDIA_DISK'));
            } else {
                $client->addMedia($request->file('visa_copy'))->usingFileName($visaCopy)->toMediaCollection(Client::$media_collection_main_residence_visa, 'local');
            }
        }
        $client->country_of_residence = (strlen($request->current_country) > 0) ? $request->current_country : $client->country_of_residence;
        $client->residence_mobile_number = $request->current_residance_mobile;
        $client->residence_id = $request->residence_id;
        $client->visa_validity = ($request->visa_validity) ? date('Y-m-d', strtotime($request->visa_validity)) : null;
        $client->work_state = $request->work_state;
        $client->work_city = $request->work_city;
        $client->work_postal_code = $request->work_postal_code;
        $client->work_address = $request->work_street;
        $client->company_name = $request->company_name;
        $client->employer_phone_number = $request->employer_phone;
        $client->employer_email = $request->employer_email;
        $client->country_of_residence = $request->current_location;
        $client->save();

        $applicant = Application::where('client_id', Auth::id())
            ->where('destination_id', $request->product_id)
            ->orderBy('id', 'DESC')
            ->first();
        $applicant->embassy_country = $request->embassy_appearance;
        $applicant->save();

        return Response::json(array('status' => true), 200);
    }

    /**
     * Store applicant schengen visa details as step 4
     * @param Request
     *
     * @return response
     */
    public function storeSchengenDetails(Request $request)
    {
        if ($request['is_schengen_visa_issued_last_five_year']  == 'YES') {
            $validator = \Validator::make($request->all(), [
                'is_schengen_visa_issued_last_five_year' => 'required',
                'schengen_copy' => 'required',
                'is_finger_print_collected_for_Schengen_visa' => 'required'
            ]);
        } else {
            $validator = \Validator::make($request->all(), [
                'is_schengen_visa_issued_last_five_year' => 'required',
            ]);
        }

        if ($validator->fails()) {
            return Response::json(array(
                'status' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200); // 400 being the HTTP code for an invalid request.
        }
        $schengenCopy = null;
        $client = Client::find(AUth::id());
        if ($request->hasFile('schengen_copy')) {
            $file = $request->file('schengen_copy');
            $schengenCopy = Auth::user()->id . '_' . time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            if (!in_array($_SERVER['REMOTE_ADDR'], Constant::is_local)) {
                $client->addMediaFromRequest('schengen_copy')->withCustomProperties(['mime-type' => 'image/jpeg'])->preservingOriginal()->usingFileName($schengenCopy)->toMediaCollection(Client::$media_collection_main_schengen_visa, env('MEDIA_DISK'));
            } else {
                $client->addMediaFromRequest('schengen_copy')->withCustomProperties(['mime-type' => 'image/jpeg'])->preservingOriginal()->usingFileName($schengenCopy)->toMediaCollection(Client::$media_collection_main_schengen_visa, 'local');
            }
            $client->save();
        }

        //Save the added array of schengen visas if available
        if ($request->hasfile('schengen_copy1')) {
            $x = 0;
            $file = [];
            foreach ($request->file('schengen_copy1') as $copy1) {
                $x++;
                $name = $copy1->getClientOriginalName();

                list($nName, $nExt) = explode('.', $name);
                $schengenCopy1 = Auth::user()->id . '_' . time() . '_' . str_replace(' ', '_',  $name);
                $client
                    ->addMedia($copy1) //starting method
                    ->withCustomProperties(['mime-type' => 'image/jpeg']) //middle method
                    ->preservingOriginal() //middle method
                    ->usingName($nName)
                    ->usingFileName($schengenCopy1)
                    ->toMediaCollection(Client::$media_collection_main_schengen_visa . $x, env('MEDIA_DISK')); //finishing method
                $client->save();
            }
        }

        $client->is_schengen_visa_issued_last_five_year  = $request->is_schengen_visa_issued_last_five_year;
        $client->is_finger_print_collected_for_Schengen_visa = $request->is_finger_print_collected_for_Schengen_visa;
        $client->save();

        return Response::json(array('status' => true), 200);
    }


    /**
     * Store applicant experience as step 4
     * @param Request
     *
     * @return response
     */
    public function addExperience(Request $request)
    {
        $job_category_two_id = ($request['job_category_two_id']) ?? JobCategoryThree::where('id', $request['job_category_three_id'])->pluck('job_category_two_id')->first();
        $job_category_one_id = ($request['job_category_one_id']) ?? JobCategoryTwo::where('id', $job_category_two_id)->pluck('job_category_one_id')->first();
        if ($request['userType'] == 'dependent') {
            $data = Client::where('family_member_id', Auth::id())
                ->where('is_dependent', 1)
                ->first();
            if ($data) {
                $exist = ApplicantExperience::where('client_id', $request->dependentId)
                    ->where('job_category_three_id', $request['job_category_three_id'])
                    ->where('job_category_four_id', $request['job_category_four_id'])
                    ->first();
                if (!$exist) {
                    $exp = new ApplicantExperience();
                    $exp->client_id = $request->dependentId;
                    $exp->job_title = $request['job_title'];
                    $exp->job_category_one_id = $request['job_category_one_id'];
                    $exp->job_category_two_id = $request['job_category_two_id'];
                    $exp->job_category_three_id  = $request['job_category_three_id'];
                    $exp->job_category_four_id   = $request['job_category_four_id'];
                    $exp->created_by = $request->dependentId;
                    $exp->save();
                    $response = [
                        'status' => true
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Experience already added!'
                    ];
                }
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Please provide dependent details!'
                ];
            }
        } else {
            $exist = ApplicantExperience::where('client_id', Auth::id())
                ->where('job_category_three_id', $request['job_category_three_id'])
                ->where('job_category_four_id', $request['job_category_four_id'])
                ->first();

            if (!$exist) {
                $exp = new ApplicantExperience();
                $exp->client_id = Auth::id();
                $exp->job_title = $request['job_title'];
                $exp->job_category_one_id =  $job_category_one_id;
                $exp->job_category_two_id = $job_category_two_id;
                $exp->job_category_three_id = (int)$request['job_category_three_id'];
                $exp->job_category_four_id = (int)$request['job_category_four_id'];
                $exp->created_by = Auth::id();
                $exp->save();
                $response = [
                    'status' => true
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Experience already added'
                ];
            }
        }
        return $response;
    }

    /**
     * get applicant added experience
     * @param Request
     *
     * @return response
     */
    public function getApplicantExperience(Request $request)
    {
        $exp = ApplicantExperience::where('client_id', Auth::id())
            ->get();
        return $exp;
    }

    public function removeExperience(Request $request)
    {
        if ($request['userType'] == 'applicant') {
            $data = DB::table('client_experiences')
                ->where('id', $request['expId'])
                ->where('client_id', Auth::id());
            if ($data->delete()) {
                return true;
            } else {
                return false;
            }
        } else {
            $data = DB::table('client_experiences')
                ->where('id', $request['expId'])
                ->where('client_id', $request['dependentId']);
            if ($data->delete()) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Store applicant details as step 4
     * @param Request
     *
     * @return response
     */
    public function applicantReviewSubmit(Request $request)
    {
        $applicant =  Application::where('client_id', Auth::id())
            ->where('destination_id', $request->product_id)
            ->orderBy('id', 'DESC')
            ->select('id')
            ->first();
        $update = Application::where('client_id', Auth::id())
            ->where('destination_id', $request->product_id)
            ->update([
                'application_stage_status' => 5,
                'status' => 'DOCUMENTS_SUBMITTED',
                'processing_status' => 'NOT_STARTED'
            ]);
        if($update) {

            pdfBlock::mapMoreInfo($applicant);
        }

        // Send Notifications on This Payment ##############
        $email = Auth::user()->email;
        $userID = Auth::user()->id;

        $criteria = "Application Completed!";
        $message = "You have completed and submitted your application successfully. Kindly login to the PWG Client portal and check your receipt on 'My Application' for further updates";

        $link = "";

        $dataArray = [
            'title' => $criteria . 'Mail from PWG Group',
            'body' => $message,
            'link' => $link,
            'status' => 'application'
        ];

        $check_noti = DB::table('notifications')
            ->where('criteria', '=', $criteria)
            ->where('client_id', '=', Auth::user()->id)
            ->first();
        if ($check_noti === null) {
            $tday = date('Y-m-d');
            DB::table('notifications')->insert(
                ['client_id' => $userID, 'message' => $message, 'criteria' => $criteria, 'link' => $link, 'created_at' => $tday]
            );

            Mail::to($email)->send(new NotifyMail($dataArray));
            // Notification Ends ############ 
        }
        return Response::json(array('success' => true), 200);
    }

    public function submitApplicantDetails(Request $request)
    {
        $response['status'] = false;
        try {
            Application::where('id', $request['applicantId'])
                ->update(
                    [
                        'application_stage_status' => 4,
                        'status' => 'DOCUMENTS_SUBMITTED'
                    ]
                );

            $this->_updateApplicationStatus($request->product_id, $request['applicantId'], $request['user']);
            $response['status'] = true;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }
        return $response;
    }

    public function storeDependentDetails(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'dependent_first_name' => 'required',
                'dependent_surname' => 'required',
                'email' => 'required | email:rfc,dns',
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
                    'status' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 200); // 400 being the HTTP code for an invalid request.
            }

            $data = Client::where('family_member_id', Auth::id())
                ->where('is_dependent', 1)
                ->first();

            if ($data) {
                $data->name = $request['dependent_first_name'];
                $data->middle_name = $request['dependent_middle_name'];
                $data->sur_name = $request['dependent_surname'];
                $data->email  = $request['email'];
                $data->phone_number  = $request['dependent_phone_number'];
                $data->date_of_birth = date('Y-m-d', strtotime($request['dependent_dob']));
                $data->place_of_birth = $request['dependent_place_birth'];
                $data->country_of_birth = $request['dependent_country_birth'];
                $data->citizenship = $request['dependent_citizenship'];
                $data->sex = $request['dependent_sex'];
                $data->civil_status = $request['dependent_civil_status'];
            } else {
                $data = new Client();
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
                $data->addMedia($request->file('dependent_resume'))->toMediaCollection(Client::$media_collection_main_resume, env('MEDIA_DISK'));
            }

            $data->save();
            return Response::json(array(
                'dependentId' => $this->getFamilyId(),
                'status' => true
            ), 200);
        } catch (Exception $e) {
            return Response::json(array(
                'status' => false,
                'message' => $e->getMessage()
            ), 200);
        }
    }

    public function storeDependentHomeContryDetails(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'passport_number' => 'Required',
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
                'status' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200); // 400 being the HTTP code for an invalid request.
        }

        $dependent = Client::where('family_member_id', Auth::id())
            ->where('is_dependent', 1)
            ->first();
        if ($dependent) {
            $dependent->passport_number = $request['passport_number'];
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
            return Response::json(
                array(
                    'status' => false,
                    'message' => 'Please provide dependent details',
                ),
                200
            );
        }

        $file = $request->file('dependent_passport_copy');
        $fileName = null;
        if ($request->hasFile('dependent_passport_copy')) {
            $fileName = Auth::user()->id . '_' . time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            $dependent
                ->addMedia($request->file('dependent_passport_copy'))
                ->usingFileName($fileName)
                ->toMediaCollection(Client::$media_collection_main, env('MEDIA_DISK'));
        }

        $dependent->save();
        return Response::json(
            array(
                'dependentId' => $this->getFamilyId(),
                'status' => true,
                'passport' => ($request->hasFile('dependent_passport_copy')) ? storage_path('passportCopy/' . $fileName) : '',
            ),
            200
        );
    }

    public function storeSpouseCurrentDetails(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'dependent_work_state' => 'required',
            'dependent_work_city' => 'required',
            'dependent_work_postal_code' => 'required',
            'dependent_work_street' => 'required'
        ]);

        if ($validator->fails()) {
            return Response::json(array(
                'status' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200); // 400 being the HTTP code for an invalid request.
        }

        $dependent = Client::where('family_member_id', Auth::id())
            ->where('is_dependent', 1)
            ->first();
        if ($dependent) {
            $dependent->country_of_residence = $request->dependent_current_country;
            $dependent->residence_mobile_number = $request->dependent_current_residance_mobile;
            $dependent->residence_id = $request->dependent_residence_id;
            $dependent->visa_validity = ($request->dependent_visa_validity) ? date('Y-m-d', strtotime($request->dependent_visa_validity)) : null;
            $dependent->work_state = $request->dependent_work_state;
            $dependent->work_city = $request->dependent_work_city;
            $dependent->work_postal_code = $request->dependent_work_postal_code;
            $dependent->work_address = $request->dependent_work_street;
            $dependent->company_name = $request->dependent_company_name;
            $dependent->employer_phone_number = $request->dependent_employer_phone;
            $dependent->employer_email = $request->dependent_employer_email;
        } else {
            return Response::json(
                array(
                    'status' => false,
                    'message' => 'Please provide dependent details',
                ),
                200
            );
        }
        if ($request->hasFile('dependent_residence_copy')) {
            $file = $request->file('dependent_residence_copy');
            $residenceCopy = Auth::user()->id . '_' . time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            $dependent->addMedia($request->file('dependent_residence_copy'))
                ->usingFileName($residenceCopy)
                ->toMediaCollection(Client::$media_collection_main_residence_id, env('MEDIA_DISK'));
        }
        $visaCopy = $request['dependent_visa_copy'];
        if ($request->hasFile('dependent_visa_copy')) {
            $file = $request->file('dependent_visa_copy');
            $visaCopy = Auth::user()->id . '_' . time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            $dependent->addMedia($request->file('dependent_visa_copy'))
                ->usingFileName($visaCopy)
                ->toMediaCollection(Client::$media_collection_main_residence_visa, env('MEDIA_DISK'));
        }
        $dependent->save();
        return Response::json(array(
            'dependentId' => $this->getFamilyId(),
            'status' => true
        ), 200);
    }

    public function storeSpouseSchenegenDetails(Request $request)
    {
        if ($request['is_schengen_visa_issued_last_five_year']  == 'YES') {
            $validator = \Validator::make($request->all(), [
                'is_dependent_schengen_visa_issued_last_five_year' => 'required',
                'dependent_schengen_copy' => 'required',
                'is_dependent_finger_print_collected_for_Schengen_visa' => 'required',
            ]);
        } else {
            $validator = \Validator::make($request->all(), [
                'is_dependent_schengen_visa_issued_last_five_year' => 'required',
            ]);
        }

        if ($validator->fails()) {
            return Response::json(array(
                'status' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200); // 400 being the HTTP code for an invalid request.
        }
        $dependent = Client::where('family_member_id', Auth::id())
            ->where('is_dependent', 1)
            ->first();
        if ($dependent) {
            $dependent->is_schengen_visa_issued_last_five_year = $request->is_dependent_schengen_visa_issued_last_five_year;
            $dependent->is_finger_print_collected_for_Schengen_visa  = $request->is_dependent_finger_print_collected_for_Schengen_visa;
            $dependent->save();
        } else {
            return Response::json(
                array(
                    'status' => false,
                    'message' => 'Please provide dependent details',
                ),
                200
            );
        }
        if ($request->hasFile('dependent_schengen_copy')) {
            $file = $request->file('dependent_schengen_copy');
            $schengenCopy = Auth::user()->id . '_' . time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
            $dependent->addMediaFromRequest('dependent_schengen_copy')->withCustomProperties(['mime-type' => 'image/jpeg'])->preservingOriginal()
                ->usingFileName($schengenCopy)
                ->toMediaCollection(Client::$media_collection_main_schengen_visa, env('MEDIA_DISK'));
            $dependent->save();
        }
        //Save the added array of schengen visas if available
        if ($request->hasfile('dependent_schengen_copy1')) {
            $x = 0;
            foreach ($request->file('dependent_schengen_copy1') as $copy1) {
                $x = $x + 1;

                $name = $copy1->getClientOriginalName();

                list($nName, $nExt) = explode('.', $name);
                $schengenCopy1 = Auth::user()->id . '_' . time() . '_' . str_replace(' ', '_',  $name);
                $dependent
                    ->addMedia($copy1) //starting method
                    ->withCustomProperties(['mime-type' => 'image/jpeg']) //middle method
                    ->preservingOriginal() //middle method
                    ->usingName($nName)
                    ->usingFileName($schengenCopy1)
                    ->toMediaCollection(Client::$media_collection_main_schengen_visa . $x, env('MEDIA_DISK')); //finishing method
                $dependent->save();
            }
        }

        $dependent->save();
        return Response::json(array(
            'dependentId' => $this->getFamilyId(),
            'status' => true
        ), 200);
    }

    public function getDependentExperience(Request $request)
    {
        $exp = ApplicantExperience::where('client_id', $request->dependentId)
            ->get();
        return $exp;
    }

    public function storeChildrenDetails(Request $request)
    {
        try {
            for ($i = 1; $i <= $request['childrenCount']; $i++) {
                $validator = \Validator::make($request->all(), [
                    "child_" . $i . "_first_name" => 'required',
                    "child_" . $i . "_surname" => 'required',
                    "child_" . $i . "_dob" => 'required',
                    "child_" . $i . "_gender" => 'required',
                    "child_" . $i . "_passport_number" => 'required',
                    "child_passport_" . $i  => 'required',
                ]);
                if ($validator->fails()) {
                    return Response::json(array(
                        'status' => false,
                        'errors' => $validator->getMessageBag()->toArray()

                    ), 200); // 400 being the HTTP code for an invalid request.
                }
            }
            Client::where('family_member_id', Auth::id())->where('is_dependent', 2)->delete();
            for ($i = 1; $i <= $request['childrenCount']; $i++) {
                $child = new Client();
                $child->family_member_id = AUth::id();
                $child->is_dependent = 2;
                $child->name = $request['child_' . $i . '_first_name'];
                $child->middle_name = $request['child_' . $i . '_middle_name'];
                $child->sur_name = $request['child_' . $i . '_surname'];
                $child->date_of_birth = date('Y-m-d', strtotime($request['child_' . $i . '_dob']));
                $child->sex = $request['child_' . $i . '_gender'];
                $child->client_submission_status = 1;
                if ($request->hasFile("child_passport_" . $i)) {
                    $file = $request->file("child_passport_" . $i);
                    $fileName = Auth::user()->id . '_' . time() . '_' . str_replace(' ', '_',  $file->getClientOriginalName());
                    $child
                        ->addMedia($request->file("child_passport_" . $i))
                        ->usingFileName($fileName)
                        ->toMediaCollection(Client::$media_collection_main, env('MEDIA_DISK'));
                }
                $child->passport_number = $request['child_' . $i . '_passport_number'];
                $child->save();
            }
            Application::where('id', $request['applicant_id'])->where('application_stage_status', '!=', 5)
                ->update(['application_stage_status' =>  4]);

            return Response::json(array(
                'status' => true
            ), 200);
        } catch (Exception $e) {
            // dd($e);
            return Response::json(array(
                'status' => false
            ), 200);
        }
    }

    private static function getFamilyId()
    {
        return Client::where('family_member_id', Auth::id())
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
        if ($user == 'applicant') {
            Client::where('id', Auth::id())
                ->update([
                    'client_submission_status' => 1,
                ]);
            return true;
        } else if ($user == 'family') {
            Client::where('family_member_id', Auth::id())
                ->where('is_dependent', 1)
                ->update(['client_submission_status' => 1]);
            return true;
        } else if ($user == 'children') {
            Client::where('family_member_id', Auth::id())
                ->where('is_dependent', 2)
                ->update(['client_submission_status' => 1]);
            return true;
        }
    }

    public function checkApplicationStatus(Request $request)
    {
        $response['status'] = false;
        $applicant = Application::where('client_id', Auth::id())
            ->where('destination_id', $request->product_id)
            ->orderBy('id', 'DESC')
            ->first();

        if ($applicant) {
            $response['status'] = true;
            if ($applicant['work_permit_category'] == 'FAMILY_PACKAGE') {
                if (Auth::user()->is_spouse  == 1) {
                    $family = Client::where('family_member_id', Auth::id())
                        ->where('is_dependent', 1)
                        ->where('client_submission_status', 1)
                        ->first();
                    if ($family) {
                    } else {
                        $response['status'] = false;
                        $response['message'] = 'Family details should be completed before proceeding';
                    }
                }

                if (Auth::user()->children_count > 0) {
                    $children = Client::where('family_member_id', Auth::id())
                        ->where('is_dependent', 2)
                        ->where('client_submission_status', 1)
                        ->get();

                    if (count($children) == Auth::user()->children_count) {
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

    public function getJobCategories(Request $request, $status = null)
    {
        $filters = $request->input('filters');
        $query = JobCategoryOne::with('jobCategoryTwo.jobCategoryThree.jobCategoryFour');
        if ($filters && isset($filters['search_keyword'])) {
            $query->select('job_category_one.*');
            $query->distinct();
            $query->join('job_category_two', 'job_category_one.id', 'job_category_two.job_category_one_id');
            $query->join('job_category_three', 'job_category_two.id', 'job_category_three.job_category_two_id');
            $query->join('job_category_four', 'job_category_three.id', 'job_category_four.job_category_three_id');

            $query->where(function ($query) use ($filters) {

                $query = $query->where('job_category_one.name', 'like', '%' . $filters['search_keyword'] . '%');
                $query = $query->orWhere('job_category_two.name', 'like', '%' . $filters['search_keyword'] . '%');
                $query = $query->orWhere('job_category_three.name', 'like', '%' . $filters['search_keyword'] . '%');
                $query = $query->orWhere('job_category_four.name', 'like', '%' . $filters['search_keyword'] . '%');
            });
        }
        $jobCategoryList = $query->get();
        return $jobCategoryList;
    }


    public function getJobCategoryFourList(Request $request, $status = null)
    {
        $filters = $request->input('filter');
        $query = JobCategoryFour::orderBy('job_category_four.name', 'desc');
        if ($filters) {
            $query->select('job_category_four.*', 'job_category_two.id as job_category_two_id', 'job_category_one.id as job_category_one_id');
            $query->distinct();
            $query->join('job_category_three', 'job_category_three.id', 'job_category_four.job_category_three_id');
            $query->join('job_category_two', 'job_category_two.id', 'job_category_three.job_category_two_id');
            $query->join('job_category_one', 'job_category_one.id', 'job_category_two.job_category_one_id');
            $query->where(function ($query) use ($filters) {

                $query = $query->where('job_category_one.name', 'like', '%' . $filters . '%');
                $query = $query->orWhere('job_category_two.name', 'like', '%' . $filters . '%');
                $query = $query->orWhere('job_category_three.name', 'like', '%' . $filters . '%');
                $query = $query->orWhere('job_category_four.name', 'like', '%' . $filters . '%');
                $query = $query->orWhere('job_category_four.description', 'like', '%' . $filters . '%');
                $query = $query->orWhere('job_category_four.example_titles', 'like', '%' . $filters . '%');
            });
        }
        $jobCategoryList = $query->get();
        return $jobCategoryList;
    }

    public function addReferrer(Request $request)
    {
        $applicant = Application::where('client_id', Auth::id())
            ->where('destination_id', $request->product_id)
            ->update([
                'referrer_name_by_client' => $request->referrerName,
                'referrer_passport_number_by_client' => $request->referrerPassport
            ]);

        return Response::json(array(
            'status' => true
        ), 200);
    }
}
