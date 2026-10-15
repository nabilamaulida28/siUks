@extends('layouts.app')

@section('title', 'Profil Siswa — ' . $student->name)
@section('page_title', 'Detail Siswa & Riwayat Medis UKS')
@section('page_description', 'Biodata lengkap siswa serta rekam jejak seluruh kunjungannya ke Unit Kesehatan Sekolah')

@section('header_actions')
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.visits.create') }}?student_id={{ $student->id }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-xs transition-colors flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>+ Catat Kunjungan Siswa Ini</span>
        </a>
        <a href="{{ route('admin.students.edit', $student) }}" class="px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-xs transition-colors flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            <span>Edit</span>
        </a>
    </div>
@endsection

@section('content')
<div class="space-y-6">

    <!-- STUDENT HEADER & STATS OVERVIEW -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-xs p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                <div class="w-20 h-20 rounded-2xl {{ $student->gender === 'L' ? 'bg-blue-600' : 'bg-pink-600' }} text-white text-2xl font-black flex items-center justify-center shrink-0 shadow-md">
                    {{ strtoupper(substr($student->name, 0, 2)) }}
                </div>
                <div class="flex-1 text-center sm:text-left">
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mb-1">
                        <h2 class="text-xl font-black text-slate-900">{{ $student->name }}</h2>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $student->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                            {{ $student->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 font-medium">
                        NIS: <strong>{{ $student->nis }}</strong> • NISN: {{ $student->nisn ?: '-' }} • Kelas: <strong class="text-emerald-700">{{ $student->schoolClass->name ?? '-' }}</strong>
                    </p>

                    <!-- Biodata Grid -->
                    <div class="mt-6 pt-6 border-t border-slate-100 grid grid-cols-2 sm:grid-cols-3 gap-4 text-xs">
                        <div>
                            <span class="text-slate-400 font-semibold block">Jenis Kelamin</span>
                            <span class="font-bold text-slate-800">{{ $student->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-semibold block">Tempat, Tanggal Lahir</span>
                            <span class="font-bold text-slate-800">{{ $student->birth_place ?: '-' }}, {{ $student->birth_date ? $student->birth_date->format('d/m/Y') : '-' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-semibold block">Nomor HP Siswa</span>
                            <span class="font-bold text-slate-800">{{ $student->phone ?: '-' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-semibold block">Nama Orang Tua / Wali</span>
                            <span class="font-bold text-slate-800">{{ $student->parent_name ?: '-' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-semibold block">No. HP Orang Tua</span>
                            <span class="font-bold text-slate-800">{{ $student->parent_phone ?: '-' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-semibold block">Akun Login Siswa</span>
                            <span class="font-bold {{ $student->user ? 'text-emerald-600' : 'text-slate-400' }}">
                                {{ $student->user ? $student->user->email : 'Belum Dibuat' }}
                            </span>
                        </div>
                        <div class="col-span-2 sm:col-span-3">
                            <span class="text-slate-400 font-semibold block">Alamat</span>
                            <span class="font-medium text-slate-700">{{ $student->address ?: 'Alamat belum dilengkapi.' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- UKS Stats Widget -->
        <div class="bg-gradient-to-br from-emerald-600 to-teal-700 rounded-2xl p-6 sm:p-8 text-white flex flex-col justify-between shadow-md shadow-emerald-700/20">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-200 block mb-1">Statistik Kunjungan UKS</span>
                <p class="text-4xl font-black">{{ $totalVisits }} <span class="text-lg font-medium text-emerald-200">Kali</span></p>
                <p class="text-xs text-emerald-100 mt-1">Total kunjungan siswa ini ke ruang UKS</p>
            </div>

            <div class="mt-6 pt-6 border-t border-white/15 space-y-3 text-xs">
                <div>
                    <span class="text-emerald-200 font-semibold block">Status Saat Ini:</span>
                    @if($student->isCurrentlyInUks())
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-400 text-amber-950 font-bold text-xs mt-1">
                            <span class="w-2 h-2 rounded-full bg-amber-600 animate-pulse"></span>
                            Sedang di Ruang UKS
                        </span>
                    @else
                        <span class="font-bold text-white mt-0.5 block">Di Luar Ruang UKS / Kelas</span>
                    @endif
                </div>

                <div>
                    <span class="text-emerald-200 font-semibold block">Kunjungan Terakhir:</span>
                    <span class="font-bold text-white mt-0.5 block">
                        {{ $latestVisit ? $latestVisit->visit_date->translatedFormat('d F Y') . ' (' . $latestVisit->complaint_type . ')' : 'Belum pernah berkunjung' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- STUDENT VISITS HISTORY (MOBILE CARDS & DESKTOP TABLE) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Riwayat Kunjungan UKS Siswa</h3>
                <p class="text-xs text-slate-500 mt-0.5">Daftar seluruh riwayat penanganan kesehatan siswa ini</p>
            </div>
            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-lg">{{ $visits->total() }} Catatan</span>
        </div>

        <!-- Mobile Card View (block md:hidden) -->
        <div class="block md:hidden divide-y divide-slate-100">
            @forelse($visits as $index => $visit)
                <div class="p-4 space-y-2.5 hover:bg-slate-50/50 transition-colors">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <span class="text-xs font-black text-slate-900">{{ $visit->visit_date->format('d/m/Y') }}</span>
                            <span class="block text-[11px] text-slate-400 mt-0.5">{{ substr($visit->arrival_time, 0, 5) }} WIB • {{ $visit->lesson_period }}</span>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold shrink-0 {{ $visit->status_badge_class }}">
                            {{ $visit->final_status }}
                        </span>
                    </div>

                    <!-- Complaint & Vitals -->
                    <div class="bg-slate-50 p-2.5 rounded-xl space-y-1 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-slate-800">{{ $visit->complaint_type }}</span>
                            @if($visit->temperature || $visit->blood_pressure)
                                <span class="text-[11px] text-slate-500 font-medium">
                                    {{ $visit->temperature ? $visit->temperature . '°C' : '' }}
                                    {{ $visit->blood_pressure ? '• ' . $visit->blood_pressure : '' }}
                                </span>
                            @endif
                        </div>
                        @if($visit->complaint)
                            <p class="text-slate-600 text-[11px] italic">"{{ $visit->complaint }}"</p>
                        @endif
                        @if($visit->treatment)
                            <p class="text-slate-500 text-[11px] pt-1 border-t border-slate-200/50">
                                Tindakan: <span class="text-slate-700 font-medium">{{ $visit->treatment }}</span>
                            </p>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-1 text-xs">
                        <span class="text-[11px] text-slate-400">Petugas: <strong class="text-slate-600">{{ $visit->officer?->name ?? '-' }}</strong></span>
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('admin.visits.show', $visit) }}" class="px-2.5 py-1 bg-emerald-50 text-emerald-700 font-bold rounded-lg text-xs hover:bg-emerald-100 transition-colors">
                                Rekam Medis
                            </a>
                            <a href="{{ route('admin.visits.print_permit', $visit) }}" target="_blank" title="Cetak Surat Izin" class="p-1 text-slate-400 hover:text-slate-700 rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-8 px-4 text-center text-slate-400 text-xs">
                    Siswa ini belum memiliki catatan riwayat kunjungan ke UKS.
                </div>
            @endforelse
        </div>

        <!-- Desktop Table View (hidden md:block) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/80 text-[11px] uppercase tracking-wider text-slate-400 font-bold border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Tanggal Kunjungan</th>
                        <th class="py-3.5 px-4">Jam Pelajaran</th>
                        <th class="py-3.5 px-4">Keluhan</th>
                        <th class="py-3.5 px-4">Tanda Vital</th>
                        <th class="py-3.5 px-4">Tindakan</th>
                        <th class="py-3.5 px-4">Status Akhir</th>
                        <th class="py-3.5 px-4">Petugas</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($visits as $index => $visit)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-4 text-center text-xs text-slate-400">
                                {{ $visits->firstItem() + $index }}
                            </td>
                            <td class="py-4 px-4 text-xs font-bold text-slate-900">
                                {{ $visit->visit_date->format('d/m/Y') }}
                                <span class="block text-[11px] font-normal text-slate-400">{{ substr($visit->arrival_time, 0, 5) }} WIB</span>
                            </td>
                            <td class="py-4 px-4 text-xs font-semibold text-slate-700">
                                {{ $visit->lesson_period }}
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-slate-100 text-slate-800">
                                    {{ $visit->complaint_type }}
                                </span>
                                <p class="text-xs text-slate-500 mt-1 max-w-[150px] truncate" title="{{ $visit->complaint }}">
                                    {{ $visit->complaint }}
                                </p>
                            </td>
                            <td class="py-4 px-4 text-xs text-slate-600">
                                @if($visit->temperature)
                                    <span>{{ $visit->temperature }}°C</span>
                                @endif
                                @if($visit->blood_pressure)
                                    <span class="block text-[11px] text-slate-400">{{ $visit->blood_pressure }} mmHg</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-xs text-slate-600 max-w-[160px] truncate" title="{{ $visit->treatment }}">
                                {{ $visit->treatment }}
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $visit->status_badge_class }}">
                                    {{ $visit->final_status }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-xs text-slate-500">
                                {{ $visit->officer?->name ?? '-' }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.visits.show', $visit) }}" title="Lihat Rekam Kunjungan" class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('admin.visits.print_permit', $visit) }}" target="_blank" title="Cetak Surat Izin UKS" class="p-1.5 text-slate-400 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-8 text-center text-slate-400 font-medium">
                                Siswa ini belum memiliki catatan riwayat kunjungan ke UKS.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($visits->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $visits->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
