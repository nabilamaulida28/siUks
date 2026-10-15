@extends('layouts.app')

@section('title', 'Edit Data Siswa — ' . $student->name)
@section('page_title', 'Perbarui Data Siswa')
@section('page_description', 'Ubah informasi identitas pokok, kelas, atau kontak siswa')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">Perbarui Biodata Siswa</h3>
                    <p class="text-xs text-slate-400">Siswa: <span class="font-bold text-slate-700">{{ $student->name }}</span> ({{ $student->nis }})</p>
                </div>
            </div>
            <a href="{{ route('admin.students.show', $student) }}" class="px-3.5 py-2 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                Batal / Kembali
            </a>
        </div>

        <form action="{{ route('admin.students.update', $student) }}" method="POST" class="p-6 sm:p-8 space-y-8">
            @csrf
            @method('PUT')

            <!-- 1. IDENTITAS POKOK -->
            <div>
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-emerald-700 bg-emerald-50/70 px-3 py-1.5 rounded-lg inline-block mb-4">
                    1. Identitas Pokok Siswa
                </h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- NIS -->
                    <div>
                        <label for="nis" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">NIS <span class="text-rose-500">*</span></label>
                        <input type="text" id="nis" name="nis" value="{{ old('nis', $student->nis) }}" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        @error('nis')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NISN -->
                    <div>
                        <label for="nisn" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">NISN</label>
                        <input type="text" id="nisn" name="nisn" value="{{ old('nisn', $student->nisn) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        @error('nisn')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Lengkap Siswa <span class="text-rose-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $student->name) }}" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        @error('name')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label for="gender" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Jenis Kelamin <span class="text-rose-500">*</span></label>
                        <select id="gender" name="gender" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                            <option value="L" {{ old('gender', $student->gender) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender', $student->gender) === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <!-- Kelas -->
                    <div>
                        <label for="class_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kelas <span class="text-rose-500">*</span></label>
                        <select id="class_id" name="class_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}" {{ old('class_id', $student->class_id) == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->major }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tempat Lahir -->
                    <div>
                        <label for="birth_place" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tempat Lahir</label>
                        <input type="text" id="birth_place" name="birth_place" value="{{ old('birth_place', $student->birth_place) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label for="birth_date" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tanggal Lahir</label>
                        <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date', $student->birth_date ? $student->birth_date->format('Y-m-d') : '') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>
                </div>
            </div>

            <!-- 2. KONTAK & ORANG TUA -->
            <div class="pt-6 border-t border-slate-100">
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-emerald-700 bg-emerald-50/70 px-3 py-1.5 rounded-lg inline-block mb-4">
                    2. Kontak & Orang Tua / Wali
                </h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nomor HP Siswa -->
                    <div>
                        <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nomor HP Siswa</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $student->phone) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>

                    <!-- Status Siswa -->
                    <div>
                        <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Status Siswa <span class="text-rose-500">*</span></label>
                        <select id="status" name="status" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                            <option value="active" {{ old('status', $student->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status', $student->status) === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    <!-- Nama Orang Tua / Wali -->
                    <div>
                        <label for="parent_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Orang Tua / Wali</label>
                        <input type="text" id="parent_name" name="parent_name" value="{{ old('parent_name', $student->parent_name) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>

                    <!-- No HP Orang Tua -->
                    <div>
                        <label for="parent_phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">No. HP Orang Tua / Kontak Darurat</label>
                        <input type="text" id="parent_phone" name="parent_phone" value="{{ old('parent_phone', $student->parent_phone) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>

                    <!-- Alamat -->
                    <div class="sm:col-span-2">
                        <label for="address" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Alamat Tempat Tinggal</label>
                        <textarea id="address" name="address" rows="2"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">{{ old('address', $student->address) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-3">
                <a href="{{ route('admin.students.show', $student) }}" class="w-full sm:w-auto text-center px-5 py-3 sm:py-2.5 text-xs font-bold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
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
