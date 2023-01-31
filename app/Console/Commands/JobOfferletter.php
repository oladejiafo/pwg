<?php

namespace App\Console\Commands;

use App\Helpers\pdfBlock;
use App\Models\Applicant;
use App\Models\User;
use App\Models\payment;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\JobOfferLetterMail;
use Carbon\Carbon;

class JobOfferLetter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:offerletter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Applicant Job Offer Letter';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::now()->format('Y-m-d');;
        $applicants = Payment::join('applications', 'payments.application_id', 'applications.id')
            ->where('applications.first_payment_status', 'PAID')
            ->where('payments.payment_type','FIRST')
            ->where('applications.is_job_offer_letter_delivered', 0)
            ->select('payments.created_at', 'applications.id', 'applications.client_id')
            ->get();
        foreach($applicants as $applicant){
            $paiddate = $applicant['created_at']->addDays(7)->format('Y-m-d');
            if($paiddate == $today){
                pdfBlock::jobLetter($applicant->id,$applicant->client_id,$applicant->created_at);
                $client = User::find($applicant->client_id);
                $application = Applicant::find($applicant->id);
                $media = (isset($application->getMedia(Applicant::$media_collection_main_job_offer_letter)[0])) ? $application->getMedia(Applicant::$media_collection_main_job_offer_letter)[0]->getFullUrl() : null;
                Mail::to($client->email)->send(new JobOfferLetterMail($media));
                $application->is_job_offer_letter_delivered = 1;
                $application->save();
            }
        }
    }

}
