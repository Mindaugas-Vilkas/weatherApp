<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use GuzzleHttp;

class RequestWeatherController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  Request
     * @return View
     */
    public function getWeather(Request $request)
    {
        $appid = '88e2bf476f822117752bf6e87fe1e69c';
        $city = $request->requestCityWeather;
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$appid}");
        $resBody = json_decode((string)$res->getBody());

        if(isset($resBody->wind->deg)){
            $windDirection = (int)$resBody->wind->deg / 45;
        } else {
            $windDirection = 0;
        }

        $directions = ['Northwards', 'Northeastwards', 'Eastwards', 'Southeastwards', 'Southwards', 'Southwestwards', 'Westwards', 'Northwestwards'];
        $windDirection = $directions[$windDirection];

        return view('display', ['requestedCity' => $city, 'weatherArray'=>$resBody, 'windDirection'=>$windDirection]);
    }

    public function createAlert() {



        return view('signedup');
    }
}