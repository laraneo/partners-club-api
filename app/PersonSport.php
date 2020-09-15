<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonSport extends Model
{
    protected $fillable = [
        'people_id', 
        'sports_id', 
    ];
}
