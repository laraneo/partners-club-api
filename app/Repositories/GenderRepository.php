<?php

namespace App\Repositories;

use App\Gender;

class GenderRepository  {

    public function __construct(Gender $model) {
      $this->model = $model;
    }

    public function find($id) {
      return $this->model->find($id);
    }

    public function create($attributes) {
      return $this->model->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->model->find($id)->update($attributes);
    }
  
    public function all() {
      return $this->model->query()->select(['id', 'description'])->get();
    }

    public function delete($id) {
     return $this->model->find($id)->delete();
    }

    public function checkRecord($name)
    {
      $response = $this->model->where('description', $name)->first();
      if ($response) {
        return $response;
      }
      return false; 
    }

        /**
     * get banks by query params
     * @param  object $queryFilter
    */
    public function search($queryFilter) {
      $search;
      if($queryFilter->query('term') === null) {
        $search = $this->model->all();  
      } else {
        $search = $this->model->where('description', 'like', '%'.$queryFilter->query('term').'%')->get();
      }
     return $search;
    }
}