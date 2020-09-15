<?php

namespace App\Repositories;

use App\CardPerson;

use Carbon\Carbon;

class CardPersonRepository  {
  
    protected $post;

    public function __construct(CardPerson $model) {
      $this->model = $model;
    }

    public function find($id) {
      return $this->model->find($id);
    }

    public function create($attributes) {
      return $this->model->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->model->find($id)->update($attributes);
    }
  
    public function all($id) {
      return $this->model->query()->where('people_id', $id)->with(['bank','card'])->get();
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
        $search = $this->model->where('description', 'like', '%'.$queryFilter->query('term').'%')->paginate($queryFilter->query('perPage'));
      }
     return $search;
    }
    //30d    SELECT count(*)  FROM [partnersControl].[dbo].[card_people] WHERE    DATEDIFF(day,GETDATE(),[expiration_date])  <= 30 
    //60d    SELECT count(*)  FROM [partnersControl].[dbo].[card_people] WHERE    DATEDIFF(day,GETDATE(),[expiration_date])  <= 60  
    public function getCardStatistics() {
      $first = $this->model->whereRaw('DATEDIFF(day,GETDATE(),[expiration_date]) <= 30')->count();
      $second = $this->model->whereRaw('DATEDIFF(day,GETDATE(),[expiration_date]) <= 60')->count();
      $first = $first ? $first : 0;
      $second = $second ? $second : 0;
      $data = $first.'/'.$second;
      return array('cards' => $data);
    }
}