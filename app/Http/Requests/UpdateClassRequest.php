<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $classId = $this->route('class') ? $this->route('class')->id : $this->input('class_id');

        return [
            'name' => ['required', 'string', 'max:50', Rule::unique('classes', 'name')->ignore($classId)],
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
