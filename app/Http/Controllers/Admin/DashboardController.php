<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Metrik Statistik
        $visitsToday = Visit::whereDate('visit_date', $today)->count();
        $visitsThisMonth = Visit::whereMonth('visit_date', $currentMonth)
            ->whereYear('visit_date', $currentYear)
            ->count();
        $totalStudentsVisited = Visit::distinct('student_id')->count('student_id');
        $studentsInUksNow = Visit::whereDate('visit_date', $today)
            ->whereIn('final_status', ['Istirahat di UKS', 'Masih dalam pemantauan'])
            ->count();

        // Keluhan terbanyak
        $topComplaintData = Visit::select('complaint_type', DB::raw('count(*) as total'))
            ->groupBy('complaint_type')
            ->orderByDesc('total')
            ->first();

        $topComplaintName = $topComplaintData ? $topComplaintData->complaint_type : '-';
        $topComplaintCount = $topComplaintData ? $topComplaintData->total : 0;

        // 1. Chart: Kunjungan 7 Hari Terakhir
        $dailyLabels = [];
        $dailyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateStr = $date->toDateString();
            $dailyLabels[] = $date->translatedFormat('d M');
            $dailyData[] = Visit::whereDate('visit_date', $dateStr)->count();
        }

        // 2. Chart: Kunjungan per Bulan (Tahun Berjalan)
        $monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $monthlyData = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyData[] = Visit::whereMonth('visit_date', $m)
                ->whereYear('visit_date', $currentYear)
                ->count();
        }

        // 3. Chart: Distribusi Jenis Keluhan Terbanyak (Top 6)
        $complaintStats = Visit::select('complaint_type', DB::raw('count(*) as count'))
            ->groupBy('complaint_type')
            ->orderByDesc('count')
            ->limit(6)
            ->get();
        $complaintLabels = $complaintStats->pluck('complaint_type')->toArray();
        $complaintData = $complaintStats->pluck('count')->toArray();

        // 4. Chart: Kunjungan Berdasarkan Kelas (Top 8)
        $classStats = Visit::join('students', 'visits.student_id', '=', 'students.id')
            ->join('classes', 'students.class_id', '=', 'classes.id')
            ->select('classes.name as class_name', DB::raw('count(visits.id) as total'))
            ->groupBy('classes.id', 'classes.name')
            ->orderByDesc('total')
            ->limit(8)
            ->get();
        $classLabels = $classStats->pluck('class_name')->toArray();
        $classData = $classStats->pluck('total')->toArray();

        // Kunjungan Terbaru
        $recentVisits = Visit::with(['student.schoolClass', 'officer'])
            ->orderBy('visit_date', 'desc')
            ->orderBy('arrival_time', 'desc')
            ->limit(8)
            ->get();

        return view('admin.dashboard', compact(
            'visitsToday',
            'visitsThisMonth',
            'totalStudentsVisited',
            'studentsInUksNow',
            'topComplaintName',
            'topComplaintCount',
            'dailyLabels',
            'dailyData',
            'monthlyLabels',
            'monthlyData',
            'complaintLabels',
            'complaintData',
            'classLabels',
            'classData',
            'recentVisits'
        ));
    }
}
