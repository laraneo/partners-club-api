<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WidgetRole extends Model
{
    protected $fillable = [
        'widget_id',
        'role_id',
    ];
}
