<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OfficerController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\VisitController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\StudentVisitController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - SIUKS (Sistem Informasi Kunjungan UKS)
|--------------------------------------------------------------------------
*/

// Halaman Utama: Redirect berdasarkan status login
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'student') {
            return redirect()->route('student.dashboard');
        }
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('login');
});

// Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Bersama (Harus Login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
});

// -------------------------------------------------------------
// Route Admin & Petugas UKS
// -------------------------------------------------------------
Route::middleware(['auth', 'role:admin,officer'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Kunjungan UKS
        Route::get('/visits/{visit}/print-permit', [VisitController::class, 'printPermit'])->name('visits.print_permit');
        Route::resource('visits', VisitController::class);

        // Data Siswa
        Route::resource('students', StudentController::class);

        // Data Kelas
        Route::resource('classes', SchoolClassController::class);

        // Data Petugas UKS
        Route::resource('officers', OfficerController::class);

        // Laporan & Rekapitulasi
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/print', [ReportController::class, 'print'])->name('reports.print');
        Route::get('/reports/export-csv', [ReportController::class, 'exportCsv'])->name('reports.export_csv');
    });

// -------------------------------------------------------------
// Route Siswa
// -------------------------------------------------------------
Route::middleware(['auth', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/visits/{visit}/print-permit', [StudentVisitController::class, 'printPermit'])->name('visits.print_permit');
        Route::get('/visits/{visit}', [StudentVisitController::class, 'show'])->name('visits.show');
    });
