<?php

namespace App\Services;

use App\Repositories\CurrencyRepository;
use Illuminate\Http\Request;

class CurrencyService {

	public function __construct(CurrencyRepository $repository) {
		$this->repository = $repository ;
	}

	public function index($perPage) {
		return $this->repository->all($perPage);
    }
    
    public function getList() {
		return $this->repository->getList();
	}

	public function create($request) {
		if ($this->repository->checkBank($request['description'])) {
            return response()->json([
                'success' => false,
                'message' => 'Bank already exist'
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