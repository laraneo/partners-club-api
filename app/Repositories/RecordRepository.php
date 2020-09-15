<?php

namespace App\Repositories;

use App\Record;

use Carbon\Carbon;
use Storage;

class RecordRepository  {
  
    protected $post;

    public function __construct(Record $model) {
      $this->model = $model;
    }

    public function find($id) {
      $record = $this->model->query()->select([
        'description',
        'created',
        'days',
        'blocked',
        'expiration_date',
        'file1',
        'file2',
        'file3',
        'file4',
        'file5',
        'record_type_id',
        'people_id',
    ])->where('id', $id)
    ->with([
      'type' => function($q){
        $q->select('id', 'description');
      }
      ])
    ->first();
    if($record->file1 !== null) $record->file1 = url('storage/records/'.$record->file1);
    if($record->file2 !== null) $record->file2 = url('storage/records/'.$record->file2);
    if($record->file3 !== null) $record->file3 = url('storage/records/'.$record->file3);
    if($record->file4 !== null) $record->file4 = url('storage/records/'.$record->file4);
    if($record->file5 !== null) $record->file5 = url('storage/records/'.$record->file5);
    return $record;
    }

    public function create($attributes) {
      return $this->model->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->model->find($id)->update($attributes);
    }
  
    public function all($perPage) {
      $records = $this->model->query()->select([
        'id',
        'description',
        'created',
        'days',
        'blocked',
        'expiration_date',
        'file1',
        'file2',
        'file3',
        'file4',
        'file5',
        'record_type_id',
        'people_id'
    ])->with([
        'type' => function($query) {
            $query->select(['id', 'description']);
        },
        ])->paginate($perPage);
      return $records;
    }

    public function getList() {
      return $this->model->query()->select([
        'id',
        'description',
        'created',
        'days',
        'blocked',
        'expiration_date',
        'file1',
        'file2',
        'file3',
        'file4',
        'file5',
        'record_type_id',
        'people_id'
    ])->get();
    }

    public function delete($id) {
      $record = $this->model->find($id);
      if($record->file1 !== null) Storage::disk('records')->delete($record->file1);
      if($record->file2 !== null) Storage::disk('records')->delete($record->file2);
      if($record->file3 !== null) Storage::disk('records')->delete($record->file3);
      if($record->file4 !== null) Storage::disk('records')->delete($record->file4);
      if($record->file5 !== null) Storage::disk('records')->delete($record->file5);
      $record->delete();
      return $record;
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

    public function getByPerson($queryFilter) {
      $records = $this->model->query()->select([
        'id',
        'description',
        'created',
        'days',
        'blocked',
        'expiration_date',
        'file1',
        'file2',
        'file3',
        'file4',
        'file5',
        'record_type_id',
        'people_id',
        'user_id'
    ])->with([
        'type' => function($query) {
            $query->select(['id', 'description']);
        },
        'user'
        ])->where('people_id', $queryFilter->query('id'))->paginate($queryFilter->query('perPage'));
        foreach ($records as $key => $value) {
          if($value->file1 !== null) $records[$key]->file1 = url('storage/records/'.$value->file1);
          if($value->file2 !== null) $records[$key]->file2 = url('storage/records/'.$value->file2);
          if($value->file3 !== null) $records[$key]->file3 = url('storage/records/'.$value->file3);
          if($value->file4 !== null) $records[$key]->file4 = url('storage/records/'.$value->file4);
          if($value->file5 !== null) $records[$key]->file5 = url('storage/records/'.$value->file5);
        }
     return $records;
    }

    public function getBlockedRecord($id){
      return $this->model->query()->select([
        'id',
        'description',
        'created',
        'days',
        'blocked',
        'expiration_date',
        'record_type_id',
        'people_id'
    ])->where('blocked', 1)->where('people_id', $id)->get();
    }

    public function getRecordsStatistics() {
      $blockedYes =  $this->model->where('blocked', 1)->whereMonth('expiration_date', '=', Carbon::now())->count();
      $blockedNo = $this->model->where('blocked', 0)->count();
      $blockedYes = $blockedYes ? $blockedYes : 0;
      $blockedNo = $blockedNo ? $blockedNo : 0;
      $data = $blockedYes.'/'.$blockedNo;
      return array('blockeds' => $data);
    }
}