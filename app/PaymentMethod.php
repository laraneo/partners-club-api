<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'description', 
        'card_validate', 
        'is_default',
        'slug'
    ];
}
