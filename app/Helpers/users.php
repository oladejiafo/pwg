<?php

namespace App\Helpers;

use Codedge\Fpdf\Fpdf\Fpdf;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
use App\Models\Affiliate;
use App\Models\Client;

use App\Models\product;
use App\Models\Applicant;
use App\Models\user;
use Exception;
use App\Mail\ExceptionMail;
use App\Constant;
use Mail;
use session;
use Carbon\Carbon;
use App\Mail\QuickbookMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class users
{
    public function clients(): ?Client
    {
        $user = auth()->user();

        if ($user instanceof Client) {
            return $user;
        }

        return null;
    }

    public function affiliate(): ?Affiliate
    {
        $user = auth()->user();

        if ($user instanceof Affiliate) {
            return $user;
        }

        return null;
    }

    public static function getRandomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < 6; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    public static function getAlphabeticRandomString()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < 3; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }


    public static function getWorkpermitFile($paidDetails)
    {
        $response = [
            'fileUrl' => '',
            'FileExist' => false
        ];
        if (strtoupper($paidDetails->first_payment_status) == 'PAID' && $paidDetails->work_permit_status == "WORK_PERMIT_RECEIVED") {
            $client = new \GuzzleHttp\Client();
            $res = $client->request(
                'POST',
                env('ADMIN_URL') . '/api/get-work-permit',
                [
                    'form_params' => $paidDetails,
                ]
            );

            $fileData = $res->getBody()->getContents();
            $file = json_decode($fileData);
            $response = [
                'fileUrl' => $file->fileUrl,
                'FileExist' => $file->status
            ];
        }
        return $response;
    }

    public static function getContract($paidDetails) {
        $applicant = Applicant::find($paidDetails->id);
        if(strtoupper($paidDetails->third_payment_status) == 'PAID' && !empty($paidDetails->contract)) {
            $applicant->contractUrl = (isset($applicant->getMedia(Applicant::$media_collection_main_3rd_signature)[0])) ? $applicant->getMedia(Applicant::$media_collection_main_3rd_signature)[0]->getFullUrl() : null;
            
            if(File::exists($applicant->getMedia(Applicant::$media_collection_main_3rd_signature)[0]->getPath())){
                return $applicant;
            }
        } else if(strtoupper($paidDetails->second_payment_status) == 'PAID' && !empty($paidDetails->contract)) {
            $applicant->contractUrl = (isset($applicant->getMedia(Applicant::$media_collection_main_2nd_signature)[0])) ? $applicant->getMedia(Applicant::$media_collection_main_2nd_signature)[0]->getFullUrl() : null;

            if(File::exists($applicant->getMedia(Applicant::$media_collection_main_2nd_signature)[0]->getPath())){
                return $applicant;
            }
        } else if(strtoupper($paidDetails->submission_payment_status) == 'PAID' && !empty($paidDetails->contract)) {
            $applicant->contractUrl = (isset($applicant->getMedia(Applicant::$media_collection_main_submission_signature)[0])) ? $applicant->getMedia(Applicant::$media_collection_main_submission_signature)[0]->getFullUrl() : null;

            if(File::exists($applicant->getMedia(Applicant::$media_collection_main_submission_signature)[0]->getPath())){
                return $applicant;
            }

        } else if(strtoupper($paidDetails->first_payment_status) == 'PAID' && !empty($paidDetails->contract)){
            $applicant->contractUrl = (isset($applicant->getMedia(Applicant::$media_collection_main_1st_signature)[0])) ? $applicant->getMedia(Applicant::$media_collection_main_1st_signature)[0]->getFullUrl() : null;

            if(File::exists($applicant->getMedia(Applicant::$media_collection_main_1st_signature)[0]->getPath())){
                return $applicant;
            }
        } else {
            $applicant->contractUrl="";
        }

    }
    public static function getWorkPermitStatus($paidDetails)
    {
        $response['status'] = false;
        try {
            $file = self::getWorkpermitFile($paidDetails);
            if (strtoupper($paidDetails->first_payment_status) == 'PAID' && strtoupper($paidDetails->submission_payment_status) == 'PAID' && $paidDetails->work_permit_status == "WORK_PERMIT_RECEIVED" && $file['FileExist']) {
                $response['message'] = "Download work permit";
                $response['fileUrl'] = $file['FileUrl'];
                $response['status'] = true;
            } else if (strtoupper($paidDetails->first_payment_status) == 'PAID' && $paidDetails->work_permit_status == "WORK_PERMIT_RECEIVED" && strtoupper($paidDetails->submission_payment_status) != 'PAID' && $file['FileExist']) {
                $response['message'] = "Download after second payment";
            } else {
                $response['message'] = "Work permit not available yet.";
            }
        } catch (Exception $e) {
            $response['message'] = "Work Permit not available yet.";
        }
        return $response;
    }
}
