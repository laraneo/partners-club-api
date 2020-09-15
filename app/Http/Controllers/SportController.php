<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SportService;

class SportController extends Controller
{
    public function __construct(SportService $sportService)
	{
		$this->sportService = $sportService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sports = $this->sportService->index();
        return response()->json([
            'success' => true,
            'data' => $sports
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
        $sportRequest = $request->all();
        $sport = $this->sportService->create($sportRequest);
        return $sport;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sport = $this->sportService->read($id);
        if($sport) {
            return response()->json([
                'success' => true,
                'data' => $sport
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
        $sportRequest = $request->all();
        $sport = $this->sportService->update($sportRequest, $id);
        if($sport) {
            return response()->json([
                'success' => true,
                'data' => $sport
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
        $sport = $this->sportService->delete($id);
        if($sport) {
            return response()->json([
                'success' => true,
                'data' => $sport
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
        $sport = $this->sportService->search($request);
        if($sport) {
            return response()->json([
                'success' => true,
                'data' => $sport
            ]);
        }
    }
}
