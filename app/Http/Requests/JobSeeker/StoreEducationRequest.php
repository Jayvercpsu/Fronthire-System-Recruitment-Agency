<?php

namespace App\Http\Requests\JobSeeker;

use Illuminate\Foundation\Http\FormRequest;

class StoreEducationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null && $this->user()->isJobSeeker();
    }

    public function rules(): array
    {
        return [
            'school' => ['required', 'string', 'max:180'],
            'degree' => ['required', 'string', 'max:180'],
            'field_of_study' => ['nullable', 'string', 'max:180'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'description' => ['nullable', 'string', 'max:2000'],
        ];
    }
}

