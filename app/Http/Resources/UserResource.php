<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Household;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class UserResource extends JsonResource
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
            'email' => $this->email,
            //             'avatarPath' => $this->avatar_path, // will do the Storage::url() when i added the actions and front end for the avatar creation
            'role' => $this->role,
            'emailVerifiedAt' => $this->email_verified_at,
            'createdAt' => $this->created_at,
            'households' => $this->whenLoaded(
                'households',
                fn () => $this->households
                    ->map(fn (Household $household): array => [
                        'householdNumber' => $household->household_number,
                        'barangay' => $household->barangay->name,
                    ])
                    ->values(),
            ),
        ];
    }
}
