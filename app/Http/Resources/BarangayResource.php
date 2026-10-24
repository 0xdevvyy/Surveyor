<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Barangay
 */
class BarangayResource extends JsonResource
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
            'name' => $this->name,
            'households' => HouseholdResource::collection($this->households),
        ];
    }
}
