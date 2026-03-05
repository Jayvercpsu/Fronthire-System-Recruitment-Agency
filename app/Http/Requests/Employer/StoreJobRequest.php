<?php

namespace App\Http\Requests\Employer;

use App\Models\Job;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null && $this->user()->isEmployer();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:160'],
            'location' => ['required', 'string', 'max:160'],
            'job_type' => ['required', Rule::in(Job::JOB_TYPES)],
            'work_setup' => ['required', Rule::in(Job::WORK_SETUPS)],
            'salary_min' => ['nullable', 'integer', 'min:0'],
            'salary_max' => ['nullable', 'integer', 'min:0', 'gte:salary_min'],
            'currency' => ['nullable', 'string', 'size:3'],
            'status' => ['required', Rule::in(Job::STATUSES)],
            'description' => ['required', 'string', 'min:30', 'max:10000'],
            'requirements' => ['nullable', 'string', 'max:6000'],
            'required_skills' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
