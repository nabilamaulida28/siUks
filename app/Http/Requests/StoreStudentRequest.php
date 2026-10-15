<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nis' => 'required|string|max:30|unique:students,nis',
            'nisn' => 'nullable|string|max:30|unique:students,nisn',
            'name' => 'required|string|max:100',
            'gender' => 'required|in:L,P',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'class_id' => 'required|exists:classes,id',
            'major' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:25',
            'parent_name' => 'nullable|string|max:100',
            'parent_phone' => 'nullable|string|max:25',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'create_user_account' => 'nullable|boolean',
            'email' => 'nullable|required_if:create_user_account,1|email|unique:users,email',
            'password' => 'nullable|required_if:create_user_account,1|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah terdaftar dalam sistem.',
            'nisn.unique' => 'NISN sudah terdaftar dalam sistem.',
            'name.required' => 'Nama lengkap siswa wajib diisi.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Pilihan jenis kelamin tidak valid.',
            'class_id.required' => 'Kelas wajib dipilih.',
            'class_id.exists' => 'Kelas yang dipilih tidak ditemukan.',
            'status.required' => 'Status siswa wajib dipilih.',
            'email.required_if' => 'Email wajib diisi jika membuat akun login siswa.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'password.required_if' => 'Password wajib diisi jika membuat akun login siswa.',
            'password.min' => 'Password minimal 6 karakter.',
        ];
    }
}
