<?php

namespace App\Services;

use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;

class PermissionService {

	public function __construct(PermissionRepository $repository) {
		$this->repository = $repository ;
	}

	public function index() {
		return $this->repository->all();
	}

	public function create($request) {
		$slug = json_encode([ 'acl' => true ]);
		$request['slug'] = $slug;
		if ($this->repository->checkRecord($request['name'])) {
            return response()->json([
                'success' => false,
                'message' => 'Palabra clave ya existe'
            ])->setStatusCode(400);
        }
		return $this->repository->create($request);
	}

	public function update($request, $id) {
      return $this->repository->update($id, $request);
	}

	public function read($id) {
     return $this->repository->find($id);
	}

	public function delete($id) {
      return $this->repository->delete($id);
	}

	/**
	 *  Search resource from repository
	 * @param  object $queryFilter
	*/
	public function search($queryFilter) {
		return $this->repository->search($queryFilter);
 	}
}