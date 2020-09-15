<?php

namespace App;

use Kodeine\Acl\Traits\HasPermission;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasPermission;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function userRoles()
    {
        return $this->hasMany('App\RoleUser', 'role_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function widgetRoles()
    {
        return $this->hasMany('App\WidgetRole', 'role_id', 'id');
    }

        
    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function menuItemRoles()
    {
        return $this->hasMany('App\MenuItemRole', 'role_id', 'id');
    }

        /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function permissionRoles()
    {
        return $this->hasMany('App\PermissionRole', 'role_id', 'id');
    }

    
}
