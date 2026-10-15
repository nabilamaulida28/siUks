@extends('layouts.print')

@section('title', 'Surat Izin Kunjungan UKS — ' . ($visit->student?->name ?? 'Siswa'))

@section('content')
<div class="space-y-6">
    <!-- Judul Surat -->
    <div class="text-center">
        <h3 class="text-lg font-black text-slate-900 uppercase underline tracking-wider">SURAT KETERANGAN KUNJUNGAN UKS</h3>
        <p class="text-xs font-semibold text-slate-500 mt-1">Nomor: {{ $visit->id }}/UKS/SK/{{ $visit->visit_date->format('m/Y') }}</p>
    </div>

    <!-- Paragraf Pembuka -->
    <p class="text-xs sm:text-sm text-slate-800 leading-relaxed text-justify">
        Yang bertanda tangan di bawah ini, Petugas Unit Kesehatan Sekolah (UKS) menerangkan bahwa siswa dengan identitas sebagai berikut:
    </p>

    <!-- Data Siswa -->
    <div class="bg-slate-50/80 rounded-xl p-4 border border-slate-200">
        <table class="w-full text-xs sm:text-sm text-slate-800">
            <tbody>
                <tr class="leading-loose">
                    <td class="w-44 font-semibold text-slate-600">Nama Siswa</td>
                    <td class="w-4">:</td>
                    <td class="font-bold text-slate-900">{{ $visit->student?->name ?? 'Siswa Terhapus' }}</td>
                </tr>
                <tr class="leading-loose">
                    <td class="font-semibold text-slate-600">NIS / NISN</td>
                    <td>:</td>
                    <td>{{ $visit->student?->nis ?? '-' }} {{ $visit->student?->nisn ? ' / ' . $visit->student->nisn : '' }}</td>
                </tr>
                <tr class="leading-loose">
                    <td class="font-semibold text-slate-600">Kelas / Jurusan</td>
                    <td>:</td>
                    <td>{{ $visit->student?->schoolClass?->name ?? '-' }} ({{ $visit->student?->major ?? '-' }})</td>
                </tr>
                <tr class="leading-loose">
                    <td class="font-semibold text-slate-600">Waktu Kunjungan</td>
                    <td>:</td>
                    <td>{{ $visit->visit_date->translatedFormat('l, d F Y') }} — Pukul {{ substr($visit->arrival_time, 0, 5) }} WIB</td>
                </tr>
                <tr class="leading-loose">
                    <td class="font-semibold text-slate-600">Pada Jam Pelajaran Ke</td>
                    <td>:</td>
                    <td><strong class="text-emerald-800">{{ $visit->lesson_period }}</strong> (Mata Pelajaran: {{ $visit->subject ?: '-' }})</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Keterangan Kondisi & Tindakan -->
    <div class="space-y-3 text-xs sm:text-sm text-slate-800">
        <p class="font-bold text-slate-900">Hasil Pemeriksaan & Penanganan Petugas UKS:</p>
        <ul class="list-disc list-inside space-y-1 pl-2 text-slate-700">
            <li><strong>Keluhan Siswa:</strong> {{ $visit->complaint_type }} — {{ $visit->complaint }}</li>
            @if($visit->temperature)
                <li><strong>Suhu Tubuh:</strong> {{ $visit->temperature }} °C</li>
            @endif
            @if($visit->blood_pressure)
                <li><strong>Tekanan Darah:</strong> {{ $visit->blood_pressure }} mmHg</li>
            @endif
            <li><strong>Tindakan yang Diberikan:</strong> {{ $visit->treatment }}</li>
        </ul>
    </div>

    <!-- Status Akhir / Rekomendasi -->
    <div class="p-4 rounded-xl border-2 border-slate-300 bg-slate-50">
        <span class="text-xs font-bold uppercase tracking-wider text-slate-500 block mb-1">Keputusan / Status Akhir Siswa:</span>
        <p class="text-base font-black text-slate-900">
            {{ strtoupper($visit->final_status) }}
        </p>
        @if($visit->notes)
            <p class="text-xs text-slate-600 mt-1 italic">Catatan: {{ $visit->notes }}</p>
        @endif
    </div>

    <p class="text-xs sm:text-sm text-slate-800 leading-relaxed text-justify">
        Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya oleh Guru Mata Pelajaran / Wali Kelas.
    </p>

    <!-- Tanda Tangan -->
    <div class="pt-8 grid grid-cols-2 text-center text-xs sm:text-sm">
        <div>
            <p class="text-slate-600">Mengetahui,</p>
            <p class="font-semibold text-slate-800">Guru Mata Pelajaran / Wali Kelas</p>
            <div class="h-20"></div>
            <p class="font-bold text-slate-900">( ..................................................... )</p>
            <p class="text-xs text-slate-400">NIP.</p>
        </div>

        <div>
            <p class="text-slate-600">Jakarta, {{ $visit->visit_date->translatedFormat('d F Y') }}</p>
            <p class="font-semibold text-slate-800">Petugas UKS yang Memeriksa,</p>
            <div class="h-20"></div>
            <p class="font-bold text-slate-900 underline">{{ $visit->officer?->name ?? 'Petugas UKS' }}</p>
            <p class="text-xs text-slate-500">{{ $visit->officer?->position ?? 'Petugas UKS' }}</p>
        </div>
    </div>
</div>
@endsection
