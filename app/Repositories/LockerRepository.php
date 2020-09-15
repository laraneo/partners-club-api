<?php

namespace App\Repositories;

use App\Locker;
use App\PersonLocker;
use App\LockerLocation;

class LockerRepository  {
  
    protected $post;

    public function __construct(
      Locker $model,
      LockerLocation $lockerLocationModel,
      PersonLocker $personLockerModel
      ) {
      $this->model = $model;
      $this->lockerLocationModel = $lockerLocationModel;
      $this->personLockerModel = $personLockerModel;
    }

    public function find($id) {
      return $this->model->find($id, ['id', 'description', 'locker_location_id']);
    }

    public function create($attributes) {
      return $this->model->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->model->find($id)->update($attributes);
    }
  
    public function all($perPage) {
      return $this->model->query()
      ->select(['id', 'description', 'locker_location_id'])
      ->with([
        'location' => function($query) {
          $query->select(['id', 'description']);
        }
      ])
      ->paginate($perPage);
    }

    public function getList() {
      return $this->model->query()->select(['id', 'description'])->get();
    }

    public function delete($id) {
     return $this->model->find($id)->delete();
    }

    public function checkRecord($name, $location)
    {
      $data = $this->model->where('description', $name)->where('locker_location_id', $location)->first();
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

    public function getByLocation($id) {
//       SELECT pl.locker_id , lockers.id 
// from person_lockers pl  
// RIGHT JOIN lockers ON lockers.id = pl.locker_id
// WHERE lockers.locker_location_id  = 1
    //  return $data = \DB::table('person_lockers')
    //   ->select('lockers.id', 'lockers.description', 'lockers.locker_location_id')
    //   ->join('lockers', 'lockers.id', '=', 'person_lockers.locker_id')
    //   ->where('lockers.id', '!==', 'person_lockers.locker_id')
    //   ->where('lockers.locker_location_id', $lockerLocation)
    //   ->get();
    //   return $data;
      $lockerLocation = $id;
      if($id == 0) {
        $lockerLocation = $this->lockerLocationModel->first();
        $lockerLocation = $lockerLocation->id;
      }
      $array = array();
      $lockers = $this->model->query()->select(['id', 'description', 'locker_location_id'])->where('locker_location_id',$id)->get();
      foreach ($lockers as $key => $value) {
       $personLocker = $this->personLockerModel->where('locker_id',$value->id)->first();
       if(!$personLocker) {
         array_push($array,$value);
       }
      }
      return $array;
    }
}