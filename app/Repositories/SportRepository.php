<?php

namespace App\Repositories;

use App\Sport;

class SportRepository  {
  
    public function __construct(Sport $sport) {
      $this->sport = $sport;
    }

    public function find($id) {
      return $this->sport->find($id);
    }

    public function create($attributes) {
      return $this->sport->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->sport->find($id)->update($attributes);
    }
  
    public function all() {
      return $this->sport->query()->select(['id', 'description'])->get();
    }

    public function delete($id) {
     return $this->sport->find($id)->delete();
    }

    public function checkSport($name)
    {
      $sport = $this->sport->where('description', $name)->first();
      if ($sport) {
        return true;
      }
      return false; 
    }

        /**
     * get sports by query params
     * @param  object $queryFilter
    */
    public function search($queryFilter) {
      $search;
      if($queryFilter->query('term') === null) {
        $search = $this->sport->all();  
      } else {
        $search = $this->sport->where('description', 'like', '%'.$queryFilter->query('term').'%')->get();
      }
     return $search;
    }
}