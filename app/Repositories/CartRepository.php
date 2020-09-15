<?php

namespace App\Repositories;

use App\ShoppingCart;

class CartRepository  {
  
    protected $cart;

    public function __construct(ShoppingCart $cart) {
      $this->cart = $cart;
    }

    public function find($id) {
      return $this->cart->find($id);
    }

    public function create($attributes) {
      return $this->cart->create($attributes);
    }

    public function purchase() {
      $cartUpdate = $this->cart->where('user_id', auth()->user()->id)->update(['status' => 2]);
      return $cartUpdate;
    }

    public function update($id, array $attributes) {
      return $this->cart->find($id)->update($attributes);
    }
  
    public function all() {
      $cart = $this->cart::with(['product'])->where('user_id',auth()->user()->id)->get();
      return $cart;
    }

    public function delete($id) {
     return $this->cart->find($id)->delete();
    }

    public function checkCart($name)
    {
      $cart = $this->cart->where('name', $name)->first();
      if ($cart) {
        return true;
      }
      return false; 
    }
}