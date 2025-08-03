<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $application = $this->route('job_application');
        $user = auth()->user();
        
        if ($user->isJobSeeker()) {
            return $application->user_id === $user->id;
        } elseif ($user->isEmployer()) {
            return $application->job->user_id === $user->id;
        } elseif ($user->isAdmin()) {
            return true;
        }
        
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = auth()->user();
        
        if ($user->isJobSeeker()) {
            // Job seekers can only update their application details
            return [
                'applicant_name' => 'required|string|max:255',
                'applicant_phone' => 'required|string|max:20',
                'applicant_email' => 'required|email|max:255',
                'applicant_address' => 'required|string',
                'cover_letter' => 'nullable|string|max:1000',
                'experience' => 'nullable|string',
                'skills' => 'nullable|string',
            ];
        } else {
            // Employers and admins can update status and notes
            return [
                'status' => 'required|in:pending,reviewed,shortlisted,interviewed,accepted,rejected',
                'notes' => 'nullable|string',
            ];
        }
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'applicant_name.required' => 'Nama lengkap harus diisi.',
            'applicant_phone.required' => 'Nomor telepon harus diisi.',
            'applicant_email.required' => 'Email harus diisi.',
            'applicant_email.email' => 'Format email tidak valid.',
            'applicant_address.required' => 'Alamat harus diisi.',
            'cover_letter.max' => 'Surat lamaran maksimal 1000 karakter.',
            'status.required' => 'Status lamaran harus dipilih.',
            'status.in' => 'Status lamaran tidak valid.',
        ];
    }
}