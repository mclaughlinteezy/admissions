<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'nationality' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'program_choice' => 'required|string|max:255',
            'academic_qualification' => 'required|string|max:255',
            'gpa' => 'nullable|numeric|min:0|max:4',
            'previous_school' => 'required|string|max:255',
            'graduation_year' => 'required|integer|min:1950|max:' . date('Y'),
            'personal_statement' => 'nullable|string|max:2000',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:5120'
        ];
    }

    public function messages()
    {
        return [
            'date_of_birth.before' => 'Date of birth must be before today.',
            'gpa.between' => 'GPA must be between 0 and 4.',
            'document.mimes' => 'Document must be a PDF, DOC, or DOCX file.',
            'document.max' => 'Document size must not exceed 5MB.',
        ];
    }
}
