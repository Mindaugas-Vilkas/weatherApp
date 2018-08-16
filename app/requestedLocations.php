<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class requestedLocations extends Model
{
    protected $fillable = ['email', 'city'];
}
