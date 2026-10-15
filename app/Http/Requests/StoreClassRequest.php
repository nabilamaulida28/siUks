<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50|unique:classes,name',
            'grade' => 'required|in:X,XI,XII',
            'major' => 'required|string|max:100',
            'homeroom_teacher' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama kelas wajib diisi.',
            'name.unique' => 'Nama kelas sudah terdaftar.',
            'grade.required' => 'Tingkat kelas wajib dipilih.',
            'major.required' => 'Jurusan wajib diisi.',
            'status.required' => 'Status kelas wajib dipilih.',
        ];
    }
}
