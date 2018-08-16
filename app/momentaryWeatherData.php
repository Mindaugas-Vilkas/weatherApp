<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class momentaryWeatherData extends Model
{
    protected $fillable = ['weatherJson'];
}
