@extends('layouts.app')

@section('title', 'Dashboard Utama')
@section('page_title', 'Dashboard Statistik UKS')
@section('page_description', 'Pantau ringkasan kunjungan siswa dan analisis kesehatan terkini secara real-time')

@section('header_actions')
    <a href="{{ route('admin.visits.create') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-emerald-600/20 transition-all flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
        <span>Catat Kunjungan Baru</span>
    </a>
@endsection

@section('content')
<div class="space-y-8">

    <!-- 1. STATISTIC CARDS -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-5">
        <!-- Kunjungan Hari Ini -->
        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-slate-200 shadow-xs hover:border-emerald-300 transition-all group">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-400">Hari Ini</span>
                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-slate-900 mt-1.5 sm:mt-2">{{ $visitsToday }}</p>
            <p class="text-[10px] sm:text-xs text-slate-500 mt-0.5 sm:mt-1 font-medium">Kunjungan hari ini</p>
        </div>

        <!-- Kunjungan Bulan Ini -->
        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-slate-200 shadow-xs hover:border-teal-300 transition-all group">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-400">Bulan Ini</span>
                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center group-hover:bg-teal-600 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-slate-900 mt-1.5 sm:mt-2">{{ $visitsThisMonth }}</p>
            <p class="text-[10px] sm:text-xs text-slate-500 mt-0.5 sm:mt-1 font-medium">{{ now()->translatedFormat('M Y') }}</p>
        </div>

        <!-- Total Siswa Berkunjung -->
        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-slate-200 shadow-xs hover:border-blue-300 transition-all group">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-400">Total Siswa</span>
                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-slate-900 mt-1.5 sm:mt-2">{{ $totalStudentsVisited }}</p>
            <p class="text-[10px] sm:text-xs text-slate-500 mt-0.5 sm:mt-1 font-medium">Pernah ke UKS</p>
        </div>

        <!-- Siswa Sedang di UKS -->
        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-amber-200/80 shadow-xs hover:border-amber-400 transition-all group relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-1.5">
                    <span class="relative flex h-2 w-2 sm:h-2.5 sm:w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 sm:h-2.5 sm:w-2.5 bg-amber-500"></span>
                    </span>
                    <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-amber-800">Di UKS</span>
                </div>
                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-amber-700 mt-1.5 sm:mt-2">{{ $studentsInUksNow }}</p>
            <p class="text-[10px] sm:text-xs text-slate-500 mt-0.5 sm:mt-1 font-medium">Sedang dirawat</p>
        </div>

        <!-- Keluhan Terbanyak -->
        <div class="col-span-2 lg:col-span-1 bg-white rounded-2xl p-3.5 sm:p-5 border border-slate-200 shadow-xs hover:border-indigo-300 transition-all group">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-400">Kasus Terbanyak</span>
                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
            <p class="text-xl sm:text-2xl font-black text-slate-900 mt-1.5 sm:mt-2 truncate" title="{{ $topComplaintName }}">{{ $topComplaintName }}</p>
            <p class="text-[10px] sm:text-xs text-slate-500 mt-0.5 sm:mt-1 font-medium">{{ $topComplaintCount }} kali tercatat</p>
        </div>
    </div>

    <!-- 2. ANALYTICS CHARTS SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
        <!-- Chart 1: Tren Harian -->
        <div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Tren Kunjungan Harian</h3>
                    <p class="text-xs text-slate-400">Frekuensi 7 hari terakhir</p>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-lg">7 Hari</span>
            </div>
            <div class="h-52 sm:h-64">
                <canvas id="dailyVisitsChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Kunjungan per Bulan -->
        <div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Statistik per Bulan</h3>
                    <p class="text-xs text-slate-400">Tahun {{ now()->year }}</p>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg">{{ now()->year }}</span>
            </div>
            <div class="h-52 sm:h-64">
                <canvas id="monthlyVisitsChart"></canvas>
            </div>
        </div>

        <!-- Chart 3: Jenis Keluhan Paling Sering -->
        <div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Distribusi Jenis Keluhan</h3>
                    <p class="text-xs text-slate-400">Keluhan yang paling sering dialami siswa</p>
                </div>
            </div>
            <div class="h-52 sm:h-64 flex items-center justify-center">
                <canvas id="complaintsChart"></canvas>
            </div>
        </div>

        <!-- Chart 4: Kunjungan Berdasarkan Kelas -->
        <div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Kunjungan Berdasarkan Kelas</h3>
                    <p class="text-xs text-slate-400">Daftar kelas dengan frekuensi kunjungan tertinggi</p>
                </div>
            </div>
            <div class="h-52 sm:h-64">
                <canvas id="classesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- 3. RECENT VISITS SECTION -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-4 sm:p-6 flex items-center justify-between border-b border-slate-100">
            <div>
                <h3 class="text-sm sm:text-base font-bold text-slate-900">Kunjungan Terbaru</h3>
                <p class="text-[11px] sm:text-xs text-slate-500 mt-0.5">Daftar siswa yang baru saja berkunjung ke UKS</p>
            </div>
            <a href="{{ route('admin.visits.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                <span>Lihat Semua</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <!-- Mobile Card View for Recent Visits (Visible on Mobile / Hidden on Desktop) -->
        <div class="divide-y divide-slate-100 lg:hidden">
            @forelse($recentVisits as $visit)
                <div class="p-4 hover:bg-slate-50/70 transition-colors">
                    <div class="flex items-start justify-between gap-3 mb-2.5">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-9 h-9 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold flex items-center justify-center shrink-0">
                                {{ strtoupper(substr($visit->student?->name ?? 'UK', 0, 2)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-900 truncate">{{ $visit->student?->name ?? 'Siswa' }}</p>
                                <p class="text-[11px] text-slate-400">NIS: {{ $visit->student?->nis ?? '-' }} • <span class="text-emerald-700 font-semibold">{{ $visit->student?->schoolClass?->name ?? '-' }}</span></p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold shrink-0 {{ $visit->status_badge_class }}">
                            {{ $visit->final_status }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-2 text-[11px] text-slate-600 bg-slate-50 p-2.5 rounded-xl mb-3">
                        <div>
                            <span class="text-slate-400 block text-[10px]">Waktu & Jam</span>
                            <span class="font-bold text-slate-800">{{ $visit->visit_date->format('d/m/Y') }}</span>
                            <span class="text-slate-500 block">{{ substr($visit->arrival_time, 0, 5) }} WIB ({{ $visit->lesson_period }})</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px]">Keluhan</span>
                            <span class="font-bold text-rose-600">{{ $visit->complaint_type }}</span>
                            <span class="text-slate-500 block truncate" title="{{ $visit->complaint }}">{{ $visit->complaint }}</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs pt-1">
                        <span class="text-[11px] text-slate-400">Petugas: <strong class="text-slate-700">{{ $visit->officer?->name ?? 'Petugas UKS' }}</strong></span>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.visits.show', $visit) }}" class="px-2.5 py-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition-colors">
                                Rekam
                            </a>
                            <a href="{{ route('admin.visits.edit', $visit) }}" class="px-2.5 py-1 text-[11px] font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-slate-400 text-xs font-medium">
                    Belum ada data kunjungan yang tercatat.
                </div>
            @endforelse
        </div>

        <!-- Desktop Table for Recent Visits (Hidden on Mobile) -->
        <div class="overflow-x-auto hidden lg:block">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/75 text-[11px] uppercase tracking-wider text-slate-400 font-bold border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Siswa</th>
                        <th class="py-3.5 px-4">Kelas</th>
                        <th class="py-3.5 px-4">Waktu</th>
                        <th class="py-3.5 px-4">Jam Pelajaran</th>
                        <th class="py-3.5 px-4">Keluhan</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Petugas</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($recentVisits as $visit)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold flex items-center justify-center">
                                        {{ strtoupper(substr($visit->student?->name ?? 'UK', 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $visit->student?->name ?? 'Siswa' }}</p>
                                        <p class="text-xs text-slate-400">NIS: {{ $visit->student?->nis ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-xs font-semibold text-slate-600">
                                {{ $visit->student?->schoolClass?->name ?? '-' }}
                            </td>
                            <td class="py-4 px-4 text-xs">
                                <p class="font-semibold text-slate-800">{{ $visit->visit_date->format('d/m/Y') }}</p>
                                <p class="text-slate-400">{{ substr($visit->arrival_time, 0, 5) }} WIB</p>
                            </td>
                            <td class="py-4 px-4 text-xs text-slate-600 font-semibold">
                                {{ $visit->lesson_period }}
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-700">
                                    {{ $visit->complaint_type }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $visit->status_badge_class }}">
                                    {{ $visit->final_status }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-xs text-slate-500">
                                {{ $visit->officer?->name ?? 'Petugas UKS' }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.visits.show', $visit) }}" title="Lihat Rekam Kunjungan" class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('admin.visits.edit', $visit) }}" title="Edit Kunjungan" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-slate-400 font-medium">
                                Belum ada data kunjungan yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart 1: Harian (Line)
        new Chart(document.getElementById('dailyVisitsChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($dailyLabels) !!},
                datasets: [{
                    label: 'Jumlah Kunjungan',
                    data: {!! json_encode($dailyData) !!},
                    borderColor: '#059669',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.35,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#059669',
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Chart 2: Bulanan (Bar)
        new Chart(document.getElementById('monthlyVisitsChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($monthlyLabels) !!},
                datasets: [{
                    label: 'Kunjungan',
                    data: {!! json_encode($monthlyData) !!},
                    backgroundColor: '#0d9488',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Chart 3: Top Keluhan (Doughnut)
        new Chart(document.getElementById('complaintsChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($complaintLabels) !!},
                datasets: [{
                    data: {!! json_encode($complaintData) !!},
                    backgroundColor: ['#10b981', '#06b6d4', '#f59e0b', '#ec4899', '#8b5cf6', '#64748b'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
                }
            }
        });

        // Chart 4: Kunjungan per Kelas (Bar)
        new Chart(document.getElementById('classesChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($classLabels) !!},
                datasets: [{
                    label: 'Kunjungan',
                    data: {!! json_encode($classData) !!},
                    backgroundColor: '#3b82f6',
                    borderRadius: 6,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, ticks: { stepSize: 1 } },
                    y: { grid: { display: false } }
                }
            }
        });
    });
</script>
@endpush
