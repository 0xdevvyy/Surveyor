<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\PersonalInformation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin PersonalInformation
 */
class PersonalInformationResource extends JsonResource
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
            'userId' => UserResource::make($this->whenLoaded('user')),
            'firstName' => $this->first_name,
            'middleName' => $this->middle_name,
            'lastName' => $this->last_name,
            'suffix' => $this->suffix,
            'bloodType' => $this->blood_type,
            'gender' => $this->gender,
            'age' => $this->age,
            'birthdate' => $this->birthdate->toDateString(),
            'phoneNumber' => $this->phone_number,
            'email' => $this->email,
        ];
    }
}
