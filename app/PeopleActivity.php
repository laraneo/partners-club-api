<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonActivity extends Model
{
    protected $fillable = [
        'date_from', 
        'date_to',
        'status',
        'people_id',
        'activity_id',
    ];

    public function person()
    {
        return $this->hasOne('App\Person', 'id', 'people_id');
    }

    public function activity()
    {
        return $this->hasOne('App\Activity', 'id', 'activity_id');
    }
}
