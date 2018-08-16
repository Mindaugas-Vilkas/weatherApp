<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('main');
});

Route::post('/get-weather', 'RequestWeatherController@getWeather');

//route::post('/get-weather', function(Request $request) {
//
//
//
//    return view('display')->with(['request' => $request->all(), 'weatherJson' => '{"pretend":"I\'m", "JSON":"OK?"}']);
//});