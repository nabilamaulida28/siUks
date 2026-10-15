<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $studentId = $this->route('student') ? $this->route('student')->id : $this->input('student_id');

        return [
            'nis' => ['required', 'string', 'max:30', Rule::unique('students', 'nis')->ignore($studentId)],
            'nisn' => ['nullable', 'string', 'max:30', Rule::unique('students', 'nisn')->ignore($studentId)],
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
        ];
    }

    public function messages(): array
    {
        return [
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah terdaftar untuk siswa lain.',
            'nisn.unique' => 'NISN sudah terdaftar untuk siswa lain.',
            'name.required' => 'Nama lengkap siswa wajib diisi.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Pilihan jenis kelamin tidak valid.',
            'class_id.required' => 'Kelas wajib dipilih.',
            'class_id.exists' => 'Kelas yang dipilih tidak ditemukan.',
            'status.required' => 'Status siswa wajib dipilih.',
        ];
    }
}
