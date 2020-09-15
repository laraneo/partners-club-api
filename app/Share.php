<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    protected $fillable = [
        'share_number',
        'father_share_id',
        'status',
        'payment_method_id',
        'card_people1',
        'card_people2',
        'card_people3',
        'id_persona',
        'id_titular_persona',
        'id_factura_persona',
        'id_fiador_persona',
        'share_type_id',
        'permit',
    ];

    /**
     * The sports that belong to the share.
     */
    public function fatherShare()
    {
        return $this->hasOne('App\Share', 'id', 'father_share_id');
    }

    /**
     * The sports that belong to the share.
     */
    public function tarjetaPrimaria()
    {
        return $this->hasOne('App\CardPerson', 'id', 'card_people1');
    }

    /**
     * The sports that belong to the share.
     */
    public function tarjetaSecundaria()
    {
        return $this->hasOne('App\CardPerson', 'id', 'card_people2');
    }

        /**
     * The sports that belong to the share.
     */
    public function tarjetaTerciaria()
    {
        return $this->hasOne('App\CardPerson', 'id', 'card_people3');
    }


    /**
     * The sports that belong to the share.
     */
    public function paymentMethod()
    {
        return $this->hasOne('App\PaymentMethod', 'id', 'payment_method_id');
    }

    /**
     * The person that belong to the share.
     */
    public function partner()
    {
        return $this->hasOne('App\Person', 'id', 'id_persona');
    }

    /**
     * The titular that belong to the share.
     */
    public function titular()
    {
        return $this->hasOne('App\Person', 'id', 'id_titular_persona');
    }

    /**
     * The factura that belong to the share.
     */
    public function facturador()
    {
        return $this->hasOne('App\Person', 'id', 'id_factura_persona');
    }

    /**
     * The fiador that belong to the share.
     */
    public function fiador()
    {
        return $this->hasOne('App\Person', 'id', 'id_fiador_persona');
    }

        /**
     * The sports that belong to the share.
     */
    public function shareType()
    {
        return $this->hasOne('App\ShareType', 'id', 'share_type_id');
    }

    /**
     * The professions that belong to the person.
     */
    public function shareMovements()
    {
        return $this->hasMany('App\ShareMovement');
    }
}
