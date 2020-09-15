<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonProfession extends Model
{
    protected $fillable = [
        'people_id', 
        'profession_id', 
    ];
}
