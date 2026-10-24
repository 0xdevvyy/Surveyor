<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\PersonalInformationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    /** @use HasFactory<PersonalInformationFactory> */
    use HasFactory;
}
