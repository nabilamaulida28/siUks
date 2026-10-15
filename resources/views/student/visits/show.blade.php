@extends('layouts.student')

@section('title', 'Detail Kunjungan UKS')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
        <a href="{{ route('student.dashboard') }}" class="w-full sm:w-auto justify-center px-4 py-2.5 bg-white hover:bg-slate-100 text-slate-700 text-xs font-bold rounded-xl border border-slate-200 transition-colors flex items-center gap-1.5 shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Kembali ke Riwayat</span>
        </a>

        <a href="{{ route('student.visits.print_permit', $visit) }}" target="_blank" class="w-full sm:w-auto justify-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-xs transition-colors flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            <span>Cetak Surat Izin / Keterangan</span>
        </a>
    </div>

    <!-- Rekam Kunjungan Card (Read Only) -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 sm:p-8 bg-gradient-to-r from-emerald-600 to-teal-700 text-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-widest text-emerald-200">Rekam Kunjungan Anda</span>
                <h2 class="text-xl sm:text-2xl font-black mt-0.5">{{ $visit->visit_date->translatedFormat('l, d F Y') }}</h2>
                <p class="text-xs text-emerald-100 mt-1">Pukul {{ substr($visit->arrival_time, 0, 5) }} WIB • {{ $visit->lesson_period }}</p>
            </div>
            <div>
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black shadow-xs bg-white text-slate-900">
                    {{ $visit->final_status }}
                </span>
            </div>
        </div>

        <div class="p-6 sm:p-8 space-y-6">
            <!-- Vitals Bar -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold">
                        °C
                    </div>
                    <div>
                        <span class="text-[11px] font-semibold text-slate-400 block">Suhu Tubuh</span>
                        <span class="text-lg font-black text-slate-900">{{ $visit->temperature ? $visit->temperature . ' °C' : '-' }}</span>
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                        BP
                    </div>
                    <div>
                        <span class="text-[11px] font-semibold text-slate-400 block">Tekanan Darah</span>
                        <span class="text-lg font-black text-slate-900">{{ $visit->blood_pressure ? $visit->blood_pressure . ' mmHg' : '-' }}</span>
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                        GC
                    </div>
                    <div>
                        <span class="text-[11px] font-semibold text-slate-400 block">Kondisi Umum</span>
                        <span class="text-sm font-bold text-slate-900">{{ $visit->general_condition ?: '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Keluhan Siswa -->
            <div class="border border-slate-200 rounded-2xl p-5">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-2">Keluhan yang Anda Rasakan</span>
                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-black bg-rose-50 text-rose-700 border border-rose-200 mb-3">
                    {{ $visit->complaint_type }}
                </span>
                <p class="text-sm text-slate-800 leading-relaxed font-medium">
                    {{ $visit->complaint }}
                </p>
            </div>

            <!-- Tindakan & Obat -->
            <div class="border border-slate-200 rounded-2xl p-5">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 block mb-2">Tindakan & Pengobatan dari Petugas</span>
                <div class="p-4 rounded-xl bg-emerald-50/50 border border-emerald-100 text-sm text-slate-800 font-medium leading-relaxed">
                    {{ $visit->treatment }}
                </div>
            </div>

            <!-- Catatan Petugas -->
            @if($visit->notes)
                <div class="border border-slate-200 rounded-2xl p-5">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-2">Pesan & Catatan Petugas</span>
                    <p class="text-sm text-slate-700 italic">
                        "{{ $visit->notes }}"
                    </p>
                </div>
            @endif

            <!-- Info Petugas -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Pelajaran yang sedang berlangsung: <strong class="text-slate-800">{{ $visit->subject ?: '-' }}</strong></span>
                <span>Ditangani oleh: <strong class="text-slate-800">{{ $visit->officer?->name ?? 'Petugas UKS' }}</strong></span>
            </div>
        </div>
    </div>

</div>
@endsection
