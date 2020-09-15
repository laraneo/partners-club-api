<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'description', 
        'status',
        'activity_type',
    ];

    public function type()
    {
        return $this->hasOne('App\ActivityType', 'id', 'activity_type');
    }
}
