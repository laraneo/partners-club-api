<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SharePermitMovementsTypeService;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Requests\BankValidator;

class SharePermitMovementsTypeController extends Controller
{
    public function __construct(SharePermitMovementsTypeService $service)
	{
		$this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->service->index($request->query('perPage'));
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $request)
    {
        $data = $this->service->getList();
        return response()->json([
            'success' => true,
            'data' => $data
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
        $data = $request->all();
        $data = $this->service->create($data);
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->service->read($id);
        if($data) {
            return response()->json([
                'success' => true,
                'data' => $data
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
        $data = $request->all();
        $data = $this->service->update($data, $id);
        if($data) {
            return response()->json([
                'success' => true,
                'data' => $data
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
        $data = $this->service->delete($id);
        if($data) {
            return response()->json([
                'success' => true,
                'data' => $data
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
        $data = $this->service->search($request);
        if($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }
}
