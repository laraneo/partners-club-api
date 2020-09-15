<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $fillable = [
        'description', 
        'ref_code',
        'date',
        'status',
        'people_id',
        'referral_type_id',
    ];

    public function person()
    {
        return $this->hasOne('App\Person', 'id', 'people_id');
    }
}
