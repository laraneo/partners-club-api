<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    protected $fillable = [
        'name', 
        'price', 
        'description',  
        'photo', 
        'categories_id', 
        'user_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Category', 'categories_id', 'id');
    }
}
