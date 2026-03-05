<?php

namespace App\Http\Requests\JobSeeker;

use App\Models\Resume;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null && $this->user()->isJobSeeker();
    }

    public function rules(): array
    {
        return [
            'cover_letter' => ['nullable', 'string', 'max:4000'],
            'resume_id' => ['nullable', 'integer', 'exists:resumes,id', 'required_without:resume'],
            'resume' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx',
                'mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'max:5120',
                'required_without:resume_id',
            ],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if (! $this->filled('resume_id')) {
                return;
            }

            $resume = Resume::query()->find($this->integer('resume_id'));

            if (! $resume || $resume->user_id !== $this->user()?->id) {
                $validator->errors()->add('resume_id', 'Please select a valid resume from your account.');
            }
        });
    }
}
