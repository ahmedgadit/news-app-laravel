<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    private $repository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->repository = $categoryRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->repository->all();
        $userCategories = auth()->user()->categories;
        return response()->json(['categories' => $categories, 'userCategories' => $userCategories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        info("Request: ");
        info($request->all());
        $request->all();
        $user = auth()->user();
        $user->categories()->sync($request->categories);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
