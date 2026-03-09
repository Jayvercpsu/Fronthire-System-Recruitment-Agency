<?php

namespace App\Http\Requests\Messaging;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null && ($this->user()->isEmployer() || $this->user()->isJobSeeker());
    }

    public function rules(): array
    {
        return [
            'body' => ['nullable', 'string', 'max:2000', 'required_without:attachment'],
            'attachment' => [
                'nullable',
                'file',
                'max:5120',
                'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,csv,png,jpg,jpeg,webp,gif,mp4,mov,avi,webm,mkv,txt',
                'required_without:body',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'body.required_without' => 'Please type a message or attach a file.',
            'attachment.required_without' => 'Please attach a file or type a message.',
            'attachment.max' => 'Attachment exceeds 5MB limit.',
        ];
    }
}
