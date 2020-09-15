<?php

namespace App\Repositories;

use App\Country;

class CountryRepository  {
  
    public function __construct(Country $country) {
      $this->country = $country;
    }

    public function find($id) {
      return $this->country->find($id);
    }

    public function create($attributes) {
      return $this->country->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->country->find($id)->update($attributes);
    }
  
    public function all() {
      return $this->country->all();
    }

    public function delete($id) {
     return $this->country->find($id)->delete();
    }

    public function checkcountry($name)
    {
      $country = $this->country->where('description', $name)->first();
      if ($country) {
        return true;
      }
      return false; 
    }

        /**
     * get countrys by query params
     * @param  object $queryFilter
    */
    public function search($queryFilter) {
      $search;
      if($queryFilter->query('term') === null) {
        $search = $this->country->all();  
      } else {
        $search = $this->country->where('description', 'like', '%'.$queryFilter->query('term').'%')->get();
      }
     return $search;
    }
}