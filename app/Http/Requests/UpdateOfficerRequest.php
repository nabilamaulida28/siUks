<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOfficerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $officerId = $this->route('officer') ? $this->route('officer')->id : $this->input('officer_id');

        return [
            'name' => 'required|string|max:100',
            'email' => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($officerId)],
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,officer',
            'phone' => 'nullable|string|max:25',
            'position' => 'nullable|string|max:100',
            'is_active' => 'required|boolean',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap petugas wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar untuk pengguna lain.',
            'password.min' => 'Password minimal 6 karakter.',
            'role.required' => 'Peran (Role) wajib dipilih.',
            'profile_photo.image' => 'File foto profil harus berupa gambar.',
            'profile_photo.max' => 'Ukuran foto maksimal 2MB.',
        ];
    }
}
