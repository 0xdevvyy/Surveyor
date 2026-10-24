<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\BarangayFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Household> $households
 */
class Barangay extends Model
{
    /** @use HasFactory<BarangayFactory> */
    use HasFactory;

    use HasUuids;

    /** @return HasMany<Household, $this> */
    public function households(): HasMany
    {
        return $this->hasMany(Household::class);
    }

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'name' => 'string',
        ];
    }
}
