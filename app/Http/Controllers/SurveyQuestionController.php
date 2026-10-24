<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreSurveyQuestionRequest;
use App\Http\Requests\UpdateSurveyQuestionRequest;
use App\Models\SurveyQuestion;

class SurveyQuestionController extends Controller
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
    public function store(StoreSurveyQuestionRequest $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SurveyQuestion $surveyQuestion): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SurveyQuestion $surveyQuestion): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSurveyQuestionRequest $request, SurveyQuestion $surveyQuestion): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SurveyQuestion $surveyQuestion): void
    {
        //
    }
}
