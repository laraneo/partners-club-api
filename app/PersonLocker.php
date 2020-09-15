<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonLocker extends Model
{
    protected $fillable = [
        'people_id', 
        'locker_id', 
    ];

    /**
     * The locker that belong to the person.
     */
    public function locker()
    {
        return $this->hasOne('App\Locker','id', 'locker_id');
    }

}
