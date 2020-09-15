<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;

class CartController extends Controller
{
    public function __construct(CartService $cartService) {
		$this->cartService = $cartService ;
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = $this->cartService->index();
        return response()->json([
            'success' => true,
            'data' => $cart
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
        $cartRequest = $request->all();
        $cart = $this->cartService->create($cartRequest);
        if ($cart) {
            return response()->json([
                'success' => true,
                'data' => $cart
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cart = $this->cartservice->read($id);
        if($cart) {
            return response()->json([
                'success' => true,
                'data' => $cart
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
    public function update(Request $request, $id)
    {
        $cartRequest = $request->all();
        $cart = $this->cartService->update($cartRequest, $id);
        if($cart) {
            return response()->json([
                'success' => true,
                'data' => $cart
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
    public function purchase()
    {
        $cart = $this->cartService->purchase();
        if($cart) {
            return response()->json([
                'success' => true,
                'data' => $cart
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart = $this->cartService->delete($id);
        if($cart) {
            return response()->json([
                'success' => true,
                'data' => $cart
            ]);
        }
    }
}
