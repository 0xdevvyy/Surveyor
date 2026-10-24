<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\HouseholdFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    /** @use HasFactory<HouseholdFactory> */
    use HasFactory;
}
