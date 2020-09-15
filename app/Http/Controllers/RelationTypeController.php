<?php

namespace App\Http\Controllers;
use App\Services\RelationTypeService;

use Illuminate\Http\Request;

class RelationTypeController extends Controller
{
    public function __construct(RelationTypeService $service)
    {
        $this->service = $service;
    }
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->service->index();
        return response()->json([
            'success' => true,
            'data' => $response
        ]);
    }

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList()
    {
        $response = $this->service->getList();
        return response()->json([
            'success' => true,
            'data' => $response
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
        $body = $request->all();
        return $this->service->create($body);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->service->read($id);
        if($response) {
            return response()->json([
                'success' => true,
                'data' => $response
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
        $body = $request->all();
        $response = $this->service->update($body, $id);
        if($response) {
            return response()->json([
                'success' => true,
                'data' => $response
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
        $response = $this->service->delete($id);
        if($response) {
            return response()->json([
                'success' => true,
                'data' => $response
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
        $response = $this->service->search($request);
        if($response) {
            return response()->json([
                'success' => true,
                'data' => $response
            ]);
        }
    }
}
