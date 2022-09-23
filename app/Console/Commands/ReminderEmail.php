<?php

namespace App\Console\Commands;
use App\Models\Applicant;
use App\Models\User;
use App\Models\payment;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyMail;
use Carbon\Carbon;

class ReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invoice Reminder Emails';

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
        $pending_Reminders = Applicant::where('first_payment_remaining','>',0)->get();
        
        $data = [];

        foreach ($pending_Reminders as $reminder){
            $pay_info = Payment::where('application_id', $reminder->id)
                ->where('paid_amount', $reminder->first_payment_paid)
                ->where('payment_date', '<', Carbon::now()->subDays(15))
                ->first();

            if(isset($pay_info)) 
            {
                $user = User::where('id', $reminder->client_id)
                    ->first();
                    
                $client_email = $user->email;
                $message = "Hello " . $user->name .", Here is an automated reminder about your pending payment of ".$reminder->first_payment_remaining.", that will be due in 5 days time. Kindly login to the PWG Client portal and make payment vian 'My Application' link, so that your VISA application can be processed.";


                $dataArray = [
                    'title' => 'Payment Reminder from PWG Group',
                    'body' => $message,
                ];

                Mail::to($client_email)->send(new NotifyMail($dataArray));
            }
        }

        //return 0;
    }
}
