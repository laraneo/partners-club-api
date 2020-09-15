<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShareMovement extends Model
{
    protected $fillable = [
        'description',
        'rate',
        'number_sale_price',
        'number_procesed',
        'created',
        'share_id',
        'transaction_type_id',
        'people_id',
        'id_titular_persona',
        'currencie_id',
        'currency_rate_id',
        'currency_sale_price_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function share()
    {
        return $this->belongsTo('App\Share', 'share_id', 'id');
    }
    

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction()
    {
        return $this->belongsTo('App\TransactionType', 'transaction_type_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo('App\Currency', 'currencie_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rateCurrency()
    {
        return $this->belongsTo('App\Currency', 'currency_rate_id', 'id');
    }

        /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function saleCurrency()
    {
        return $this->belongsTo('App\Currency', 'currency_sale_price_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partner()
    {
        return $this->belongsTo('App\Person', 'people_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function titular()
    {
        return $this->belongsTo('App\Person', 'id_titular_persona', 'id');
    }
}
