<?php

namespace App\Http\Requests\Employer;

use App\Models\Application;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApplicationStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null && ($this->user()->isEmployer() || $this->user()->isAdmin());
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(Application::STATUSES)],
            'internal_notes' => ['nullable', 'string', 'max:3000'],
        ];
    }
}

