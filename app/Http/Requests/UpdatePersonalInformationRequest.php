<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enum\BloodTypeEnum;
use App\Enum\GenderEnum;
use App\Enum\SuffixEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePersonalInformationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('personalInformation')) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'suffix' => ['nullable', Rule::enum(SuffixEnum::class)],
            'blood_type' => ['nullable', Rule::enum(BloodTypeEnum::class)],
            'gender' => ['required', Rule::enum(GenderEnum::class)],
            'age' => ['required', 'integer', 'min:0', 'max:150'],
            'birthdate' => ['required', 'date', 'before_or_equal:today'],
            'phone_number' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:255'],
        ];
    }
}
