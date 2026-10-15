<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    /**
     * Dashboard khusus Siswa.
     */
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return view('student.no_profile');
        }

        $totalVisits = $student->visits()->count();
        $latestVisit = $student->visits()->first();
        $isInUksNow = $student->isCurrentlyInUks();

        $visits = $student->visits()
            ->with('officer')
            ->paginate(10);

        return view('student.dashboard', compact('student', 'totalVisits', 'latestVisit', 'isInUksNow', 'visits'));
    }
}
