<?php

namespace App\Repositories;

use App\PersonRelation;

class PersonRelationRepository  {

    public function __construct(PersonRelation $model) {
      $this->model = $model;
    }

    public function find($id) {
      return $this->model->find($id);
    }

    public function create($attributes) {
      return $this->model->create($attributes);
    }

    public function update($id, array $attributes) {
      $attr = [ 'status' => $attributes['status']];
      return $this->model->query()->where('related_id',$id)->update($attr);
    }

    public function updateRelation($id, array $attributes) {
      $attr = [ 'status' => $attributes['status']];
      return $this->model->query()->where('related_id',$id)->update($attr);
    }
  
    public function all() {
      return $this->model->all();
    }

    public function delete($id) {
     return $this->model->find($id)->delete();
    }

    public function removeRelation($request) {
      return $this->model->where('base_id', $request['base'])->where('related_id', $request['id'])->delete();
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
     * get persons by query params
     * @param  object $queryFilter
    */
    public function search($queryFilter) {
      $search;
      if($queryFilter->query('term') === null) {
        $search = $this->model->all();  
      } else {
        $search = $this->model->where('name', 'like', '%'.$queryFilter->query('term').'%')->get();
      }
     return $search;
    }

            /**
     * get persons by family params
     * @param  object $queryFilter
    */
    public function searchPersonsByFamily($queryFilter) {
      $search;
      if($queryFilter->query('term') === null) {
        $search = $this->model->all();  
      } else {
        $search = $this->model->where('name', 'like', '%'.$queryFilter->query('term').'%')->get();
      }
     return $search;
    }

    public function findPartner($id)
    {
      return $this->model->where('related_id', $id)->first();
    }
}