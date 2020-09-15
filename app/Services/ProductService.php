<?php

namespace App\Services;

use App\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductService {

	public function __construct(ProductRepository $product) {
		$this->product = $product ;
	}
    /**
     * get all records from repository
    */
	public function index() {
		return $this->product->all();
	}
    /**
     *  Create new record with validations to upload new image
     * @param  object $request
    */
	public function create($request) {

		$image = $request['photo'];
		if($image !== null) {
			$name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
			\Image::make($request['photo'])->save(public_path('storage/products/').$name);
			$request['photo'] = $name;
		} else {
			$request['photo'] = "product-empty.png";
		}
		$request['user_id'] = auth()->user()->id;
		return $this->product->create($request);
	}
	/**
	 *  Update record with validations to update new image
	 * @param  object $request
	*/
	public function update($request, $id) {
			$image = $request['photo'];
			if($image !== null) {
				$name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
				\Image::make($request['photo'])->save(public_path('storage/products/').$name);
				$request['photo'] = $name;
			} else {
				$currenPhoto = Product::all()->where('id', $id)->first();
				$request['photo'] = $currenPhoto->photo;
			}
      return $this->product->update($id, $request);
	}
	/**
	 *  Get especific resource from repository
	 * @param  integer $id
	*/
	public function read($id) {
     return $this->product->find($id);
	}
	/**
	 *  Search resource from repository
	 * @param  object $queryFilter
	*/
	public function search($queryFilter) {
		return $this->product->search($queryFilter);
 }

	public function checkProduct($name) {
      return $this->product->checkProduct($name);
	}

	public function delete($id) {
		return $this->product->delete($id);
	}
}