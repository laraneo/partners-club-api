<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locker extends Model
{
    protected $fillable = [
        'description',
        'locker_location_id',
    ];

          /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function location()
    {
        return $this->belongsTo('App\LockerLocation', 'locker_location_id', 'id');
    }

}
