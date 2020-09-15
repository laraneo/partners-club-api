<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardType extends Model
{
    protected $fillable = [
        'description',
        'logo',
        'equivalent_code',
        'slug'
    ];
}
