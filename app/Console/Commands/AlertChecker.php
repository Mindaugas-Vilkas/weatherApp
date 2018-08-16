<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use GuzzleHttp;


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
        $appid = '88e2bf476f822117752bf6e87fe1e69c';
        $city = DB::table('dangerous')->first()->city;

        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$appid}");

        $wind = json_decode((string)$res->getBody())->wind->speed;
        if($wind >= 10){
            //Sendmail

            DB::table('dangerous')->where('id', 1)->update(['dangerous' => 1, 'city' => $city]);
        } elseif($wind < 10) {
            //Sendmail
        }

        return null;
    }
}
