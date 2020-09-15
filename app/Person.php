<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasApiTokens;
    
    protected $fillable = [
        'name', 
        'last_name',
        'name2',
        'last_name2',
        'rif_ci', 
        'passport', 
        'card_number', 
        'expiration_date', 
        'birth_date', 
        'representante', 
        'picture', 
        'id_card_picture', 
        'address', 
        'telephone1', 
        'telephone2', 
        'phone_mobile1', 
        'phone_mobile2', 
        'primary_email', 
        'secondary_email', 
        'fax',
        'city',
        'state',
        'type_person',
        'postal_code',
        'status_person_id',
        'marital_statuses_id',
        'gender_id',
        'countries_id',
        'isPartner',
        'user',
        'date',
        'status',
        'company_person_id'
    ];

        /**
     * The sports that belong to the share.
     */
    public function company()
    {
        return $this->hasOne('App\Person', 'id', 'company_person_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function statusPerson()
    {
        return $this->belongsTo('App\StatusPerson', 'status_person_id', 'id');
    }
    
   /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function maritalStatus()
   {
       return $this->belongsTo('App\MaritalStatus', 'marital_statuses_id', 'id');
   }

      /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function gender()
    {
        return $this->belongsTo('App\Gender', 'gender_id', 'id');
    }

          /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function country()
    {
        return $this->belongsTo('App\Country', 'countries_id', 'id');
    }

    /**
     * The professions that belong to the person.
     */
    public function professions()
    {
        return $this->belongsToMany('App\Profession', 'person_professions', 'people_id', 'profession_id');
    }

    /**
     * The nationalities that belong to the person.
     */
    public function nacionalities()
    {
        return $this->belongsToMany('App\Nacionality', 'person_nationalities', 'people_id', 'nationalities_id');
    }

    /**
     * The sports that belong to the person.
     */
    public function sports()
    {
        return $this->belongsToMany('App\Sport', 'person_sports', 'people_id', 'sports_id');
    }

    /**
     * The sports that belong to the person.
     */
    public function family()
    {
        return $this->belongsToMany('App\Person', 'person_relations', 'base_id', 'related_id');
    }

        /**
     * The credit cards that belong to the person.
     */
    public function creditCards()
    {
        return $this->hasMany('App\CardPerson', 'people_id', 'id');
    }

        /**
     * The sports that belong to the person.
     */
    public function shares()
    {
        return $this->hasMany('App\Share','id_persona', 'id');
    }

            /**
     * The sports that belong to the person.
     */
    public function relationship()
    {
        return $this->hasOne('App\PersonRelation','related_id', 'id');
    }

    /**
     * The countries that belong to the person.
     */
    public function countries()
    {
        return $this->belongsToMany('App\Country', 'person_countries', 'people_id', 'countries_id');
    }

    /**
     * The lockers that belong to the person.
     */
    public function lockers()
    {
        return $this->belongsToMany('App\Locker', 'person_lockers', 'people_id', 'locker_id');
    }

}
