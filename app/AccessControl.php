<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessControl extends Model
{
    protected $fillable = [
        'status',
        'created',
        'location_id',
        'people_id',
        'share_id',
        'guest_id',
    ];

    /**
     * The sports that belong to the share.
     */
    public function location()
    {
        return $this->hasOne('App\Location', 'id', 'location_id');
    }

    /**
     * The sports that belong to the share.
     */
    public function person()
    {
        return $this->hasOne('App\Person', 'id', 'people_id');
    }

    /**
     * The sports that belong to the share.
     */
    public function share()
    {
        return $this->hasOne('App\Share', 'id', 'share_id');
    }

    /**
     * The sports that belong to the share.
     */
    public function guest()
    {
        return $this->hasOne('App\Person', 'id', 'guest_id');
    }
}
