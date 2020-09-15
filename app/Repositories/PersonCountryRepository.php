<?php

namespace App\Repositories;

use App\PersonCountry;

class PersonCountryRepository  {

    public function __construct(PersonCountry $model) {
      $this->model = $model;
    }

    public function find($peopleId, $professionId) {
      $data = $this->model->query()->where('people_id', $peopleId)->where('countries_id', $professionId)->first();
      if($data) {
          return true;
      }
      return false;
    }

    public function findPartner($id) {
      $data = $this->model->query()->where('people_id', $id)->first();
      if($data) {
          return true;
      }
      return false;
    }

    public function create($attributes) {
      return $this->model->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->model->find($id)->update($attributes);
    }
  
    public function all() {
      return $this->model->all();
    }

    public function delete($id) {
     return $this->model->find($id)->delete();
    }

    public function deleteRegistersbyPerson($id) {
        return $this->model->where('people_id', $id)->delete();
       }

}