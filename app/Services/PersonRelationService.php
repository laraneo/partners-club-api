<?php

namespace App\Services;

use App\Repositories\PersonRelationRepository;
use Illuminate\Http\Request;

class PersonRelationService {

	public function __construct(PersonRelationRepository $repository) {
		$this->repository = $repository ;
	}

	public function index() {
		return $this->repository->all();
	}

	public function update($request, $id) {
      return $this->repository->update($id, $request);
	}

	public function read($id) {
     return $this->repository->find($id);
	}

	public function removeRelation($request) {
      return $this->repository->removeRelation($request);
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