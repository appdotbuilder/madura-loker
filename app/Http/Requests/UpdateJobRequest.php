<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $job = $this->route('job');
        $user = auth()->user();
        
        return $user && ($job->user_id === $user->id || $user->isAdmin());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'job_category_id' => 'required|exists:job_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'store_name' => 'required|string|max:255',
            'store_address' => 'required|string',
            'store_phone' => 'required|string|max:20',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'salary_type' => 'required|in:hourly,daily,weekly,monthly',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'work_type' => 'required|in:full-time,part-time,contract,freelance',
            'positions_available' => 'required|integer|min:1',
            'application_deadline' => 'nullable|date|after:today',
            'status' => 'required|in:draft,active,paused,closed',
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
            'job_category_id.required' => 'Kategori pekerjaan harus dipilih.',
            'job_category_id.exists' => 'Kategori pekerjaan tidak valid.',
            'title.required' => 'Judul lowongan harus diisi.',
            'description.required' => 'Deskripsi pekerjaan harus diisi.',
            'store_name.required' => 'Nama toko harus diisi.',
            'store_address.required' => 'Alamat toko harus diisi.',
            'store_phone.required' => 'Nomor telepon toko harus diisi.',
            'salary_max.gte' => 'Gaji maksimal harus lebih besar atau sama dengan gaji minimal.',
            'positions_available.required' => 'Jumlah posisi yang tersedia harus diisi.',
            'positions_available.min' => 'Jumlah posisi minimal 1.',
            'application_deadline.after' => 'Batas waktu lamaran harus setelah hari ini.',
        ];
    }
}