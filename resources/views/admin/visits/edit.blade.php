@extends('layouts.app')

@section('title', 'Edit Kunjungan UKS')
@section('page_title', 'Perbarui Data Kunjungan')
@section('page_description', 'Ubah data pemeriksaan, penanganan, atau status kepulangan siswa')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">Perbarui Catatan Kunjungan</h3>
                    <p class="text-xs text-slate-400">Siswa: <span class="font-bold text-slate-700">{{ $visit->student?->name ?? 'Siswa' }}</span> ({{ $visit->student?->nis ?? '-' }})</p>
                </div>
            </div>
            <a href="{{ route('admin.visits.show', $visit) }}" class="px-3.5 py-2 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                Batal / Kembali
            </a>
        </div>

        <form action="{{ route('admin.visits.update', $visit) }}" method="POST" class="p-6 sm:p-8 space-y-8">
            @csrf
            @method('PUT')

            <!-- 1. IDENTITAS SISWA -->
            <div>
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-emerald-700 bg-emerald-50/70 px-3 py-1.5 rounded-lg inline-block mb-4">
                    1. Identitas Siswa
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label for="student_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Pilih Siswa <span class="text-rose-500">*</span></label>
                        <select id="student_id" name="student_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                            @foreach($students as $s)
                                <option value="{{ $s->id }}" {{ old('student_id', $visit->student_id) == $s->id ? 'selected' : '' }}>
                                    {{ $s->name }} — [{{ $s->nis }}] — {{ $s->schoolClass->name ?? 'Tanpa Kelas' }}
                                </option>
                            @endforeach
                        </select>
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
                        <input type="date" id="visit_date" name="visit_date" value="{{ old('visit_date', $visit->visit_date->format('Y-m-d')) }}" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        @error('visit_date')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jam Datang -->
                    <div>
                        <label for="arrival_time" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Jam Datang <span class="text-rose-500">*</span></label>
                        <input type="time" id="arrival_time" name="arrival_time" value="{{ old('arrival_time', substr($visit->arrival_time, 0, 5)) }}" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        @error('arrival_time')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jam Selesai -->
                    <div>
                        <label for="departure_time" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Jam Selesai</label>
                        <input type="time" id="departure_time" name="departure_time" value="{{ old('departure_time', $visit->departure_time ? substr($visit->departure_time, 0, 5) : '') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>

                    <!-- Jam Pelajaran Ke- -->
                    <div>
                        <label for="lesson_period" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Jam Pelajaran Ke <span class="text-rose-500">*</span></label>
                        <select id="lesson_period" name="lesson_period" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                            @foreach($lessonPeriods as $period)
                                <option value="{{ $period }}" {{ old('lesson_period', $visit->lesson_period) == $period ? 'selected' : '' }}>{{ $period }}</option>
                            @endforeach
                        </select>
                        @error('lesson_period')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Guru / Mata Pelajaran -->
                    <div class="sm:col-span-2">
                        <label for="subject" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Mata Pelajaran / Guru Mengajar</label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject', $visit->subject) }}"
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
                        <div>
                            <label for="complaint_type" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Jenis Keluhan Utama <span class="text-rose-500">*</span></label>
                            <select id="complaint_type" name="complaint_type" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                                @foreach($complaints as $c)
                                    <option value="{{ $c }}" {{ old('complaint_type', $visit->complaint_type) == $c ? 'selected' : '' }}>{{ $c }}</option>
                                @endforeach
                            </select>
                            @error('complaint_type')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="temperature" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Suhu Tubuh (°C)</label>
                            <input type="number" step="0.1" id="temperature" name="temperature" value="{{ old('temperature', $visit->temperature) }}"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        </div>

                        <div>
                            <label for="blood_pressure" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tekanan Darah (mmHg)</label>
                            <input type="text" id="blood_pressure" name="blood_pressure" value="{{ old('blood_pressure', $visit->blood_pressure) }}"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        </div>
                    </div>

                    <div>
                        <label for="general_condition" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kondisi Umum Siswa</label>
                        <input type="text" id="general_condition" name="general_condition" value="{{ old('general_condition', $visit->general_condition) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>

                    <div>
                        <label for="complaint" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Deskripsi / Rincian Keluhan Siswa <span class="text-rose-500">*</span></label>
                        <textarea id="complaint" name="complaint" rows="3" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">{{ old('complaint', $visit->complaint) }}</textarea>
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
                    <div>
                        <label for="treatment" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tindakan / Penanganan yang Diberikan <span class="text-rose-500">*</span></label>
                        <textarea id="treatment" name="treatment" rows="3" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">{{ old('treatment', $visit->treatment) }}</textarea>
                        @error('treatment')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="final_status" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Status Setelah Kunjungan <span class="text-rose-500">*</span></label>
                        <select id="final_status" name="final_status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white font-semibold">
                            @foreach($statuses as $st)
                                <option value="{{ $st }}" {{ old('final_status', $visit->final_status) == $st ? 'selected' : '' }}>{{ $st }}</option>
                            @endforeach
                        </select>
                        @error('final_status')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="notes" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Catatan Tambahan</label>
                        <textarea id="notes" name="notes" rows="2"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">{{ old('notes', $visit->notes) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-3">
                <a href="{{ route('admin.visits.show', $visit) }}" class="w-full sm:w-auto text-center px-5 py-3 sm:py-2.5 text-xs font-bold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                    Batal
                </a>
                <button type="submit" class="w-full sm:w-auto justify-center px-6 py-3 sm:py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-md shadow-emerald-600/20 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
