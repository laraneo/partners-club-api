<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    public function __construct(CategoryService $categoryService)
	{
		$this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project = $this->categoryService->index();
        return response()->json([
            'success' => true,
            'data' => $project
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
        $categoryRequest = $request->all();
        $category = $this->categoryservice->create($categoryRequest);
        if ($category) {
            return response()->json([
                'success' => true,
                'data' => $category
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
        $category = $this->categoryService->read($id);
        if($category) {
            return response()->json([
                'success' => true,
                'data' => $category
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
        $categoryRequest = $request->all();
        $category = $this->categoryService->update($categoryRequest, $id);
        if($category) {
            return response()->json([
                'success' => true,
                'data' => $category
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
        $category = $this->categoryService->delete($id);
        if($category) {
            return response()->json([
                'success' => true,
                'data' => $category
            ]);
        }
    }
}
