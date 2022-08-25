<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('country')->nullable();
            $table->string('job_type')->nullable();
            $table->string('resume')->nullable();
            $table->string('agent_phone_number')->nullable();
            $table->string('agent_name')->nullable();
            $table->string('referral_first_name')->nullable();
            $table->string('referral_last_name')->nullable();
            $table->string('coupon_code')->nullable();
            $table->date('dob')->nullable();
            $table->string('place_birth')->nullable();
            $table->string('country_birth')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('sex')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('passport_number')->nullable();
            $table->date('passport_date_issue')->nullable();
            $table->date('passport_date_expiry')->nullable();
            $table->string('issued_by')->nullable();
            $table->string('passport')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('home_country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->text('address_1')->nullable();
            $table->text('address_2')->nullable();
            $table->string('current_residance_country')->nullable();
            $table->string('current_residance_mobile')->nullable();
            $table->string('residence_id')->nullable();
            $table->date('id_validity')->nullable();
            $table->string('residence_copy')->nullable();
            $table->string('visa_copy')->nullable();
            $table->string('current_job')->nullable();
            $table->string('work_state')->nullable();
            $table->string('work_city')->nullable();
            $table->string('work_postal_code')->nullable();
            $table->string('work_street_number')->nullable();
            $table->string('company_name')->nullable();
            $table->string('employer_phone_number')->nullable();
            $table->string('employer_email')->nullable();
            $table->string('is_schengen_visa_issued')->comment('is schengen visa issued in past 5 years')->nullable();
            $table->string('schengen_visa')->nullable();
            $table->string('is_fingerprint_collected')->comment('is fingerprint collected for schengen visa application')->nullable();
            $table->string('embassy_country')->nullable();
            $table->string('applicant_status')->default('pending')->comment('1:referal; 2:payment; 3:applcant; 4:applicant details; 5:applicant review');
            $table->string('referrer_code')->nullable();
            $table->string('agent_code')->nullable();
            $table->integer('visa_type')->comment('1:bluepinkjob; 2:whitejob; 3:familypackage')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicants');
    }
}
