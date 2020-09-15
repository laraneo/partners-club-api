<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [      
        'name', 
        'slug', 
        'description', 
        'route',
        'icon',
        'parent',
        'order',
        'enabled',
        'menu_id',
        'menu_item_icon_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function roleMenu()
    {
        return $this->hasMany('App\MenuItemRole', 'menu_item_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'menu_item_roles', 'menu_item_id', 'role_id');
    }


    public function icons()
    {
        return $this->hasOne('App\MenuItemIcon', 'id', 'menu_item_icon_id');
    }

    public function father()
    {
        return $this->hasOne('App\Menu', 'id', 'menu_id');
    }

    public function main()
    {
        return $this->hasOne('App\MenuItem', 'id', 'parent');
    }
}
