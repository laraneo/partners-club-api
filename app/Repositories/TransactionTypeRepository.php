<?php

namespace App\Repositories;

use App\TransactionType;

class TransactionTypeRepository  {
  
    protected $post;

    public function __construct(TransactionType $model) {
      $this->model = $model;
    }

    public function find($id) {
      return $this->model->find($id, [
        'id',
        'description',
        'rate',
        'apply_main',
        'apply_extension',
        'apply_change_user',
        'currency_id',
    ]);
    }

    public function create($attributes) {
      return $this->model->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->model->find($id)->update($attributes);
    }
  
    public function all($perPage) {
      return $this->model->query()->select([
        'id',
        'description',
        'rate',
        'apply_main',
        'apply_extension',
        'apply_change_user',
        'currency_id',
    ])->with(['currency'])->paginate($perPage);
    }

    public function getList() {
      return $this->model->query()->select([
        'id',
        'description',
        'rate',
        'apply_main',
        'apply_extension',
        'apply_change_user',
        'currency_id',
    ])->with(['currency' => function($query){
        $query->select('id', 'description', 'unicode'); 
    }, ])->get();
    }

    public function delete($id) {
     return $this->model->find($id)->delete();
    }

    public function checkRecord($name)
    {
      $data = $this->model->where('description', $name)->first();
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
        $search = $this->model->query()->select([
          'id',
          'description',
          'rate',
          'apply_main',
          'apply_extension',
          'apply_change_user',
          'currency_id',
      ])->with(['currency'])->where('description', 'like', '%'.$queryFilter->query('term').'%')->paginate($queryFilter->query('perPage'));
      }
     return $search;
    }
}