<?php

namespace App\Repositories;

use App\PersonException;

class PersonExceptionRepository  {
  
    protected $post;

    public function __construct(PersonException $model) {
      $this->model = $model;
    }

    public function find($id) {
      return $this->model->find($id, ['id', 'rif_ci', 'name', 'last_name', 'status']);
    }

    public function create($attributes) {
      return $this->model->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->model->find($id)->update($attributes);
    }
  
    public function all($perPage) {
      return $this->model->query()->select(['id', 'rif_ci', 'name', 'last_name', 'status'])->paginate($perPage);
    }

    public function getList() {
      return $this->model->query()->select(['id', 'rif_ci', 'name', 'last_name', 'status'])->get();
    }

    public function delete($id) {
     return $this->model->find($id)->delete();
    }

    public function checkRecord($name)
    {
      $data = $this->model->where('rif_ci', $name)->first();
      if ($data) {
        return true;
      }
      return false; 
    }

     public function getStatistics() {
     $count = $this->model->where('status', 1)->count();
     return array('count' => $count);
    }
}