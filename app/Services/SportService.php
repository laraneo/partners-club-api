<?php

namespace App\Services;

use App\Repositories\SportRepository;
use Illuminate\Http\Request;

class SportService {

	public function __construct(SportRepository $sport) {
		$this->sport = $sport ;
	}

	public function index() {
		return $this->sport->all();
	}

	public function create($request) {
		if ($this->sport->checkSport($request['description'])) {
            return response()->json([
                'success' => false,
                'message' => 'Sport already exist'
            ])->setStatusCode(400);
        }
		return $this->sport->create($request);
	}

	public function update($request, $id) {
      return $this->sport->update($id, $request);
	}

	public function read($id) {
     return $this->sport->find($id);
	}

	public function delete($id) {
      return $this->sport->delete($id);
	}

	/**
	 *  Search resource from repository
	 * @param  object $queryFilter
	*/
	public function search($queryFilter) {
		return $this->sport->search($queryFilter);
 	}
}