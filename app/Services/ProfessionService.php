<?php

namespace App\Services;

use App\Repositories\ProfessionRepository;
use Illuminate\Http\Request;

class ProfessionService {

	public function __construct(ProfessionRepository $profession) {
		$this->profession = $profession ;
	}

	public function index() {
		return $this->profession->all();
	}

	public function create($request) {
		if ($this->profession->checkProfession($request['description'])) {
            return response()->json([
                'success' => false,
                'message' => 'Profession already exist'
            ])->setStatusCode(400);
        }
		return $this->profession->create($request);
	}

	public function update($request, $id) {
      return $this->profession->update($id, $request);
	}

	public function read($id) {
     return $this->profession->find($id);
	}

	public function delete($id) {
      return $this->profession->delete($id);
	}

	/**
	 *  Search resource from repository
	 * @param  object $queryFilter
	*/
	public function search($queryFilter) {
		return $this->profession->search($queryFilter);
 	}
}