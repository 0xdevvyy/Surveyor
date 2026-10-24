<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\SurveyQuestionFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $surveyor_id
 * @property string $residents_id
 * @property int|null $household_size
 * @property string|null $relationship_to_household_head
 * @property string|null $educational_attainment
 * @property string|null $employment_status
 * @property string|null $occupation
 * @property numeric-string|null $monthly_income
 * @property string|null $housing_type
 * @property string|null $house_ownership
 * @property bool|null $has_electricity
 * @property string|null $water_source
 * @property bool|null $has_internet
 * @property bool|null $receives_government_assistance
 * @property bool|null $is_4p_member
 * @property bool|null $is_senior_beneficiary_member
 * @property string|null $other_concerns
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $surveyor
 * @property-read User $resident
 */
class SurveyQuestion extends Model
{
    /** @use HasFactory<SurveyQuestionFactory> */
    use HasFactory;

    use HasUuids;

    /** @return BelongsTo<User, $this> */
    public function surveyor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'surveyor_id');
    }

    /** @return BelongsTo<User, $this> */
    public function resident(): BelongsTo
    {
        return $this->belongsTo(User::class, 'residents_id');
    }

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'surveyor_id' => 'string',
            'residents_id' => 'string',

            // Household Information
            'household_size' => 'integer',
            'relationship_to_household_head' => 'string',

            // Education and Employment
            'educational_attainment' => 'string',
            'employment_status' => 'string',
            'occupation' => 'string',

            // Household Income
            'monthly_income' => 'decimal:2',

            // Housing and Utilities
            'housing_type' => 'string',
            'house_ownership' => 'string',
            'has_electricity' => 'boolean',
            'water_source' => 'string',
            'has_internet' => 'boolean',

            // Government Assistance
            'receives_government_assistance' => 'boolean',
            'is_4p_member' => 'boolean',
            'is_senior_beneficiary_member' => 'boolean',

            // Additional Information
            'other_concerns' => 'string',

            // Timestamps
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
