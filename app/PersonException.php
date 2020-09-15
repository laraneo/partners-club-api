<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonException extends Model
{
    protected $fillable = [
        'rif_ci',
        'name',
        'last_name',
        'status',
    ];
}
