<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\PersonalInformationFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $user_id
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string|null $suffix
 * @property string|null $blood_type
 * @property string $gender
 * @property int $age
 * @property Carbon $birthdate
 * @property string $phone_number
 * @property string $email
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 */
class PersonalInformation extends Model
{
    /** @use HasFactory<PersonalInformationFactory> */
    use HasFactory;

    use HasUuids;

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'user_id' => 'string',
            'first_name' => 'string',
            'middle_name' => 'string',
            'last_name' => 'string',
            'suffix' => 'string',
            'gender' => 'string',
            'blood_type' => 'string',
            'age' => 'integer',
            'birthdate' => 'date', // i added the property because when i composer types:check it it cannot call method toDateString on string even if i did casts it as date
            'phone_number' => 'string',
            'email' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
