<?php

namespace App;

use Kodeine\Acl\Traits\HasRole;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasRole;
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function permissionRoles()
    {
        return $this->hasMany('App\PermissionRole', 'permission_id', 'id');
    }

}
