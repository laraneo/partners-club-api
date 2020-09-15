<?php

namespace App\Repositories;

use App\ShareMovement;
use App\Share;
use App\Person;
use App\TransactionType;

class ShareMovementRepository  {
  
    protected $post;

    public function __construct(
      ShareMovement $model,
      Share $shareModel,
      Person $personModel,
      TransactionType $transactionTypeModel
      ) {
      $this->model = $model;
      $this->shareModel = $shareModel;
      $this->personModel = $personModel;
      $this->transactionTypeModel = $transactionTypeModel;
    }

    public function find($id) {
      return $this->model->find($id, ['id', 'description', 'rate']);
    }

    public function create($attributes) {
      return $this->model->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->model->find($id)->update($attributes);
    }
    
    public function all($perPage) {
      $shareMovements = $this->model->query()->with([
        'share' => function($query){
            $query->select('id', 'share_number'); 
        }, 
        'transaction' => function($query){
            $query->select('id', 'description');
        }, 
        'partner' => function($query){
            $query->select('id', 'name', 'last_name');
        },
        'titular' => function($query){
          $query->select('id', 'name', 'last_name');
      },
      'currency' => function($query){
        $query->select('id', 'description');
    }
     ])->orderBy('created', 'DESC')->paginate($perPage);
     
     foreach ($shareMovements as $key => $value) {
      $shareMovements[$key]->number_sale_price = number_format((float)$shareMovements[$key]->number_sale_price,2);
     }
     return $shareMovements;
    }

    public function getList() {
      return $this->model->query()->with([
        'share' => function($query){
            $query->select('id', 'share_number'); 
        }, 
        'transaction' => function($query){
            $query->select('id', 'description');
        }, 
        'partner' => function($query){
            $query->select('id', 'name', 'last_name');
        },
        'titular' => function($query){
          $query->select('id', 'name', 'last_name');
      }
     ])->get();
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

        /**
     * get banks by query params
     * @param  object $queryFilter
    */
    public function search($queryFilter) {
      $search;
      if($queryFilter->query('term') === null) {
        $search = $this->model->all();  
      } else {
        $searchQuery = trim($queryFilter->query('term'));
        $requestData = ['description'];
        $this->share = $queryFilter->query('term');
        $search = $this->model->with([
          'share' => function($query){
              $query->select('id', 'share_number'); 
          }, 
          'transaction' => function($query){
              $query->select('id', 'description');
          }, 
          'partner' => function($query){
              $query->select('id', 'name', 'last_name');
          },
          'titular' => function($query){
            $query->select('id', 'name', 'last_name');
        },
        'currency' => function($query){
          $query->select('id', 'description');
      }
       ])->where(function($q) use($requestData, $searchQuery) {
            foreach ($requestData as $field) {
              $q->orWhere($field, 'like', "{$searchQuery}%");
            }

            $shares = $this->shareModel->query()->where('share_number','like', '%'.$this->share.'%')->get();     
            if(count($shares)) {
              foreach ($shares as $key => $value) {
                $q->orWhere('share_id', $value->id);
              }
            }

            $personData = ['name', 'last_name'];
            $persons = $this->personModel->query()->where(function($q) use($personData, $searchQuery) {
              foreach ($personData as $field) {
                $q->orWhere($field, 'like', "%{$searchQuery}%");
              }
            })->get();
            if(count($persons)) {
              foreach ($persons as $key => $value) {
                $q->orWhere('people_id', $value->id);
              }
            }
            if(count($persons)) {
              foreach ($persons as $key => $value) {
                $q->orWhere('id_titular_persona', $value->id);
              }
            }

            $transactionTypes = $this->transactionTypeModel->query()->where('description','like', "%{$searchQuery}%")->get();
            if(count($transactionTypes)) {
              foreach ($transactionTypes as $key => $value) {
                $q->orWhere('transaction_type_id', $value->id);
              }
            }
        })->orderBy('created', 'DESC')->paginate(8);
      }
      foreach ($search as $key => $value) {
        $search[$key]->number_sale_price = number_format((float)$search[$key]->number_sale_price,2);
       }
     return $search;
    }

    public function getLastMovement($share) {
      return $this->model->where('share_id ', $share)->with(['transaction'])->orderBy('created', 'desc')->first();
    }
}