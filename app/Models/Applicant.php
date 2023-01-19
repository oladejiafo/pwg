<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Applicant extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $table = 'applications';

    protected $fillable = [
        'client_id',
        'assigned_agent_id',
        'branch_id',
        'pricing_plan_id',
        'destination_id',
        'job_id',
        'referrer_application_id',
        'referrer_discount_amount',
        'sales_agent_name_by_client',
        'sales_agent_phone_number_by_client',
        'referrer_name_by_client',
        'referrer_passport_number_by_client',
        'status',
        'work_permit_applied_position',
        'work_permit_official_fee_status',
        'work_permit_status',
        'voivodeship_office',
        'assigned_hr_specialist',
        'work_permit_category',
        'processing_status',
        'applied_country',
        'applied_position',
        'is_white_collar_job',
        'blue_white_collar_job_verified',
        'is_rejected',
        'first_payment_status',
        'submission_payment_status',
        'second_payment_status',
        'third_payment_status',
        'contract'
    ];


    public static $media_collection_main_signture = 'client_collection_signature';
    public static $media_collection_main_work_permit = 'work_permit_collection_pdf';
    public static $media_client_collection_contracts = 'client_collection_contracts';

    public static $media_collection_main_1st_signature = 'contract_1st_signature_collection_pdf';
    public static $media_collection_main_submission_signature = 'contract_submission_signature_collection_pdf';
    public static $media_collection_main_2nd_signature = 'contract_2nd_signature_collection_pdf';
    public static $media_collection_main_3rd_signature = 'contract_3rd_signature_collection_pdf';

    public static $media_collection_main_1st_payment = 'contract_1st_payment_collection_pdf';
    public static $media_collection_main_2nd_payment = 'contract_2nd_payment_collection_pdf';
    public static $media_collection_main_3rd_payment = 'contract_3rd_payment_collection_pdf';
    
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('work_permit_collection_pdf')->singleFile();
        $this->addMediaCollection('contract_1st_payment_collection_pdf');
        $this->addMediaCollection('contract_2nd_payment_collection_pdf');
        $this->addMediaCollection('contract_3rd_payment_collection_pdf');
        $this->addMediaCollection('client_collection_contracts');
        $this->addMediaCollection('contract_1st_signature_collection_pdf')->singleFile();
        $this->addMediaCollection('contract_submission_signature_collection_pdf');
        $this->addMediaCollection('contract_2nd_signature_collection_pdf')->singleFile();
        $this->addMediaCollection('contract_3rd_signature_collection_pdf')->singleFile();

    }

}
