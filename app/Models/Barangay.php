<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\BarangayFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    /** @use HasFactory<BarangayFactory> */
    use HasFactory;
}
