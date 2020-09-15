<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonAdmission extends Model
{
    protected $fillable = [
        'comments',
        'status',
        'status',
        'attachment1',
        'descriptionAttachment1',
        'attachment2',
        'descriptionAttachment2',
        'attachment3',
        'descriptionAttachment3',
        'attachment4',
        'descriptionAttachment4',
        'attachment5',
        'descriptionAttachment5',
        'user_verified',
        'date_verified',
        'admission_id',
        'admission_step_id',
        'people_id',
    ];
}
