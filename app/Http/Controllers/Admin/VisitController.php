<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVisitRequest;
use App\Http\Requests\UpdateVisitRequest;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitController extends Controller
{
    /**
     * Tampilkan daftar kunjungan dengan filter dan pencarian.
     */
    public function index(Request $request)
    {
        $query = Visit::with(['student.schoolClass', 'officer']);

        // Filter Pencarian (Nama Siswa atau NIS)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        // Filter Tanggal
        if ($request->filled('date')) {
            $query->whereDate('visit_date', $request->date);
        }

        // Filter Rentang Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('visit_date', [$request->start_date, $request->end_date]);
        }

        // Filter Kelas
        if ($request->filled('class_id')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('class_id', $request->class_id);
            });
        }

        // Filter Keluhan
        if ($request->filled('complaint_type')) {
            $query->where('complaint_type', $request->complaint_type);
        }

        // Filter Status
        if ($request->filled('final_status')) {
            $query->where('final_status', $request->final_status);
        }

        $visits = $query->orderBy('visit_date', 'desc')
            ->orderBy('arrival_time', 'desc')
            ->paginate(15)
            ->withQueryString();

        $classes = SchoolClass::active()->orderBy('name')->get();
        $complaints = Visit::COMPLAINTS;
        $statuses = Visit::FINAL_STATUSES;

        return view('admin.visits.index', compact('visits', 'classes', 'complaints', 'statuses'));
    }

    /**
     * Form tambah kunjungan baru.
     */
    public function create()
    {
        $students = Student::active()->with('schoolClass')->orderBy('name')->get();
        $complaints = Visit::COMPLAINTS;
        $lessonPeriods = Visit::LESSON_PERIODS;
        $statuses = Visit::FINAL_STATUSES;
        $treatments = Visit::COMMON_TREATMENTS;

        return view('admin.visits.create', compact('students', 'complaints', 'lessonPeriods', 'statuses', 'treatments'));
    }

    /**
     * Simpan data kunjungan baru.
     */
    public function store(StoreVisitRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $visit = Visit::create($data);

        return redirect()->route('admin.visits.show', $visit)->with('success', 'Data kunjungan UKS berhasil dicatat!');
    }

    /**
     * Detail kartu rekam kunjungan.
     */
    public function show(Visit $visit)
    {
        $visit->load(['student.schoolClass', 'officer']);

        // Riwayat kunjungan siswa sebelumnya
        $studentHistory = Visit::where('student_id', $visit->student_id)
            ->where('id', '!=', $visit->id)
            ->orderBy('visit_date', 'desc')
            ->limit(5)
            ->get();

        return view('admin.visits.show', compact('visit', 'studentHistory'));
    }

    /**
     * Tampilan cetak surat keterangan kunjungan / izin UKS.
     */
    public function printPermit(Visit $visit)
    {
        $visit->load(['student.schoolClass', 'officer']);
        return view('admin.visits.print_permit', compact('visit'));
    }

    /**
     * Form edit kunjungan.
     */
    public function edit(Visit $visit)
    {
        $students = Student::active()->with('schoolClass')->orderBy('name')->get();
        $complaints = Visit::COMPLAINTS;
        $lessonPeriods = Visit::LESSON_PERIODS;
        $statuses = Visit::FINAL_STATUSES;
        $treatments = Visit::COMMON_TREATMENTS;

        return view('admin.visits.edit', compact('visit', 'students', 'complaints', 'lessonPeriods', 'statuses', 'treatments'));
    }

    /**
     * Update data kunjungan.
     */
    public function update(UpdateVisitRequest $request, Visit $visit)
    {
        $visit->update($request->validated());

        return redirect()->route('admin.visits.show', $visit)->with('success', 'Data kunjungan UKS berhasil diperbarui!');
    }

    /**
     * Hapus data kunjungan.
     */
    public function destroy(Visit $visit)
    {
        $visit->delete();

        return redirect()->route('admin.visits.index')->with('success', 'Data kunjungan berhasil dihapus.');
    }
}
