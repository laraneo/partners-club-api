<?php

namespace App\Repositories;

use App\MenuItemIcon;

class MenuItemIconRepository  {
  
    protected $post;

    public function __construct(MenuItemIcon $model) {
      $this->model = $model;
    }

    public function find($id) {
      return $this->model->find($id, [
        'id',
        'name', 
        'slug', 
        'description',
        'import',
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
        'name', 
        'slug', 
        'description',
        'import',
    ])->paginate($perPage);
    }

    public function getList() {
      return $this->model->query()->select([
        'id',
        'name', 
        'slug', 
        'description',
        'import',
    ])->get();
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
        $search = $this->model->where('description', 'like', '%'.$queryFilter->query('term').'%')->paginate($queryFilter->query('perPage'));
      }
     return $search;
    }
}