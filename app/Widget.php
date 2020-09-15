<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function widgetRole()
    {
        return $this->hasMany('App\WidgetRole', 'widget_id', 'id');
    }

        /**
     * The lockers that belong to the widget.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'widget_roles', 'widget_id', 'role_id');
    }
}
