<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonCountry extends Model
{
    protected $fillable = [
        'people_id', 
        'countries_id', 
    ];
}
