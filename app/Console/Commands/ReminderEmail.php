<?php

namespace App\Console\Commands;

use App\Models\Applicant;
use App\Models\User;
use App\payment;
use App\Models\product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyMail;
use Carbon\Carbon;
use DB;

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
        $pending_Reminders = Applicant::where('first_payment_remaining', '>', 0)->get();
        $data = [];
        foreach ($pending_Reminders as $reminder) {

            $pay_infox = Payment::where('application_id', $reminder->id)
                ->where('paid_amount', $reminder->first_payment_paid)
                ->where('created_at', '>=', '2023-02-01')
                ->first();

            $date = Carbon::parse($pay_infox->payment_date);
            $daysToAdd = 7;
            $startDate = $date->addDays($daysToAdd);
            $endDate = Carbon::parse($pay_infox->payment_date)->addDays(28);
            $now = Carbon::now();
            if (isset($pay_infox) && ($now > $startDate && $now <= $endDate)) {
                $user = User::where('id', $reminder->client_id)
                    ->first();

                $client_email = $user->email;
                $productId = $reminder->destination_id;
                $dataArray = [
                    'product' => product::find($productId)->name,
                    'title' => 'Payment Reminder',
                    'productId' => $productId,
                    'status' => 'reminder'
                ];

                Mail::to($client_email)->send(new NotifyMail($dataArray));
            }
        }

        //return 0;
    }
}
