<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Product;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller {
    protected $productservice;
    public function __construct(ProductService $productservice)
	{
		$this->productservice = $productservice;
    }
    
    /**
     * Get the resources from storage 
     * @return \Illuminate\Http\Response
     */

    public function index() {
       
        $products = $this->productservice->index();
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $productRequest = $request->all();
        if ($this->productservice->checkProduct($productRequest['name'])) {
            return response()->json([
                'success' => false,
                'message' => 'Product already exist'
            ])->setStatusCode(400);
        }   
        $product = $this->productservice->create($productRequest);
        if ($product) {
            return response()->json([
                'success' => true,
                'data' => $product
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $product = $this->productservice->read($id);
        if($product) {
            return response()->json([
                'success' => true,
                'data' => $product
            ]);
        }
    }

        /**
     * Get the specified resource by search.
     *
     * @param  string $term
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $product = $this->productservice->search($request);
        if($product) {
            return response()->json([
                'success' => true,
                'data' => $product
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $productRequest = $request->all();
        $product = $this->productservice->update($productRequest, $id);
        if($product) {
            return response()->json([
                'success' => true,
                'data' => $product
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
    $product = $this->productservice->delete($id);
    if($product) {
        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }
    }
}
