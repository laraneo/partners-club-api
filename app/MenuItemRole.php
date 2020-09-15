<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuItemRole extends Model
{
    protected $fillable = [
        'menu_item_id',
        'role_id',
    ];
    
}
