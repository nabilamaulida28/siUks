<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Halaman laporan dan filter.
     */
    public function index(Request $request)
    {
        $preset = $request->get('preset', 'this_month');
        $dates = $this->resolveDates($preset, $request->start_date, $request->end_date);
        $startDate = $dates['start'];
        $endDate = $dates['end'];

        $query = Visit::with(['student.schoolClass', 'officer'])
            ->whereBetween('visit_date', [$startDate, $endDate]);

        if ($request->filled('class_id')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('class_id', $request->class_id);
            });
        }

        if ($request->filled('complaint_type')) {
            $query->where('complaint_type', $request->complaint_type);
        }

        if ($request->filled('final_status')) {
            $query->where('final_status', $request->final_status);
        }

        $visits = (clone $query)->orderBy('visit_date', 'desc')->orderBy('arrival_time', 'desc')->get();

        // Metrik Laporan
        $totalVisits = $visits->count();
        $totalUniqueStudents = $visits->pluck('student_id')->unique()->count();

        // Keluhan Terbanyak dalam periode ini
        $topComplaint = (clone $query)
            ->select('complaint_type', DB::raw('count(*) as total'))
            ->groupBy('complaint_type')
            ->orderByDesc('total')
            ->first();

        // Kelas dengan Kunjungan Terbanyak dalam periode ini
        $topClass = (clone $query)
            ->join('students', 'visits.student_id', '=', 'students.id')
            ->join('classes', 'students.class_id', '=', 'classes.id')
            ->select('classes.name as class_name', DB::raw('count(visits.id) as total'))
            ->groupBy('classes.id', 'classes.name')
            ->orderByDesc('total')
            ->first();

        $classes = SchoolClass::active()->orderBy('name')->get();
        $complaints = Visit::COMPLAINTS;
        $statuses = Visit::FINAL_STATUSES;

        return view('admin.reports.index', compact(
            'visits',
            'preset',
            'startDate',
            'endDate',
            'totalVisits',
            'totalUniqueStudents',
            'topComplaint',
            'topClass',
            'classes',
            'complaints',
            'statuses'
        ));
    }

    /**
     * Cetak Laporan Format Dokumen Resmi Sekolah.
     */
    public function print(Request $request)
    {
        $preset = $request->get('preset', 'this_month');
        $dates = $this->resolveDates($preset, $request->start_date, $request->end_date);
        $startDate = $dates['start'];
        $endDate = $dates['end'];

        $query = Visit::with(['student.schoolClass', 'officer'])
            ->whereBetween('visit_date', [$startDate, $endDate]);

        if ($request->filled('class_id')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('class_id', $request->class_id);
            });
        }

        if ($request->filled('complaint_type')) {
            $query->where('complaint_type', $request->complaint_type);
        }

        if ($request->filled('final_status')) {
            $query->where('final_status', $request->final_status);
        }

        $visits = (clone $query)->orderBy('visit_date', 'asc')->orderBy('arrival_time', 'asc')->get();

        $totalVisits = $visits->count();
        $totalUniqueStudents = $visits->pluck('student_id')->unique()->count();

        $topComplaint = (clone $query)
            ->select('complaint_type', DB::raw('count(*) as total'))
            ->groupBy('complaint_type')
            ->orderByDesc('total')
            ->first();

        $topClass = (clone $query)
            ->join('students', 'visits.student_id', '=', 'students.id')
            ->join('classes', 'students.class_id', '=', 'classes.id')
            ->select('classes.name as class_name', DB::raw('count(visits.id) as total'))
            ->groupBy('classes.id', 'classes.name')
            ->orderByDesc('total')
            ->first();

        return view('admin.reports.print', compact(
            'visits',
            'startDate',
            'endDate',
            'totalVisits',
            'totalUniqueStudents',
            'topComplaint',
            'topClass'
        ));
    }

    /**
     * Export data laporan ke CSV / Excel.
     */
    public function exportCsv(Request $request)
    {
        $preset = $request->get('preset', 'this_month');
        $dates = $this->resolveDates($preset, $request->start_date, $request->end_date);
        $startDate = $dates['start'];
        $endDate = $dates['end'];

        $query = Visit::with(['student.schoolClass', 'officer'])
            ->whereBetween('visit_date', [$startDate, $endDate]);

        if ($request->filled('class_id')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('class_id', $request->class_id);
            });
        }

        if ($request->filled('complaint_type')) {
            $query->where('complaint_type', $request->complaint_type);
        }

        if ($request->filled('final_status')) {
            $query->where('final_status', $request->final_status);
        }

        $visits = (clone $query)->orderBy('visit_date', 'asc')->orderBy('arrival_time', 'asc')->get();

        $filename = "Laporan_Kunjungan_UKS_{$startDate}_sd_{$endDate}.csv";

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($visits) {
            $file = fopen('php://output', 'w');
            // Menulis UTF-8 BOM agar Excel membaca karakter dengan benar
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'No',
                'Tanggal Kunjungan',
                'Jam Datang',
                'Jam Selesai',
                'Jam Pelajaran',
                'Mata Pelajaran/Guru',
                'NIS',
                'Nama Siswa',
                'Kelas',
                'Jenis Keluhan',
                'Rincian Keluhan',
                'Suhu Tubuh (C)',
                'Tekanan Darah',
                'Kondisi Umum',
                'Tindakan Petugas',
                'Status Akhir',
                'Catatan',
                'Petugas UKS',
            ]);

            foreach ($visits as $index => $v) {
                fputcsv($file, [
                    $index + 1,
                    $v->visit_date->format('d/m/Y'),
                    substr($v->arrival_time, 0, 5),
                    $v->departure_time ? substr($v->departure_time, 0, 5) : '-',
                    $v->lesson_period,
                    $v->subject ?? '-',
                    $v->student?->nis ?? '-',
                    $v->student?->name ?? '-',
                    $v->student?->schoolClass?->name ?? '-',
                    $v->complaint_type,
                    $v->complaint,
                    $v->temperature ? $v->temperature : '-',
                    $v->blood_pressure ?? '-',
                    $v->general_condition ?? '-',
                    $v->treatment,
                    $v->final_status,
                    $v->notes ?? '-',
                    $v->officer?->name ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Resolusi rentang tanggal dari preset.
     */
    private function resolveDates(string $preset, ?string $customStart, ?string $customEnd): array
    {
        $today = Carbon::today();

        return match ($preset) {
            'today' => [
                'start' => $today->toDateString(),
                'end' => $today->toDateString(),
            ],
            'this_week' => [
                'start' => $today->startOfWeek()->toDateString(),
                'end' => $today->endOfWeek()->toDateString(),
            ],
            'this_month' => [
                'start' => $today->startOfMonth()->toDateString(),
                'end' => $today->endOfMonth()->toDateString(),
            ],
            'this_year' => [
                'start' => $today->startOfYear()->toDateString(),
                'end' => $today->endOfYear()->toDateString(),
            ],
            'custom' => [
                'start' => $customStart ?: $today->startOfMonth()->toDateString(),
                'end' => $customEnd ?: $today->toDateString(),
            ],
            default => [
                'start' => $today->startOfMonth()->toDateString(),
                'end' => $today->endOfMonth()->toDateString(),
            ],
        };
    }
}
