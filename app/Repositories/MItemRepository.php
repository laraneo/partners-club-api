<?php

namespace App\Repositories;

use App\MenuItem;

class MItemRepository  {
  
    public function __construct(MenuItem $model) {
      $this->model = $model;
    }

    public function findMenuItem($menuItem, $menu) {
        return $this->model->query()->where('id', $menuItem)->where('menu_id', $menu)->first();
    }

    public function find($id) {
      return $this->model->find($id, [
          'id',
          'name', 
          'slug', 
          'description', 
          'route',
          'icon',
          'parent',
          'order',
          'enabled',
          'menu_id',
          ]);
    }

    public function create($attributes) {
      return $this->model->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->model->find($id)->update($attributes);
    }
  
    public function all($perPage) {
      return $this->model->query()->select(          
          'id',
          'name', 
          'slug', 
          'description', 
          'route',
          'icon',
          'parent',
          'order',
          'enabled',
          'menu_id',)->paginate($perPage);
    }

    public function getList() {
      return $this->model->query()->select([     
          'id',
          'name',
          'description', 
          'slug', 
          'route',
          'icon',
          'parent',
          'order',
          'enabled',
          'menu_id'])->get();
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