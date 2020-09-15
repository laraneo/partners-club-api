<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    protected $fillable = [
        'description',
        'rate',
        'apply_main',
        'apply_extension',
        'apply_change_user',
        'currency_id',
    ];


    public function currency()
    {
        return $this->hasOne('App\Currency','id', 'currency_id');
    }
}
