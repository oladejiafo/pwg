<?php

namespace App\Console\Commands;

use App\Helpers\users as UserHelper;
use App\Models\Applicant;
use App\Models\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyMail;

class SendWorkPermit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:workPermit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'notification of workpermit received';

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
        $applicants = Applicant::where('applications.created_at', '>=', '2023-02-01')
            ->where('is_workpermit_delivered', 0)
            ->where('work_permit_status', "WORK_PERMIT_RECEIVED")
            ->get();
        foreach ($applicants as $applicant) {
            $response = [
                'fileUrl' => '',
                'FileExist' => false
            ];
            if (strtoupper($applicant->first_payment_status) == 'PAID' && $applicant->work_permit_status == "WORK_PERMIT_RECEIVED") {
                $client = new \GuzzleHttp\Client();
                $res = $client->request('POST', config('app.admin_url_local') . '/api/get-work-permit', [
                    'form_params' => [
                        'pricing_plan_id' => $applicant['pricing_plan_id'],
                        'client_id' => $applicant['client_id']
                    ]
                ]);
    
                $fileData = $res->getBody()->getContents();
                $file = json_decode($fileData);
                $response = [
                    'fileUrl' => $file->fileUrl,
                    'FileExist' => $file->status
                ];
            }
            if (isset($response['FileExist'])) {
                if (strtoupper($applicant->first_payment_status) == 'PAID' && $applicant->work_permit_status == "WORK_PERMIT_RECEIVED" && $response['FileExist']) {
                    $dataArray = [
                        'title' => 'Your work permit has been received',
                        'status' => 'workpermit',
                        'productId' => $applicant['destination_id'],
                    ];
                    $email = Client::find($applicant['client_id'])->email;
                    Mail::to($email)->send(new NotifyMail($dataArray));
                    $updateApplicant = Applicant::find($applicant['id']);
                    $updateApplicant->is_workpermit_delivered = 1;
                    $updateApplicant->save();
                }
            }
        }
    }
}
