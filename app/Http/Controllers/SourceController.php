<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSourceRequest;
use App\Http\Requests\UpdateSourceRequest;
use App\Models\Source;
use App\Repositories\SourceRepository;

class SourceController extends Controller
{
    private $repository;

    public function __construct(SourceRepository $sourceRepository) 
    {
        $this->repository = $sourceRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sources = $this->repository->all();
        $userSources = auth()->user()->sources;
        return response()->json(['sources' => $sources, 'userSources' => $userSources]);
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
    public function store(StoreSourceRequest $request)
    {
        info("Request: ");
        info($request->all());
        $request->all();
        $user = auth()->user();
        $user->sources()->sync($request->sources);
    }

    /**
     * Display the specified resource.
     */
    public function show(Source $source)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Source $source)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSourceRequest $request, Source $source)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Source $source)
    {
        //
    }
}
