<?php

namespace App\Repositories;

use App\Parameter;

class ParameterRepository  {
  
    protected $post;

    public function __construct(Parameter $model) {
      $this->model = $model;
    }

    public function find($id) {
      return $this->model->find($id, ['id', 'description', 'parameter', 'value', 'eliminable']);
    }

    public function create($attributes) {
      return $this->model->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->model->find($id)->update($attributes);
    }
  
    public function all($perPage) {
      return $this->model->query()->select(['id', 'description', 'parameter', 'value', 'eliminable'])->paginate($perPage);
    }

    public function getList() {
      return $this->model->query()->select(['id', 'description', 'parameter', 'value', 'eliminable'])->get();
    }

    public function delete($id) {
     return $this->model->find($id)->delete();
    }

    public function checkRecord($name)
    {
      $data = $this->model->where('parameter', $name)->first();
      if ($data) {
        return true;
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
        $search = $this->model->where('description', 'like', '%'.$queryFilter->query('term').'%')->paginate($queryFilter->query('perPage'));
      }
     return $search;
    }

    public function findByParameter($parameter) {
      return $this->model->query()->select(['id', 'description', 'parameter', 'value'])->where('parameter', $parameter)->first();
    }

    public function getLogo() {
      $parameter = $this->model->where('parameter', 'CLIENT_LOGO')->first();
      if($parameter) {
        $image = url('images/'.$parameter->value);
        return array( 'image' => $image);
      }
      return array( 'image' => '');
    }
}