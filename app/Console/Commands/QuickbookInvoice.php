<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\payment;
use App\Helpers\Quickbook;
use App\Helpers\users as UserHelper;
use Carbon\Carbon;
use Exception;

class QuickbookInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quickbook:invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To update missed quickbook entries';

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
        try {
            $payments = Payment::whereNotNull('bank_reference_no')
                ->whereNotNull('transaction_id')
                ->whereNull('invoice_no')
                // ->where( 'created_at', '>', Carbon::now()->subDays(2))
                ->where('created_at', '>=', '2023-02-01')
                ->get();
                Quickbook::updateTokenAccess();
            foreach ($payments as $payment) {
                Quickbook::createInvoice($payment->payment_type, $payment->id);
            }
        } catch (Exception $e) {
            UserHelper::webLogger($e);
        }
    }
}
