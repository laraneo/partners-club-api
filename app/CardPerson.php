<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardPerson extends Model
{
    protected $fillable = [
        'people_id',
        'titular',
        'ci',
        'card_number',
        'sec_code',
        'expiration_date',
        'card_type_id',
        'bank_id',
    ];

    /**
     * Get the banks record associated with the Card Person.
     */
    public function card()
    {
        return $this->hasOne('App\CardType','id', 'card_type_id');
    }

        /**
     * Get the banks record associated with the Card Person.
     */
    public function bank()
    {
        return $this->hasOne('App\Bank','id', 'bank_id');
    }
}
