<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use GuzzleHttp;

class RequestWeatherController extends Controller
{
    /**
     * Show the weather for the given city.
     *
     * @param  Request
     * @return View
     */
    public function getWeather(Request $request)
    {
        $appid = '88e2bf476f822117752bf6e87fe1e69c';
        $city = $request->requestCityWeather;

        // Caching every repeat request on a city for ten minutes as per recommendation from OpenWeatherMap
        $resBody = Cache::remember("weather-{$city}", 10, function () use ($city, $appid) {
            $client = new GuzzleHttp\Client();
            $res = $client->request('GET', "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$appid}");
            return json_decode((string)$res->getBody());
        });

        // Check if wind direction is set in the response, none seems to mean 0-th degree facing wind.
        if(isset($resBody->wind->deg)) {
            $windDirection = (int)$resBody->wind->deg / 45;
        } else {
            $windDirection = 0;
        }

        // Translate to human readable values for display.
        $directions = ['Northwards', 'Northeastwards', 'Eastwards', 'Southeastwards', 'Southwards', 'Southwestwards', 'Westwards', 'Northwestwards'];
        $windDirection = $directions[$windDirection];

        return view('display', ['requestedCity' => $city, 'weatherArray'=>$resBody, 'windDirection'=>$windDirection]);
    }


    /**
     * Sign the user up in the database for alerts.
     *
     * @param  Request
     * @return View
     */
    public function createAlert(Request $request)
    {

        $email = $request->requestAlertEmail;
        $city = $request->requestAlertCity;

        $insert = DB::table('requested_alerts')->insertGetId([
            'email'       => $email,
            'city'        => $city,
            'created_at'  => Carbon::now()
        ]);

        return view('signedup');
    }
}