@extends('layouts.print')

@section('title', 'Laporan Kunjungan UKS — ' . date('d/m/Y', strtotime($startDate)) . ' s/d ' . date('d/m/Y', strtotime($endDate)))

@section('content')
<div class="space-y-6">

    <!-- Judul Laporan -->
    <div class="text-center">
        <h3 class="text-base sm:text-lg font-black text-slate-950 uppercase tracking-wide">LAPORAN REKAPITULASI KUNJUNGAN SISWA KE UKS</h3>
        <p class="text-xs sm:text-sm font-bold text-slate-600 mt-1">
            Periode: {{ date('d F Y', strtotime($startDate)) }} s/d {{ date('d F Y', strtotime($endDate)) }}
        </p>
    </div>

    <!-- Ringkasan Eksekutif -->
    <div class="grid grid-cols-4 gap-3 text-xs">
        <div class="p-3 rounded-xl border border-slate-300 bg-slate-50 text-center">
            <span class="text-slate-500 font-semibold block text-[10px] uppercase tracking-wider">Total Kunjungan</span>
            <span class="text-xl font-black text-slate-900 mt-0.5 block">{{ $totalVisits }}</span>
        </div>
        <div class="p-3 rounded-xl border border-slate-300 bg-slate-50 text-center">
            <span class="text-slate-500 font-semibold block text-[10px] uppercase tracking-wider">Total Siswa</span>
            <span class="text-xl font-black text-slate-900 mt-0.5 block">{{ $totalUniqueStudents }}</span>
        </div>
        <div class="p-3 rounded-xl border border-slate-300 bg-slate-50 text-center">
            <span class="text-slate-500 font-semibold block text-[10px] uppercase tracking-wider">Keluhan Terbanyak</span>
            <span class="text-xs font-black text-slate-900 mt-1 block truncate">{{ $topComplaint ? $topComplaint->complaint_type : '-' }}</span>
        </div>
        <div class="p-3 rounded-xl border border-slate-300 bg-slate-50 text-center">
            <span class="text-slate-500 font-semibold block text-[10px] uppercase tracking-wider">Kelas Terbanyak</span>
            <span class="text-xs font-black text-slate-900 mt-1 block truncate">{{ $topClass ? $topClass->class_name : '-' }}</span>
        </div>
    </div>

    <!-- Tabel Data Kunjungan -->
    <div>
        <table class="w-full border-collapse text-[11px] text-slate-900 border border-slate-400">
            <thead>
                <tr class="bg-slate-200 border-b border-slate-400 text-slate-800 font-bold">
                    <th class="border border-slate-400 p-2 text-center w-8">No</th>
                    <th class="border border-slate-400 p-2 text-center w-20">Tanggal</th>
                    <th class="border border-slate-400 p-2 text-center w-14">Jam</th>
                    <th class="border border-slate-400 p-2 text-left">Nama Siswa</th>
                    <th class="border border-slate-400 p-2 text-center w-16">Kelas</th>
                    <th class="border border-slate-400 p-2 text-center w-16">Jam Ke</th>
                    <th class="border border-slate-400 p-2 text-left">Keluhan</th>
                    <th class="border border-slate-400 p-2 text-left">Tindakan Petugas</th>
                    <th class="border border-slate-400 p-2 text-center w-28">Status Akhir</th>
                    <th class="border border-slate-400 p-2 text-left w-24">Petugas</th>
                </tr>
            </thead>
            <tbody>
                @forelse($visits as $index => $v)
                    <tr class="border-b border-slate-300 {{ $index % 2 === 1 ? 'bg-slate-50' : 'bg-white' }}">
                        <td class="border border-slate-300 p-2 text-center font-semibold">{{ $index + 1 }}</td>
                        <td class="border border-slate-300 p-2 text-center">{{ $v->visit_date->format('d/m/Y') }}</td>
                        <td class="border border-slate-300 p-2 text-center">{{ substr($v->arrival_time, 0, 5) }}</td>
                        <td class="border border-slate-300 p-2 font-bold">{{ $v->student?->name ?? 'Siswa Terhapus' }}</td>
                        <td class="border border-slate-300 p-2 text-center">{{ $v->student?->schoolClass?->name ?? '-' }}</td>
                        <td class="border border-slate-300 p-2 text-center">{{ $v->lesson_period }}</td>
                        <td class="border border-slate-300 p-2">
                            <strong>{{ $v->complaint_type }}:</strong> {{ $v->complaint }}
                            @if($v->temperature)
                                <span class="text-slate-600 block text-[10px]">Suhu: {{ $v->temperature }}°C</span>
                            @endif
                        </td>
                        <td class="border border-slate-300 p-2">{{ $v->treatment }}</td>
                        <td class="border border-slate-300 p-2 text-center font-semibold">{{ $v->final_status }}</td>
                        <td class="border border-slate-300 p-2">{{ $v->officer?->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="border border-slate-300 p-4 text-center text-slate-500">
                            Tidak ada catatan kunjungan dalam periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Lembar Pengesahan Tanda Tangan -->
    <div class="pt-10 grid grid-cols-2 text-center text-xs sm:text-sm">
        <div>
            <p class="text-slate-600">Mengetahui,</p>
            <p class="font-bold text-slate-900">Kepala Sekolah</p>
            <div class="h-20"></div>
            <p class="font-bold text-slate-900 underline">Drs. H. Mulyadi, M.M</p>
            <p class="text-xs text-slate-500">NIP. 19680312 199403 1 004</p>
        </div>

        <div>
            <p class="text-slate-600">Jakarta, {{ date('d F Y') }}</p>
            <p class="font-bold text-slate-900">Koordinator / Petugas UKS</p>
            <div class="h-20"></div>
            <p class="font-bold text-slate-900 underline">{{ auth()->user()->name }}</p>
            <p class="text-xs text-slate-500">{{ auth()->user()->position ?? 'Petugas UKS' }}</p>
        </div>
    </div>

</div>
@endsection
