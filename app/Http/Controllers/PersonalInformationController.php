<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonalInformationRequest;
use App\Http\Requests\UpdatePersonalInformationRequest;
use App\Models\PersonalInformation;

class PersonalInformationController extends Controller
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
    public function store(StorePersonalInformationRequest $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PersonalInformation $personalInformation): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonalInformation $personalInformation): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonalInformationRequest $request, PersonalInformation $personalInformation): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonalInformation $personalInformation): void
    {
        //
    }
}
