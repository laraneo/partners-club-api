<?php

namespace App\Repositories;

use App\User;

class UserRepository  {
  
    protected $user;
    protected $teamUser;

    public function __construct(User $user) {
      $this->model = $user;
    }

    public function find($id) {
      return $this->model->where('id', $id)->with('roles')->first();
    }

    public function create($attributes) {
      $user = $this->model->create($attributes);
      $roles = json_decode($attributes['roles']);
      if($roles && count($roles)) {
				foreach ($roles as $role) {
					$user->assignRole($role);
				}
      }
      return $user;
    }

    public function update($id, array $attributes) {
      return $this->model->find($id)->update($attributes);
    }

    public function all() {
      return $this->model->query()->with('roles')->get();
    }

    public function delete($id) {
     return $this->model->find($id)->delete();
    }

    public function checkUser($email)
    {
      $user = $this->model->where('email', $email)->first();
      if ($user) {
        return true;
      }
      return false; 
    }

    public function forcedLogin($username)
    {
      return $this->model->where('username', $username)->first(); 
    }

    /**
     * get persons by query params
     * @param  object $queryFilter
    */
    public function search($queryFilter) {
      $searchQuery = trim($queryFilter->query('term'));
      $this->share = $queryFilter->query('term');
      $requestData = ['name', 'username', 'email'];
      $search = $this->model->where(function($q) use($requestData, $searchQuery) {
                  foreach ($requestData as $field) {
                     $q->orWhere($field, 'like', "%{$searchQuery}%");
                  }
                })->with('roles')->get();
      return $search;
  }
}