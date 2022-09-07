<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'product_id',
        'first_name',
        'middle_name',
        'surname',
        'email',
        'personal_phone_number',
        'country',
        'job_type',
        'resume',
        'coupon_code',
        'dob',
        'place_birth',
        'country_birth',
        'citizenship',
        'sex',
        'civil_status',
        'passport_number',
        'passport_date_issue',
        'passport_date_expiry',
        'issued_by',
        'passport',
        'phone_number',
        'home_country',
        'state',
        'city',
        'postal_code',
        'address_1',
        'address_2',
        'current_residance_country',
        'current_residance_mobile',
        'residence_id',
        'id_validity',
        'residence_copy',
        'visa_copy',
        'current_job',
        'work_state',
        'work_city',
        'work_postal_code',
        'work_street_number',
        'company_name',
        'employer_phone_number',
        'employer_email',
        'is_schengen_visa_issued',
        'schengen_visa',
        'is_fingerprint_collected', 
        'embassy_country',
        'status'
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id');
    }
}
