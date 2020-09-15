<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    protected $fillable = [
        'description',
        'parameter',
        'value',
        'eliminable',
    ];
}
