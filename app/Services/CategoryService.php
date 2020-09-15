<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryService {

	public function __construct(CategoryRepository $category) {
		$this->category = $category ;
	}

	public function index() {
		return $this->category->all();
	}

	public function create($request) {
		return $this->category->create($request);
	}

	public function update($request, $id) {
      return $this->category->update($id, $request);
	}

	public function read($id) {
     return $this->category->find($id);
	}

	public function delete($id) {
      return $this->category->delete($id);
	}
}