<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmissionStep extends Model
{
    protected $fillable = [
        'description',
        'order',
        'status',
        'admission_phase_id',
    ];
}
