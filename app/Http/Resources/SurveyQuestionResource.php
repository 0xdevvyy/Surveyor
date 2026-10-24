<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\SurveyQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin SurveyQuestion
 */
class SurveyQuestionResource extends JsonResource
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
            'surveyorId' => UserResource::make($this->whenLoaded('surveyor')),
            'residentsId' => UserResource::make($this->whenLoaded('resident')),
            'householdSize' => $this->household_size,
            'relationshipToHouseholdHead' => $this->relationship_to_household_head,
            'educationalAttainment' => $this->educational_attainment,
            'employmentStatus' => $this->employment_status,
            'occupation' => $this->occupation,
            'monthlyIncome' => $this->monthly_income,
            'housingType' => $this->housing_type,
            'houseOwnership' => $this->house_ownership,
            'hasElectricity' => $this->has_electricity,
            'waterSource' => $this->water_source,
            'hasInternet' => $this->has_internet,
            'receivesGovernmentAssistance' => $this->receives_government_assistance,
            'is4pMember' => $this->is_4p_member,
            'isSeniorBeneficiaryMember' => $this->is_senior_beneficiary_member,
            'otherConcerns' => $this->other_concerns,
        ];
    }
}
