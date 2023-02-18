<?php

namespace App\Console\Commands;

use App\Models\QuickbookWebErrorLogger;
use Illuminate\Console\Command;
use Carbon\Carbon;

class ClearQuickbookErrorLogger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:quickbookerror';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'to clear quickbook error logger db table';

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
        QuickbookWebErrorLogger::where('created_at', '<', Carbon::now()->subDays(30))->delete();
    }
}
