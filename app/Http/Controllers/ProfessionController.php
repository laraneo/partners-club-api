<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProfessionService;

class ProfessionController extends Controller
{
    public function __construct(ProfessionService $professionService)
	{
		$this->professionService = $professionService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profession = $this->professionService->index();
        return response()->json([
            'success' => true,
            'data' => $profession
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
        $professionRequest = $request->all();
        $profession = $this->professionService->create($professionRequest);
        return $profession;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $profession = $this->professionService->read($id);
        if($profession) {
            return response()->json([
                'success' => true,
                'data' => $profession
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
        $professionRequest = $request->all();
        $profession = $this->professionService->update($professionRequest, $id);
        if($profession) {
            return response()->json([
                'success' => true,
                'data' => $profession
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
        $profession = $this->professionService->delete($id);
        if($profession) {
            return response()->json([
                'success' => true,
                'data' => $profession
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
        $profession = $this->professionService->search($request);
        if($profession) {
            return response()->json([
                'success' => true,
                'data' => $profession
            ]);
        }
    }
}
