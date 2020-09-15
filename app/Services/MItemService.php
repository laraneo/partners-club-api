<?php

namespace App\Services;

use App\MenuItem;
use Illuminate\Http\Request;

class MItemService {

	public function __construct(MenuItem $model) {
		$this->model = $model ;
	}

	public function index($perPage) {
		return $this->model->query()->select(          
            'id',
            'name', 
            'slug', 
            'description', 
            'route',
            'icon',
            'parent',
            'order',
            'enabled',
            'menu_id',)->paginate($perPage);
	}

	public function getList() {
		return $this->model->query()->select([     
            'id',
            'name',
            'description', 
            'slug', 
            'route',
            'icon',
            'parent',
            'order',
            'enabled',
            'menu_id'])->get();
	}

	public function create($request) {
		if ($this->repository->checkRecord($request['description'])) {
            return response()->json([
                'success' => false,
                'message' => 'El registro ya existe'
            ])->setStatusCode(400);
        }
		return $this->model->create($attributes);
	}

	public function update($request, $id) {
        return $this->model->find($id)->update($attributes);
	}

	public function read($id) {
        return $this->model->find($id, [
            'id',
            'name', 
            'slug', 
            'description', 
            'route',
            'icon',
            'parent',
            'order',
            'enabled',
            'menu_id',
            ]);
	}

	public function delete($id) {
        return $this->model->find($id)->delete();
	}

	/**
	 *  Search resource from repository
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
}