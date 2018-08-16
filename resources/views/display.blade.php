@extends('base')

@section('content')
    <section>
        <h2>Displaying weather for {{$requestedCity}}: </h2>
        <p>Temperature: {{ $weatherArray->main->temp - 273.15 }}</p>
        <p>Cloud coverage: {{ $weatherArray->weather[0]->description  }}</p>
        <p>Wind direction: {{ $windDirection }}</p>
        <p>Wind speed: {{ $weatherArray->wind->speed }}</p>
    </section>
@stop