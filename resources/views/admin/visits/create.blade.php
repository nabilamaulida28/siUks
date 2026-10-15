@extends('layouts.app')

@section('title', 'Catat Kunjungan Baru')
@section('page_title', 'Form Pencatatan Kunjungan UKS')
@section('page_description', 'Isi data kunjungan siswa, kondisi fisik, pemeriksaan tanda vital, dan tindakan penanganan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">Rekam Kunjungan Baru</h3>
                    <p class="text-xs text-slate-400">Pastikan seluruh data kondisi dan tindakan tercatat dengan akurat</p>
                </div>
            </div>
            <a href="{{ route('admin.visits.index') }}" class="px-3.5 py-2 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                Kembali
            </a>
        </div>

        <form action="{{ route('admin.visits.store') }}" method="POST" class="p-6 sm:p-8 space-y-8">
            @csrf

            <!-- 1. IDENTITAS SISWA -->
            <div>
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-emerald-700 bg-emerald-50/70 px-3 py-1.5 rounded-lg inline-block mb-4">
                    1. Identitas Siswa
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label for="student_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Pilih Siswa <span class="text-rose-500">*</span>
                        </label>
                        <select id="student_id" name="student_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                            <option value="">-- Pilih Siswa (Ketik / Gulir) --</option>
                            @foreach($students as $s)
                                <option value="{{ $s->id }}" {{ old('student_id', request('student_id')) == $s->id ? 'selected' : '' }}>
                                    {{ $s->name }} — [{{ $s->nis }}] — {{ $s->schoolClass->name ?? 'Tanpa Kelas' }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[11px] text-slate-400 mt-1">Siswa belum terdaftar? <a href="{{ route('admin.students.create') }}" target="_blank" class="text-emerald-600 underline font-semibold">Tambah data siswa baru di sini</a>.</p>
                        @error('student_id')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- 2. WAKTU & JADWAL KUNJUNGAN -->
            <div class="pt-6 border-t border-slate-100">
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-emerald-700 bg-emerald-50/70 px-3 py-1.5 rounded-lg inline-block mb-4">
                    2. Waktu Kunjungan
                </h4>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Tanggal -->
                    <div>
                        <label for="visit_date" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tanggal <span class="text-rose-500">*</span></label>
                        <input type="date" id="visit_date" name="visit_date" value="{{ old('visit_date', date('Y-m-d')) }}" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        @error('visit_date')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jam Datang -->
                    <div>
                        <label for="arrival_time" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Jam Datang <span class="text-rose-500">*</span></label>
                        <input type="time" id="arrival_time" name="arrival_time" value="{{ old('arrival_time', date('H:i')) }}" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        @error('arrival_time')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jam Selesai -->
                    <div>
                        <label for="departure_time" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Jam Selesai (Opsional)</label>
                        <input type="time" id="departure_time" name="departure_time" value="{{ old('departure_time') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        <p class="text-[11px] text-slate-400 mt-1">Kosongkan jika siswa masih berada di UKS</p>
                    </div>

                    <!-- Jam Pelajaran Ke- -->
                    <div>
                        <label for="lesson_period" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Jam Pelajaran Ke <span class="text-rose-500">*</span></label>
                        <select id="lesson_period" name="lesson_period" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                            <option value="">-- Pilih Jam Ke --</option>
                            @foreach($lessonPeriods as $period)
                                <option value="{{ $period }}" {{ old('lesson_period') == $period ? 'selected' : '' }}>{{ $period }}</option>
                            @endforeach
                        </select>
                        @error('lesson_period')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Guru / Mata Pelajaran -->
                    <div class="sm:col-span-2">
                        <label for="subject" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Mata Pelajaran / Guru Mengajar</label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" placeholder="Contoh: Matematika / Bu Sri"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>
                </div>
            </div>

            <!-- 3. KONDISI & TANDA VITAL -->
            <div class="pt-6 border-t border-slate-100">
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-emerald-700 bg-emerald-50/70 px-3 py-1.5 rounded-lg inline-block mb-4">
                    3. Kondisi Siswa & Pemeriksaan Fisik
                </h4>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <!-- Jenis Keluhan -->
                        <div>
                            <label for="complaint_type" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Jenis Keluhan Utama <span class="text-rose-500">*</span></label>
                            <select id="complaint_type" name="complaint_type" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                                <option value="">-- Pilih Keluhan --</option>
                                @foreach($complaints as $c)
                                    <option value="{{ $c }}" {{ old('complaint_type') == $c ? 'selected' : '' }}>{{ $c }}</option>
                                @endforeach
                            </select>
                            @error('complaint_type')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Suhu Tubuh -->
                        <div>
                            <label for="temperature" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Suhu Tubuh (°C)</label>
                            <input type="number" step="0.1" id="temperature" name="temperature" value="{{ old('temperature') }}" placeholder="Misal: 36.5"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                            @error('temperature')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tekanan Darah -->
                        <div>
                            <label for="blood_pressure" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tekanan Darah (mmHg)</label>
                            <input type="text" id="blood_pressure" name="blood_pressure" value="{{ old('blood_pressure') }}" placeholder="Misal: 120/80"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        </div>
                    </div>

                    <!-- Kondisi Umum -->
                    <div>
                        <label for="general_condition" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kondisi Umum Siswa</label>
                        <input type="text" id="general_condition" name="general_condition" value="{{ old('general_condition') }}" placeholder="Contoh: Sadar penuh, tampak pucat, mengantuk, bibir kering..."
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>

                    <!-- Rincian Keluhan -->
                    <div>
                        <label for="complaint" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Deskripsi / Rincian Keluhan Siswa <span class="text-rose-500">*</span></label>
                        <textarea id="complaint" name="complaint" rows="3" required placeholder="Jelaskan apa yang dirasakan siswa, sejak kapan timbul keluhan, dll..."
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">{{ old('complaint') }}</textarea>
                        @error('complaint')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- 4. TINDAKAN PETUGAS & STATUS AKHIR -->
            <div class="pt-6 border-t border-slate-100">
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-emerald-700 bg-emerald-50/70 px-3 py-1.5 rounded-lg inline-block mb-4">
                    4. Tindakan Petugas & Status Akhir
                </h4>

                <div class="space-y-4">
                    <!-- Template Tindakan Cepat -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Pilihan Tindakan Cepat (Klik untuk menambah)</label>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($treatments as $t)
                                <button type="button" onclick="appendTreatment('{{ $t }}')" class="px-2.5 py-1 text-xs rounded-lg bg-slate-100 hover:bg-emerald-100 hover:text-emerald-800 text-slate-700 transition-colors font-medium border border-slate-200">
                                    + {{ $t }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Textarea Tindakan -->
                    <div>
                        <label for="treatment" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tindakan / Penanganan yang Diberikan <span class="text-rose-500">*</span></label>
                        <textarea id="treatment" name="treatment" rows="3" required placeholder="Tindakan yang diberikan petugas (obat, kompres, istirahat, dll)..."
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">{{ old('treatment') }}</textarea>
                        @error('treatment')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Akhir -->
                    <div>
                        <label for="final_status" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Status Setelah Kunjungan <span class="text-rose-500">*</span></label>
                        <select id="final_status" name="final_status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white font-semibold">
                            <option value="">-- Pilih Status Akhir --</option>
                            @foreach($statuses as $st)
                                <option value="{{ $st }}" {{ old('final_status', 'Kembali ke kelas') == $st ? 'selected' : '' }}>{{ $st }}</option>
                            @endforeach
                        </select>
                        @error('final_status')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catatan Tambahan -->
                    <div>
                        <label for="notes" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Catatan Tambahan</label>
                        <textarea id="notes" name="notes" rows="2" placeholder="Catatan pesan untuk wali kelas / orang tua siswa..."
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-3">
                <a href="{{ route('admin.visits.index') }}" class="w-full sm:w-auto text-center px-5 py-3 sm:py-2.5 text-xs font-bold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                    Batal
                </a>
                <button type="submit" class="w-full sm:w-auto justify-center px-6 py-3 sm:py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-md shadow-emerald-600/20 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Simpan Data Kunjungan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function appendTreatment(text) {
        const area = document.getElementById('treatment');
        if (area.value.trim() === '') {
            area.value = text;
        } else {
            area.value += ', ' + text;
        }
    }
</script>
@endsection
