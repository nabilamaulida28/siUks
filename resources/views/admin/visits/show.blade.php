@extends('layouts.app')

@section('title', 'Rekam Kunjungan UKS — ' . ($visit->student?->name ?? 'Siswa'))
@section('page_title', 'Kartu Rekam Kunjungan UKS')
@section('page_description', 'Dokumentasi detail rekam medis kunjungan siswa ke Unit Kesehatan Sekolah')

@section('header_actions')
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.visits.print_permit', $visit) }}" target="_blank" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl shadow-xs transition-colors flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            <span>Cetak Surat Izin UKS</span>
        </a>
        <a href="{{ route('admin.visits.edit', $visit) }}" class="px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-xs transition-colors flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            <span>Edit</span>
        </a>
    </div>
@endsection

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- REKAM KUNJUNGAN CARD -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        
        <!-- Card Header Banner -->
        <div class="p-6 sm:p-8 bg-gradient-to-r from-emerald-600 to-teal-700 text-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-white/15 backdrop-blur-md flex items-center justify-center text-white ring-1 ring-white/30 shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-widest text-emerald-200">Rekam Kunjungan UKS</span>
                    <h2 class="text-xl sm:text-2xl font-black tracking-tight">{{ $visit->student?->name ?? 'Siswa Terhapus' }}</h2>
                    <p class="text-xs text-emerald-100 font-medium">No. Rekam: UKS-{{ $visit->visit_date->format('Ymd') }}-{{ str_pad($visit->id, 4, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>

            <!-- Status Badge in Header -->
            <div class="sm:text-right">
                <span class="text-[11px] uppercase tracking-wider block text-emerald-200 font-bold mb-1">Status Kunjungan</span>
                <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-black shadow-xs bg-white text-slate-900">
                    {{ $visit->final_status }}
                </span>
            </div>
        </div>

        <!-- Card Body -->
        <div class="p-6 sm:p-8 space-y-8">

            <!-- SECTION A: BIODATA SISWA & JADWAL KUNJUNGAN -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Info Siswa -->
                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Informasi Siswa
                    </h4>
                    <dl class="grid grid-cols-2 gap-x-4 gap-y-3 text-xs">
                        <div>
                            <dt class="text-slate-400 font-semibold">Nama Lengkap</dt>
                            <dd class="font-bold text-slate-900 mt-0.5">{{ $visit->student?->name ?? 'Siswa Terhapus' }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-400 font-semibold">Kelas</dt>
                            <dd class="font-bold text-slate-900 mt-0.5">{{ $visit->student?->schoolClass?->name ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-400 font-semibold">NIS / NISN</dt>
                            <dd class="font-bold text-slate-900 mt-0.5">{{ $visit->student?->nis ?? '-' }} {{ $visit->student?->nisn ? ' / ' . $visit->student->nisn : '' }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-400 font-semibold">Jenis Kelamin</dt>
                            <dd class="font-bold text-slate-900 mt-0.5">{{ ($visit->student?->gender ?? 'L') === 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-400 font-semibold">Kontak Orang Tua</dt>
                            <dd class="font-bold text-slate-900 mt-0.5">{{ $visit->student?->parent_name ?? '-' }} ({{ $visit->student?->parent_phone ?? '-' }})</dd>
                        </div>
                        <div>
                            <dt class="text-slate-400 font-semibold">Profil Lengkap</dt>
                            <dd class="mt-0.5">
                                @if($visit->student)
                                    <a href="{{ route('admin.students.show', $visit->student) }}" class="text-emerald-600 hover:text-emerald-700 font-bold underline">Lihat Biodata</a>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Info Kunjungan & Waktu -->
                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Waktu & Jam Pelajaran
                    </h4>
                    <dl class="grid grid-cols-2 gap-x-4 gap-y-3 text-xs">
                        <div>
                            <dt class="text-slate-400 font-semibold">Tanggal Kunjungan</dt>
                            <dd class="font-bold text-slate-900 mt-0.5">{{ $visit->visit_date->translatedFormat('l, d F Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-400 font-semibold">Jam Pelajaran</dt>
                            <dd class="font-bold text-emerald-700 mt-0.5">{{ $visit->lesson_period }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-400 font-semibold">Jam Datang - Selesai</dt>
                            <dd class="font-bold text-slate-900 mt-0.5">
                                {{ substr($visit->arrival_time, 0, 5) }} WIB - {{ $visit->departure_time ? substr($visit->departure_time, 0, 5) . ' WIB' : 'Masih di UKS' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-slate-400 font-semibold">Pelajaran / Guru</dt>
                            <dd class="font-bold text-slate-900 mt-0.5">{{ $visit->subject ?? 'Tidak ditentukan' }}</dd>
                        </div>
                        <div class="col-span-2">
                            <dt class="text-slate-400 font-semibold">Petugas UKS Penanggung Jawab</dt>
                            <dd class="font-bold text-slate-900 mt-0.5 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                {{ $visit->officer?->name ?? 'Petugas UKS' }} ({{ $visit->officer?->position ?? 'Petugas' }})
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- SECTION B: KONDISI MEDIS & TANDA VITAL -->
            <div class="border border-slate-200 rounded-2xl p-6">
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    Pemeriksaan Fisik & Tanda Vital
                </h4>

                <!-- Vital Signs Bar -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
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
                            <span class="text-sm font-bold text-slate-900">{{ $visit->general_condition ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Keluhan Siswa -->
                <div class="space-y-4">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Jenis Keluhan Utama</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-black bg-rose-50 text-rose-700 border border-rose-200">
                            {{ $visit->complaint_type }}
                        </span>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Deskripsi / Rincian Keluhan</span>
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 text-sm text-slate-800 leading-relaxed font-medium">
                            {{ $visit->complaint }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION C: PENANGANAN & HASIL AKHIR -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Tindakan -->
                <div class="border border-slate-200 rounded-2xl p-6">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-emerald-700 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        Tindakan & Penanganan Petugas
                    </h4>
                    <div class="p-4 rounded-xl bg-emerald-50/50 border border-emerald-100 text-sm text-slate-800 font-medium leading-relaxed">
                        {{ $visit->treatment }}
                    </div>
                </div>

                <!-- Catatan & Status -->
                <div class="border border-slate-200 rounded-2xl p-6">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        Catatan & Instruksi Tindak Lanjut
                    </h4>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 text-sm text-slate-700 leading-relaxed font-medium">
                        {{ $visit->notes ?: 'Tidak ada catatan tambahan.' }}
                    </div>
                </div>
            </div>

        </div>

        <!-- Card Footer Actions -->
        <div class="p-6 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('admin.visits.index') }}" class="px-4 py-2 text-xs font-bold text-slate-600 hover:text-slate-800 bg-white border border-slate-200 rounded-xl transition-colors">
                &larr; Kembali ke Daftar
            </a>

            <div class="flex items-center gap-2">
                <form action="{{ route('admin.visits.destroy', $visit) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan kunjungan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-xl transition-colors">
                        Hapus Kunjungan
                    </button>
                </form>
                <a href="{{ route('admin.visits.edit', $visit) }}" class="px-5 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors">
                    Edit Catatan
                </a>
            </div>
        </div>
    </div>

    <!-- RIWAYAT KUNJUNGAN LAIN DARI SISWA INI -->
    @if($studentHistory->isNotEmpty())
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
            <h3 class="text-sm font-bold text-slate-900 mb-4">Riwayat Kunjungan Lain dari {{ $visit->student?->name ?? 'Siswa' }}</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-400 font-bold border-b border-slate-100">
                        <tr>
                            <th class="py-2.5 px-3">Tanggal</th>
                            <th class="py-2.5 px-3">Jam Pelajaran</th>
                            <th class="py-2.5 px-3">Keluhan</th>
                            <th class="py-2.5 px-3">Tindakan</th>
                            <th class="py-2.5 px-3">Status</th>
                            <th class="py-2.5 px-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($studentHistory as $history)
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-3 font-semibold text-slate-900">{{ $history->visit_date->format('d/m/Y') }}</td>
                                <td class="py-3 px-3 text-slate-600">{{ $history->lesson_period }}</td>
                                <td class="py-3 px-3 font-bold text-slate-800">{{ $history->complaint_type }}</td>
                                <td class="py-3 px-3 text-slate-500 max-w-[200px] truncate">{{ $history->treatment }}</td>
                                <td class="py-3 px-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $history->status_badge_class }}">
                                        {{ $history->final_status }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-right">
                                    <a href="{{ route('admin.visits.show', $history) }}" class="text-emerald-600 hover:text-emerald-700 font-bold">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
@endsection
