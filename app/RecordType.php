<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecordType extends Model
{
    protected $fillable = [
        'description',
        'days',
        'blocked',
    ];
}
