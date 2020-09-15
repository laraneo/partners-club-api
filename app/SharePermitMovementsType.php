<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SharePermitMovementsType extends Model
{
    protected $fillable = [
        'desc',
        'days',
        'status',
    ];
}
