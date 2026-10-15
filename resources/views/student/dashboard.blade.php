@extends('layouts.student')

@section('title', 'Dashboard Siswa — ' . $student->name)

@section('content')
<div class="space-y-6">

    <!-- WELCOME & STATUS BANNER -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-700 text-white text-2xl font-black flex items-center justify-center shadow-md shadow-emerald-600/25">
                {{ strtoupper(substr($student->name, 0, 2)) }}
            </div>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Selamat Datang di SIUKS,</span>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900">{{ $student->name }}</h1>
                <p class="text-xs text-slate-500 font-medium mt-0.5">
                    NIS: <strong>{{ $student->nis }}</strong> | Kelas: <strong class="text-emerald-700">{{ $student->schoolClass->name ?? '-' }}</strong>
                </p>
            </div>
        </div>

        <!-- UKS Status Badge Card -->
        <div class="w-full md:w-auto p-4 rounded-2xl {{ $isInUksNow ? 'bg-amber-50 border border-amber-200 text-amber-900' : 'bg-slate-50 border border-slate-200 text-slate-700' }} flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl {{ $isInUksNow ? 'bg-amber-500 text-white' : 'bg-slate-200 text-slate-500' }} flex items-center justify-center shrink-0 font-bold">
                @if($isInUksNow)
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                    </span>
                @else
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                @endif
            </div>
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider block {{ $isInUksNow ? 'text-amber-700' : 'text-slate-400' }}">Status UKS Hari Ini</span>
                <p class="text-xs font-bold">
                    {{ $isInUksNow ? 'Sedang Beristirahat / Pemantauan di UKS' : 'Tidak Sedang di Ruang UKS' }}
                </p>
            </div>
        </div>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Kunjungan Saya</span>
            <p class="text-3xl font-black text-slate-900 mt-2">{{ $totalVisits }} <span class="text-sm font-medium text-slate-400">kali</span></p>
            <p class="text-xs text-slate-500 mt-1">Total riwayat tercatat sejak awal tahun ajaran</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Kunjungan Terakhir</span>
            <p class="text-xl font-black text-emerald-700 mt-2">
                {{ $latestVisit ? $latestVisit->visit_date->translatedFormat('d F Y') : 'Belum Ada' }}
            </p>
            <p class="text-xs text-slate-500 mt-1">
                {{ $latestVisit ? 'Keluhan: ' . $latestVisit->complaint_type . ' (' . $latestVisit->final_status . ')' : 'Anda belum pernah tercatat berobat ke UKS.' }}
            </p>
        </div>
    </div>

    <!-- RIWAYAT KUNJUNGAN SAYA (MOBILE CARDS & DESKTOP TABLE) -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Riwayat Kunjungan Saya</h3>
                <p class="text-xs text-slate-500 mt-0.5">Daftar pemeriksaan, tindakan obat, dan catatan petugas UKS</p>
            </div>
            <span class="text-xs font-bold px-3 py-1 bg-slate-100 rounded-lg text-slate-600">{{ $visits->total() }} Kunjungan</span>
        </div>

        <!-- Mobile Card View (block md:hidden) -->
        <div class="block md:hidden divide-y divide-slate-100">
            @forelse($visits as $visit)
                <div class="p-4 space-y-3 hover:bg-slate-50/50 transition-colors">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <span class="text-xs font-black text-slate-900">{{ $visit->visit_date->translatedFormat('d F Y') }}</span>
                            <span class="block text-[11px] text-slate-400 mt-0.5">
                                {{ substr($visit->arrival_time, 0, 5) }} {{ $visit->departure_time ? '- ' . substr($visit->departure_time, 0, 5) : '' }} WIB
                            </span>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold shrink-0 {{ $visit->status_badge_class }}">
                            {{ $visit->final_status }}
                        </span>
                    </div>

                    <!-- Period & Subject Pill -->
                    <div class="flex items-center gap-2 text-xs">
                        <span class="px-2 py-0.5 bg-slate-100 rounded-md font-semibold text-slate-700">
                            {{ $visit->lesson_period }}
                        </span>
                        @if($visit->subject)
                            <span class="text-slate-500 text-[11px] truncate">
                                Mapel: <strong class="text-slate-700">{{ $visit->subject }}</strong>
                            </span>
                        @endif
                    </div>

                    <!-- Complaint & Treatment -->
                    <div class="bg-slate-50 p-3 rounded-xl space-y-1.5 text-xs">
                        <div>
                            <span class="text-slate-400 font-semibold block text-[10px] uppercase tracking-wider">Keluhan Siswa:</span>
                            <p class="font-bold text-slate-800">{{ $visit->complaint_type }}</p>
                            @if($visit->complaint)
                                <p class="text-slate-600 text-[11px] mt-0.5 italic">"{{ $visit->complaint }}"</p>
                            @endif
                        </div>
                        @if($visit->treatment)
                            <div class="pt-1.5 border-t border-slate-200/60">
                                <span class="text-slate-400 font-semibold block text-[10px] uppercase tracking-wider">Tindakan Petugas:</span>
                                <p class="font-medium text-slate-700">{{ $visit->treatment }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Footer & Actions -->
                    <div class="flex items-center justify-between pt-1 gap-2">
                        <span class="text-[11px] text-slate-400 truncate">Petugas: <strong class="text-slate-600">{{ $visit->officer?->name ?? '-' }}</strong></span>
                        <div class="flex items-center gap-1.5 shrink-0">
                            <a href="{{ route('student.visits.show', $visit) }}" class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold rounded-xl transition-colors">
                                Detail
                            </a>
                            <a href="{{ route('student.visits.print_permit', $visit) }}" target="_blank" title="Cetak Surat Izin" class="p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-12 px-4 text-center text-slate-400">
                    <div class="max-w-xs mx-auto">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="font-bold text-slate-700">Kondisi Anda Sehat</p>
                        <p class="text-xs text-slate-400 mt-1">Anda belum memiliki catatan keluhan atau kunjungan ke UKS.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Desktop Table View (hidden md:block) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/80 text-[11px] uppercase tracking-wider text-slate-400 font-bold border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Tanggal & Waktu</th>
                        <th class="py-3.5 px-4">Jam Pelajaran</th>
                        <th class="py-3.5 px-4">Keluhan</th>
                        <th class="py-3.5 px-4">Tindakan Petugas</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Petugas</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($visits as $visit)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-6 text-xs">
                                <span class="font-bold text-slate-900">{{ $visit->visit_date->translatedFormat('d F Y') }}</span>
                                <span class="block text-slate-400 text-[11px]">{{ substr($visit->arrival_time, 0, 5) }} {{ $visit->departure_time ? '- ' . substr($visit->departure_time, 0, 5) : '' }} WIB</span>
                            </td>
                            <td class="py-4 px-4 text-xs font-semibold text-slate-700">
                                {{ $visit->lesson_period }}
                                @if($visit->subject)
                                    <span class="block text-[11px] text-slate-400">{{ $visit->subject }}</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-slate-100 text-slate-800">
                                    {{ $visit->complaint_type }}
                                </span>
                                <p class="text-xs text-slate-500 mt-0.5 truncate max-w-[150px]" title="{{ $visit->complaint }}">{{ $visit->complaint }}</p>
                            </td>
                            <td class="py-4 px-4 text-xs text-slate-600 truncate max-w-[180px]" title="{{ $visit->treatment }}">
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
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('student.visits.show', $visit) }}" title="Lihat Detail Rekam" class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold rounded-xl transition-colors">
                                        Detail
                                    </a>
                                    <a href="{{ route('student.visits.print_permit', $visit) }}" target="_blank" title="Cetak Surat Izin" class="p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="max-w-xs mx-auto">
                                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <p class="font-bold text-slate-700">Kondisi Anda Sehat</p>
                                    <p class="text-xs text-slate-400 mt-1">Anda belum memiliki catatan keluhan atau kunjungan ke UKS.</p>
                                </div>
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
