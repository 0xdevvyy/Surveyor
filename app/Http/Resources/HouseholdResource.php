<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Household;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Household
 */
class HouseholdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'householdNumber' => $this->household_number,
            'userId' => UserResource::collection($this->whenLoaded('users')),
            'barangayId' => BarangayResource::make($this->whenLoaded('barangays')),
        ];
    }
}
