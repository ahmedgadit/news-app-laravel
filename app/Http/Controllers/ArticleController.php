<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Repositories\ArticleRepository;

class ArticleController extends Controller
{
    private $repository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->repository = $articleRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = $this->repository;
        if(request()->has('search') && request()->search != null && request()->search != ''){
            $this->repository->where('title', "%".request()->search."%", 'like');
        }
        if(request()->has('category') && request()->category != 'all' && request()->category != null ){
            info(request()->category);
            $articles->whereHas('category', 'name', request()->category, '=');
        }

        $categoryIds = auth()->user()->categories->pluck('id')->toArray();
        $sourceIds = auth()->user()->sources->pluck('id')->toArray();
        count($categoryIds) > 0 && $articles->whereIn('category_id', $categoryIds);
        count($sourceIds) > 0 && $articles->WhereIn('source_id', $sourceIds);


        $articles = $articles->paginate(10); // Adjust the number of articles per page as needed
        return response()->json($articles);
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
    public function store(StoreArticleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }
}
