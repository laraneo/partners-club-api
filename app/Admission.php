<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $fillable = [
        'date_start',
        'share_number_assigned',
        'status',
        'share_movement_id',
        'people_id',
    ];
}
