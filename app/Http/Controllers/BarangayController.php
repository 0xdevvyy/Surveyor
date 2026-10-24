<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreBarangayRequest;
use App\Http\Requests\UpdateBarangayRequest;
use App\Models\Barangay;

class BarangayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): void
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBarangayRequest $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Barangay $barangay): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barangay $barangay): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBarangayRequest $request, Barangay $barangay): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barangay $barangay): void
    {
        //
    }
}
