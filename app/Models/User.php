<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\RoleEnum;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $email
 * @property string|null $avatar_path
 * @property RoleEnum $role
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read PersonalInformation|null $personalInformation
 * @property-read Collection<int, Household> $households
 * @property-read Collection<int, SurveyQuestion> $surveysAsSurveyor
 * @property-read Collection<int, SurveyQuestion> $surveysAsResident
 */
#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    use HasUuids;

    /** @return HasOne<PersonalInformation, $this> */
    public function personalInformation(): HasOne
    {
        return $this->hasOne(PersonalInformation::class);
    }

    /** @return HasMany<Household, $this> */
    public function households(): HasMany
    {
        return $this->hasMany(Household::class);
    }

    /** @return HasMany<SurveyQuestion, $this> */
    public function surveysAsSurveyor(): HasMany
    {
        return $this->hasMany(SurveyQuestion::class, 'surveyor_id');
    }

    /** @return HasMany<SurveyQuestion, $this> */
    public function surveysAsResident(): HasMany
    {
        return $this->hasMany(SurveyQuestion::class, 'residents_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'email' => 'string',
            'role' => RoleEnum::class,
            'avatar_path' => 'string',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
