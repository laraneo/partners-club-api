<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SharePermitMovement extends Model
{
    protected $fillable = [
        'desc',
        'days',
        'share_id',
        'share_permit_movements_types_id',
        'user_id',
        'status',
        'date_cancelled',
        'userid_cancelled',
    ];

    public function share()
    {
        return $this->hasOne('App\Share', 'id', 'share_id');
    }

    public function sharePermitMovementsTypes()
    {
        return $this->hasOne('App\SharePermitMovementsType', 'id', 'share_permit_movements_types_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
