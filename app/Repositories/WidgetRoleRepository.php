<?php

namespace App\Repositories;

use App\WidgetRole;

class WidgetRoleRepository  {

    public function __construct(WidgetRole $model) {
      $this->model = $model;
    }

    public function find($widget, $role) {
      return $this->model->query()->where('widget_id', $widget)->where('role_id', $role)->first();
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