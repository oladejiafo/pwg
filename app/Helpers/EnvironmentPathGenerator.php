<?php

namespace App\Helpers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\DefaultPathGenerator;
use Illuminate\Support\Str;

// Customize the path where the image gets stored (on the local filesystem, on S3, etc)
class EnvironmentPathGenerator extends DefaultPathGenerator
{
    protected $path;

    public function getPath(Media $media): string
    {

        switch ($media->collection_name) {
            case 'client_passport_collection_img':
                $path = 'Clients/Passports/';
                break;
            case 'client_collection_schengen_visa':
                $path = 'Clients/SchengenVisas/';
                break;
            case 'client_collection_schengen_visa1':
                $path = 'Clients/SchengenVisas/';
                break;    
            case 'client_collection_schengen_visa2':
                $path = 'Clients/SchengenVisas/';
                break;
            case 'client_collection_schengen_visa3':
                $path = 'Clients/SchengenVisas/';
                break;
            case 'client_collection_schengen_visa4':
                $path = 'Clients/SchengenVisas/';
                break;
            case 'client_collection_residence_id':
                $path = 'Clients/ResidenceIDs/';
                break;
            case 'client_collection_resume':
                $path = 'Clients/Resumes/';
                break;
            case 'client_collection_pwg_standard_resume':
                $path = 'Clients/PwgStandardResumes/';
                break;
            case 'contract_1st_signature_collection_pdf':
                $path = 'Applications/Contracts/First/';
                break;
            case 'contract_2nd_signature_collection_pdf':
                $path = 'Applications/Contracts/Second/';
                break;
            case 'contract_3rd_signature_collection_pdf':
                $path = 'Applications/Contracts/Third/';
                break;
            case 'work_permit_collection_pdf':
                $path = 'Applications/WorkPermits/';
                    break;
            case 'contract_1st_payment_collection_pdf':
                $path = 'Applications/PaymentReceipts/First/';
                    break;
            case 'contract_2nd_payment_collection_pdf':
                $path = 'Applications/PaymentReceipts/Second/';
                    break;
            case 'contract_3rd_payment_collection_pdf':
                $path = 'Applications/PaymentReceipts/Third/';
                    break;
            case 'application_additonal_attachment':
                $path = 'Applications/AdditonalAttachments/';
                    break;
            case 'client_collection_emp_profile_picture':
                $path = 'Employees/ProfilePictures/';
                    break;
            case 'media_collection_emp_passport':
                $path = 'Employees/Passports/';
                    break;
            case 'media_collection_emp_emirates_id':
                $path = 'Employees/EmiratesIDs/';
                    break;
            case 'media_collection_emp_company_contract':
                $path = 'Employees/CompanyContracts/';
                    break;
            case 'media_collection_emp_personal_visa':
                $path = 'Employees/PersonalVisas/';
                    break;
            case 'media_collection_emp_company_visa':
                $path = 'Employees/CompanyVisas/';
                    break;
            case 'media_collection_emp_uae_gov_agreement':
                $path = 'Employees/UAEGovtAgreements/';
                    break;
            case 'media_collection_emp_noc':
                $path = 'Employees/NOCs/';
                    break;
            case 'media_collection_emp_lease_agreement':
                $path = 'Employees/LeaseAgreements/';
                    break;
            case 'media_collection_emp_confidentiality_agreement':
                $path = 'Employees/ConfidentialityAgreements/';
                    break;
            case 'media_collection_asset_handover':
                $path = 'Employees/AssetHandoverAgreements/';
                    break;
            case 'media_collection_asset_return':
                $path = 'Employees/AssetReturnAgreements/';
                    break;
            case 'media_collection_emp_resignation':
                $path = 'Employees/Resignations/';
                    break;
            case 'media_collection_asset_photo':
                $path = 'Asset/AseetPhotos/';
                    break;
            case 'media_collection_payment_receipt':
                $path = 'Applications/Payments/';
                break;
            case 'media_collection_submission_payment':
                $path = 'Applications/PaymentReceipts/Submission/';
                break;
            case 'media_collection_main_application_hold_letter':
                $path = 'Applications/ApplicationHoldLetters/';
                break;
            case 'media_collection_main_resignation_letter':
                $path = 'Applications/ResignationLetters/';
                break;
            case 'client_residence_visa_copy':
                $path = 'Clients/VisaCopies/';
                break;
            case 'media_collection_main_polish_contract_of_mandate':
                $path = 'Applications/PolishMandateContracts/';
                break;
            case 'media_collection_main_hr_assessment_form':
                    $path = 'Applications/HrAssessmentForms/';
                    break;
            case 'media_collection_main_rcic_assessment_form':
                    $path = 'Applications/RcicAssessmentForms/';
                    break;
            case 'media_procedure_scanned_copy':
                $path = 'Procedures/';
                break;
            case 'media_collection_ticket_attachments':
                    $path = 'Tickets/Attachments';
                    break;
            case 'media_collection_malta_emp_profile_picture':
                $path = 'MaltaEmployees/ProfilePictures/';
                    break;
            case 'media_collection_malta_emp_passport_scanned_copy':
                $path = 'MaltaEmployees/Passports/';
                    break;
            case 'media_collection_malta_emp_police_clearance_certificate':
                $path = 'MaltaEmployees/PoliceClearanceCertificates/';
                    break;
            case 'media_collection_main_application_hold_first_email_reminder':
                $path = 'Clients/AplicationHoldFirstEmailReminders/';
                    break;
            case 'media_collection_main_application_hold_second_email_reminder':
                $path = 'Clients/AplicationHoldSecondEmailReminders/';
                    break;
            case 'media_collection_main_application_hold_third_email_reminder':
                $path = 'Clients/AplicationHoldThirdEmailReminders/';
                    break;
            case 'client_collection_signature':
                $path = 'Clients/signature/';
                    break;
            case 'contract_collection_pdf': 
                $path = 'Applications/Contracts/client_contracts/'; 
                break;
            default:
                $path = 'default/';
                break;
        }

        $path = $path . $media->id . '/';

        return $path;
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . "conversions/";
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . "responsive/";
    }
}

