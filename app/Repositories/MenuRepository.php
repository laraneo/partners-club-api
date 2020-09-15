<?php

namespace App\Repositories;

use App\Menu;
use App\Role;
use App\MenuItemRole;
use App\Parameter;

class MenuRepository  {
  
    protected $post;

    public function __construct(Menu $model, Parameter $parameterModel ) {
      $this->model = $model;
      $this->parameterModel = $parameterModel;
    }

    public function find($id) {
      return $this->model->query()->where('id', $id)->with(['items'])->first();
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
      $validMenu = $this->parameterModel->where('parameter', 'MENU_ID')->first();
      $menu = $this->model->query()->select([
        'id',
        'name', 
        'slug', 
        'description',
      ])->where('id', $validMenu->value )->with(['items'])->first();
      if(!$menu) {
        return [];
      }
      $menuItems = $menu->items()->with(['icons'])->orderBy('parent', 'ASC')->orderBy('order', 'ASC')->get();
      $arrayMenus = array();
      foreach ($menuItems as $key => $value) {
        $userRoles = $value->roleMenu()->get();
        $userRoles = $this->parseRoles($userRoles);
        $existRole = auth()->user()->hasRole($userRoles); 
        //  $existRole = Role::whereIn('id', $roles)->first();
          if($existRole) {
            array_push($arrayMenus, $value);
          }
      }
      unset($menu->items);
      $menu->items = $arrayMenus;
      return $menu;
    }

    public function getMenuList() {
      return $this->model->query()->select([
        'id',
        'name', 
        'slug', 
        'description',
      ])->with(['items'])->get();
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
}