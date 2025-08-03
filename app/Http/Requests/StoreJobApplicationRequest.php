<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isJobSeeker();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'job_id' => 'required|exists:jobs,id',
            'applicant_name' => 'required|string|max:255',
            'applicant_phone' => 'required|string|max:20',
            'applicant_email' => 'required|email|max:255',
            'applicant_address' => 'required|string',
            'cover_letter' => 'nullable|string|max:1000',
            'experience' => 'nullable|string',
            'skills' => 'nullable|string',
            'cv_file_path' => 'nullable|string', // For future file upload implementation
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'job_id.required' => 'Data lowongan tidak valid.',
            'job_id.exists' => 'Lowongan tidak ditemukan.',
            'applicant_name.required' => 'Nama lengkap harus diisi.',
            'applicant_phone.required' => 'Nomor telepon harus diisi.',
            'applicant_email.required' => 'Email harus diisi.',
            'applicant_email.email' => 'Format email tidak valid.',
            'applicant_address.required' => 'Alamat harus diisi.',
            'cover_letter.max' => 'Surat lamaran maksimal 1000 karakter.',
        ];
    }
}