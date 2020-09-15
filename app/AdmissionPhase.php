<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmissionPhase extends Model
{
    protected $fillable = [
        'description',
        'order',
        'status',
    ];
}
