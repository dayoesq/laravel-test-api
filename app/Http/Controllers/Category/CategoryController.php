<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $categories = Category::all();
        return $this->showAll($categories);
    }

    /**
     * Store a newly created category resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
        $category = Category::create($validated);
        return $this->showOne($category, 201);
    }

    /**
     * Display the category resource.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function show(Category $category): JsonResponse
    {
        return $this->showOne($category);
    }

    /**
     * Update the category resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        $category->fill($request->only([
            'name',
            'description'
        ]));
        if($category->isClean()) {
            return $this->errorResponse('There is nothing to update', 422);
        }
        $category->save();
        return $this->showOne($category);
    }

    /**
     * Remove category resource from storage.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();
        return $this->showOne($category);
    }

}
