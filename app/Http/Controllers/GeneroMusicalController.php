<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGeneroMusicalRequest;
use App\Http\Requests\UpdateGeneroMusicalRequest;
use App\Models\GeneroMusical;
use App\Services\GeneroMusicalService;

class GeneroMusicalController extends Controller
{
    protected GeneroMusicalService $generoMusicalService;

    public function __construct(GeneroMusicalService $generoMusicalService)
    {
        $this->generoMusicalService = $generoMusicalService;
    }

    public function index()
    {
        return $this->generoMusicalService->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGeneroMusicalRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(GeneroMusical $generoMusical)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGeneroMusicalRequest $request, GeneroMusical $generoMusical)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GeneroMusical $generoMusical)
    {
        //
    }
}
