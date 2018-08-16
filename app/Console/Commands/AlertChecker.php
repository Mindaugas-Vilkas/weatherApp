<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use GuzzleHttp;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


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
     * @throws *
     * @return void
     */
    public function handle()
    {
//        Storage::disk('local')->put('debug.txt', "Execution \n");
        $appid = '88e2bf476f822117752bf6e87fe1e69c';
        $city = DB::table('dangerous')->first()->city;
        $dangerous = DB::table('dangerous')->first()->dangerous;

//        throw new \Error($city);

        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$appid}");

        $wind = json_decode((string)$res->getBody())->wind->speed;
        $wind = 9001; // Debug
        if($wind >= 10){

            foreach(DB::table('requested_alerts')->get() as $q){
                Mail::send('mail', ['content' => 'Dangerous winds of over 10 m/s, try to stay indoors.'], function ($message) use ($q){
                    $message->from('weatherApp@pretendmail.com', 'Weather App');
                    $message->to($q->email);
                });
            }

            DB::table('dangerous')->where('id', 1)->update(['dangerous' => 1, 'city' => $city]);

        } elseif($wind < 10 && $dangerous) {

            foreach(DB::table('requested_alerts')->get() as $q){
                Mail::send('mail', ['content' => 'Dangerous winds have subsided.'], function ($message) use ($q){
                    $message->from('weatherApp@pretendmail.com', 'Weather App');
                    $message->to($q->email);
                });
            }

            DB::table('dangerous')->where('id', 1)->update(['dangerous' => 0, 'city' => $city]);

        }
    }
}
