<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AlertChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alert:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a request to the weather API on an interval to check for dangerous wind speed';

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
     * @return mixed
     */
    public function handle()
    {
        $city = DB::table('requested_locations')->orderBy('id', 'desc')->first()->city;

        return null;
    }
}
