<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShareType extends Model
{
    protected $fillable = [
        'code',
        'description',
        'access'
    ];
}
