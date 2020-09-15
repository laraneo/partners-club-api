<?php

namespace App\Services;

use App\Repositories\CartRepository;
use Illuminate\Http\Request;

class CartService {

	public function __construct(CartRepository $cart) {
		$this->cart = $cart ;
	}

	public function index() {
		return $this->cart->all();
	}

	public function create($request) {
    $request['user_id'] = auth()->user()->id;
		return $this->cart->create($request);
	}

	public function update($request, $id) {
      return $this->cart->update($id, $request);
  }
  
  public function purchase() {
    return $this->cart->purchase();
  }

	public function read($id) {
     return $this->cart->find($id);
	}

	public function delete($id) {
      return $this->cart->delete($id);
	}

	public function checkCart($name) {
		return $this->cart->checkCart($name);
	}
}