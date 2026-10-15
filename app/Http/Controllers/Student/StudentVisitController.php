<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Support\Facades\Auth;

class StudentVisitController extends Controller
{
    /**
     * Tampilkan detail rekam kunjungan milik siswa bersangkutan.
     */
    public function show(Visit $visit)
    {
        $student = Auth::user()->student;

        if (!$student || $visit->student_id !== $student->id) {
            abort(403, 'Anda tidak diizinkan melihat rekam kunjungan siswa lain.');
        }

        $visit->load(['student.schoolClass', 'officer']);

        return view('student.visits.show', compact('visit'));
    }

    /**
     * Cetak surat izin UKS mandiri oleh siswa.
     */
    public function printPermit(Visit $visit)
    {
        $student = Auth::user()->student;

        if (!$student || $visit->student_id !== $student->id) {
            abort(403, 'Anda tidak diizinkan mencetak surat izin kunjungan siswa lain.');
        }

        $visit->load(['student.schoolClass', 'officer']);

        return view('admin.visits.print_permit', compact('visit'));
    }
}
