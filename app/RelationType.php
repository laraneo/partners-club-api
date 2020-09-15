<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelationType extends Model
{
    protected $fillable = [
        'description',
        'inverse_relation',
    ];
}
