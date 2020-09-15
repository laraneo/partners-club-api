<?php

namespace App\Repositories;

use App\Widget;
use App\Role;
use App\WidgetRole;

class WidgetRepository  {
  
    protected $post;

    public function __construct(Widget $model) {
      $this->model = $model;
    }

    public function find($id) {
      return $this->model->query()->select([
        'id',
        'name',
        'slug',
        'description', 
      ])->where('id', $id)->with(['roles'])->first();
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
    ])->paginate($perPage);
    }

    public function parseRoles($roles) {
      $string = '';
      $count = 0;
      foreach ($roles as $key => $value) {
        $role = Role::where('id', $value->role_id)->first();
        $count = $count + 1;
        if(count($roles) === $count) {
          $string .= $role->slug;

        } else {
          $string .= $role->slug.'|';
        }
      }
      return $string;
    }

    public function getList() {
        $widgets = $this->model->query()->select([
            'id',
            'name',
            'slug',
            'description', 
        ])->with(['widgetRole'])->get();
        $arrayWidgets = array();
        foreach ($widgets as $key => $value) {
            $widgetRoles = $value->widgetRole()->get();
            $widgetRoles = $this->parseRoles($widgetRoles);
            $existRole = auth()->user()->hasRole($widgetRoles); 
            if($existRole) {
                array_push($arrayWidgets, $value);
            }
        }
        $widgets = $arrayWidgets;
        return $widgets;
    }

    public function delete($id) {
      $data = $this->model->find($id);
      $data->widgetRole()->delete();
      $data->delete();
     return $data;
    }

    public function checkRecord($name)
    {
      $data = $this->model->where('description', $name)->first();
      if ($data) {
        return true;
      }
      return false; 
    }
}