<?php

namespace App\Repositories;

use App\Product;
use App\Category;
use Illuminate\Support\Facades\Storage;

class ProductRepository  {
  
    protected $post;

    public function __construct(Product $product, Category $category) {
      $this->product = $product;
      $this->category = $category;
    }
    /**
     * Show the record with the given id
     * @param  integer $id
    */
    public function find($id) {
      $product = $this->product->find($id);
      $product->photo = url('storage/products/'.$product->photo);
      return $product;
    }
    /**
     * get products by query params
     * @param  object $queryFilter
    */
    public function search($queryFilter) {
      if($queryFilter->query('term') === null) {     
        if($queryFilter->query('category') !== null) {
          $search = $this->product->where('categories_id', $this->getCategory($queryFilter->query('category'))->id)->with(['category'])->get();
        } else {
          $search = $this->product->with(['category'])->get();
        }
      } else {
        if($queryFilter->query('category') !== null) {
          $category = $this->getCategory($queryFilter->query('category'))->id;
          $operator = '=';
        } else {
          $operator = '>';
          $category = 0;
        } 
        $search = $this->product->where('name', 'like', '%'.$queryFilter->query('term').'%')->where('categories_id', $operator , $category)->with(['category'])->get();
      }
      foreach ($search as $key => $element) {
        $path = url('storage/products/'.$element['photo']);
        $search[$key]->photo = $path;
      }
      return $search;
    }
    /**
     * Create new record in the database
     * @param  object $attributes
    */
    public function create($attributes) {
      return $this->product->create($attributes);
    }
    /**
     * Update record in the database
     * @param  integer $id
     * @param  object $attributes
    */
    public function update($id, array $attributes) {
      return $this->product->find($id)->update($attributes);
    }
    /**
    * Get all instances of model
    */
    public function all() {
      $products = $this->product::with(['category'])->get();
      foreach ($products as $key => $product) {
        $path = url('storage/products/'.$product['photo']);
        $products[$key]->photo = $path;
      }
      return $products;
    }

    public function delete($id) {
     return $this->product->find($id)->delete();
    }

    public function getCategory($category)
    {
      return $this->category->where('name',$category)->first();
    }

    public function checkProduct($name)
    {
      $product = $this->product->where('name', $name)->first();
      if ($product) {
        return true;
      }
      return false; 
    }
}