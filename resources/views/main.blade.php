@extends('base')

@section('content')
    <form action="/get-weather" method="post">
        <label for="requestWeather">Enter city name</label>
        <input name="requestWeather" id="requestWeather" type="text">
    </form>
@stop