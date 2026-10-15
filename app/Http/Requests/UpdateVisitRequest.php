<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVisitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => 'required|exists:students,id',
            'visit_date' => 'required|date',
            'arrival_time' => 'required',
            'departure_time' => 'nullable',
            'lesson_period' => 'required|string|max:50',
            'subject' => 'nullable|string|max:100',
            'complaint_type' => 'required|string|max:100',
            'complaint' => 'required|string',
            'temperature' => 'nullable|numeric|between:30,45',
            'blood_pressure' => 'nullable|string|max:30',
            'general_condition' => 'nullable|string|max:150',
            'treatment' => 'required|string',
            'final_status' => 'required|string|max:100',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required' => 'Silakan pilih siswa yang berkunjung.',
            'student_id.exists' => 'Data siswa yang dipilih tidak valid.',
            'visit_date.required' => 'Tanggal kunjungan wajib diisi.',
            'visit_date.date' => 'Format tanggal kunjungan tidak valid.',
            'arrival_time.required' => 'Jam datang wajib diisi.',
            'lesson_period.required' => 'Jam pelajaran wajib dipilih.',
            'complaint_type.required' => 'Jenis keluhan wajib dipilih.',
            'complaint.required' => 'Keluhan / kondisi siswa wajib diisi.',
            'temperature.numeric' => 'Suhu tubuh harus berupa angka.',
            'temperature.between' => 'Suhu tubuh harus berada dalam rentang 30°C - 45°C.',
            'treatment.required' => 'Tindakan yang diberikan petugas wajib diisi.',
            'final_status.required' => 'Status setelah kunjungan wajib dipilih.',
        ];
    }
}
