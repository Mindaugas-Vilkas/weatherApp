@extends('base')

@section('content')
    <form action="/get-weather" method="get">
        <label for="requestCityWeather">Enter city name</label>
        <input name="requestCityWeather" id="requestCityWeather" type="text">
    </form>
    <br />
    <br /> <br />
    <br />
    <h3>Sign up to be alerted about dangerous wind speeds</h3>
    <form action="/alert" method="post">
        <label for="requestAlertCity">Enter city name</label>
        <input name="requestAlertCity" id="requestAlertCity" type="text">
        <br />
        <br />
        <label for="requestAlertEmail">Enter your email</label>
        <input name="requestAlertEmail" id="requestAlertEmail" type="text">
        <br />
        <br />
        <input type="submit" value="Sign up">
    </form>
    <br />
    <br /> <br />
    <br />
    <form>
        <label for="fakeIt">Fake it ?</label>
        <input name="fakeIt" id="fakeIt" value="fakeIt" type="submit">
    </form>
@stop