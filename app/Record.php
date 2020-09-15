<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
        'description',
        'created',
        'days',
        'blocked',
        'expiration_date',
        'file1',
        'file2',
        'file3',
        'file4',
        'file5',
        'record_type_id',
        'people_id',
        'user_id',
        'userupdate_id',
    ];

    /**
     * The sports that belong to the share.
     */
    public function type()
    {
        return $this->hasOne('App\RecordType', 'id', 'record_type_id');
    }

        /**
     * The sports that belong to the share.
     */
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
