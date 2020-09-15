<?php

namespace App\Repositories;

use App\Permission;

class PermissionRepository  {

    public function __construct(Permission $model) {
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
      return $this->model->all();
    }

    public function delete($id) {
      $permission = $this->model->find($id);
      $permission->permissionRoles()->delete();
      $permission->delete();
     return $permission;
    }

    public function checkRecord($name)
    {
      $response = $this->model->where('name', $name)->first();
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