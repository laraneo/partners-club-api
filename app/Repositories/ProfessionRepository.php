<?php

namespace App\Repositories;

use App\Profession;

class ProfessionRepository  {
  
    protected $post;

    public function __construct(Profession $profession) {
      $this->profession = $profession;
    }

    public function find($id) {
      return $this->profession->find($id);
    }

    public function create($attributes) {
      return $this->profession->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->profession->find($id)->update($attributes);
    }
  
    public function all() {
      return $this->profession->all();
    }

    public function delete($id) {
     return $this->profession->find($id)->delete();
    }

    public function checkProfession($name)
    {
      $profession = $this->profession->where('description', $name)->first();
      if ($profession) {
        return true;
      }
      return false; 
    }

        /**
     * get professions by query params
     * @param  object $queryFilter
    */
    public function search($queryFilter) {
      $search;
      if($queryFilter->query('term') === null) {
        $search = $this->profession->all();  
      } else {
        $search = $this->profession->where('description', 'like', '%'.$queryFilter->query('term').'%')->get();
      }
     return $search;
    }
}