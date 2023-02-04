<?php

namespace App\Console\Commands;

use App\Models\notifications;
use Illuminate\Console\Command;
use Carbon\Carbon;

class ClearNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'week:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete notifications older than a week';

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
        notifications::where('created_at', '<', Carbon::now())->delete();
        // notifications::where('created_at', '<', Carbon::now()->subDays(10))->delete();

        //return 0;
    }
}
