<?php

namespace App\Repositories;

use App\SharePermitMovementsType;

class SharePermitMovementsTypeRepository  {

    public function __construct(SharePermitMovementsType $model) {
      $this->model = $model;
    }

    public function find($id) {
      return $this->model->find($id, [
        'id',
        'desc',
        'days',
        'status',
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
        'desc',
        'days',
        'status',
    ])->paginate($perPage);
    }

    public function getList() {
      return $this->model->query()->select([
        'id',
        'desc',
        'days',
        'status',
    ])->get();
    }

    public function delete($id) {
     return $this->model->find($id)->delete();
    }

    public function checkRecord($name)
    {
      $data = $this->model->where('desc', $name)->first();
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
        $search = $this->model->query()->select([
            'id',
            'desc',
            'days',
            'share_id',
            'share_permit_movements_types_id',
            'user_id'
      ])->where('desc', 'like', '%'.$queryFilter->query('term').'%')->paginate($queryFilter->query('perPage'));
      }
     return $search;
    }
}