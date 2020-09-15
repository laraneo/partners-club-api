<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CountryService;

class CountryController extends Controller
{
    public function __construct(CountryService $countryService)
	{
		$this->countryService = $countryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $country = $this->countryService->index();
        return response()->json([
            'success' => true,
            'data' => $country
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
        $countryRequest = $request->all();
        return $this->countryService->create($countryRequest);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $country = $this->countryService->read($id);
        if($country) {
            return response()->json([
                'success' => true,
                'data' => $country
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
        $countryRequest = $request->all();
        $country = $this->countryService->update($countryRequest, $id);
        if($country) {
            return response()->json([
                'success' => true,
                'data' => $country
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
        $country = $this->countryService->delete($id);
        if($country) {
            return response()->json([
                'success' => true,
                'data' => $country
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
        $country = $this->countryService->search($request);
        if($country) {
            return response()->json([
                'success' => true,
                'data' => $country
            ]);
        }
    }
}
