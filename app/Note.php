<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'description', 
        'created',
        'status',
        'people_id',
        'department_id',
        'note_type_id',
        'subject',
        'is_sent',
        'user_id',
    ];

    public function department()
    {
        return $this->hasOne('App\Department', 'id', 'department_id');
    }

    public function type()
    {
        return $this->hasOne('App\NoteType','id', 'note_type_id');
    }

            /**
     * The sports that belong to the share.
     */
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
