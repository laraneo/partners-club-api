<?php

namespace App\Repositories;

use App\SharePermitMovement;

class SharePermitMovementRepository  {

    public function __construct(SharePermitMovement $model) {
      $this->model = $model;
    }

    public function find($id) {
      return $this->model->find($id, [
        'id',
        'desc',
        'days',
        'share_id',
        'share_permit_movements_types_id',
        'user_id',
        'status',
        'date_cancelled',
        'userid_cancelled',
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
        'share_id',
        'share_permit_movements_types_id',
        'user_id',
        'created_at',
        'status',
        'date_cancelled',
        'userid_cancelled',
    ])->with(['share','sharePermitMovementsTypes'])->paginate($perPage);
    }

    public function getList() {
      return $this->model->query()->select([
        'id',
        'desc',
        'days',
        'share_id',
        'share_permit_movements_types_id',
        'user_id',
        'status',
        'date_cancelled',
        'userid_cancelled',
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
        $search = $this->model->query()->with(['share','sharePermitMovementsTypes'])->get();
      } else {
        $searchQuery = $queryFilter->query('term');
        $search = $this->model->query()->where(function($q) use($searchQuery) {
          $q->orWhere('desc','like', '%'.$searchQuery.'%');
        
          $q->orWhereHas('share', function($query) use($searchQuery) {
            $query->where('share_number','like', '%'.$searchQuery.'%');
          });

          $q->orWhereHas('sharePermitMovementsTypes', function($query) use($searchQuery) {
          $query->where('desc','like', $searchQuery.'%');
          });

        })->with(['share','sharePermitMovementsTypes'])->paginate($queryFilter->query('perPage'));
      }
     return $search;
    }
}