<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\SurveyQuestionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    /** @use HasFactory<SurveyQuestionFactory> */
    use HasFactory;
}
