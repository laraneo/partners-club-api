<?php

namespace App\Services;

use App\Repositories\CountryRepository;
use Illuminate\Http\Request;

class CountryService {

	public function __construct(CountryRepository $country) {
		$this->country = $country ;
	}

	public function index() {
		return $this->country->all();
	}

	public function create($request) {
		if ($this->country->checkCountry($request['description'])) {
            return response()->json([
                'success' => false,
                'message' => 'Country already exist'
            ])->setStatusCode(400);
        }
		return $this->country->create($request);
	}

	public function update($request, $id) {
      return $this->country->update($id, $request);
	}

	public function read($id) {
     return $this->country->find($id);
	}

	public function delete($id) {
      return $this->country->delete($id);
	}

	/**
	 *  Search resource from repository
	 * @param  object $queryFilter
	*/
	public function search($queryFilter) {
		return $this->country->search($queryFilter);
 	}
}