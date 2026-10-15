@extends('layouts.app')

@section('title', 'Tambah Siswa Baru')
@section('page_title', 'Tambah Data Siswa')
@section('page_description', 'Masukkan identitas siswa baru beserta kontak orang tua dan informasi kelas')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">Formulir Data Siswa</h3>
                    <p class="text-xs text-slate-400">Lengkapi data pokok siswa untuk pendataan UKS</p>
                </div>
            </div>
            <a href="{{ route('admin.students.index') }}" class="px-3.5 py-2 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                Kembali
            </a>
        </div>

        <form action="{{ route('admin.students.store') }}" method="POST" class="p-6 sm:p-8 space-y-8">
            @csrf

            <!-- 1. IDENTITAS POKOK -->
            <div>
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-emerald-700 bg-emerald-50/70 px-3 py-1.5 rounded-lg inline-block mb-4">
                    1. Identitas Pokok Siswa
                </h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- NIS -->
                    <div>
                        <label for="nis" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">NIS (Nomor Induk Siswa) <span class="text-rose-500">*</span></label>
                        <input type="text" id="nis" name="nis" value="{{ old('nis') }}" required placeholder="Misal: 20241010"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        @error('nis')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NISN -->
                    <div>
                        <label for="nisn" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">NISN (Opsional)</label>
                        <input type="text" id="nisn" name="nisn" value="{{ old('nisn') }}" placeholder="Misal: 0071234567"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        @error('nisn')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Lengkap Siswa <span class="text-rose-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Nama lengkap siswa sesuai akta / raport"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        @error('name')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label for="gender" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Jenis Kelamin <span class="text-rose-500">*</span></label>
                        <select id="gender" name="gender" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ old('gender') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kelas -->
                    <div>
                        <label for="class_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kelas <span class="text-rose-500">*</span></label>
                        <select id="class_id" name="class_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}" {{ old('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->major }})</option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tempat Lahir -->
                    <div>
                        <label for="birth_place" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tempat Lahir</label>
                        <input type="text" id="birth_place" name="birth_place" value="{{ old('birth_place') }}" placeholder="Kota kelahiran"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label for="birth_date" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tanggal Lahir</label>
                        <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>
                </div>
            </div>

            <!-- 2. KONTAK & ALAMAT -->
            <div class="pt-6 border-t border-slate-100">
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-emerald-700 bg-emerald-50/70 px-3 py-1.5 rounded-lg inline-block mb-4">
                    2. Kontak & Orang Tua / Wali
                </h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nomor HP Siswa -->
                    <div>
                        <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nomor HP Siswa</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>

                    <!-- Status Siswa -->
                    <div>
                        <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Status Siswa <span class="text-rose-500">*</span></label>
                        <select id="status" name="status" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    <!-- Nama Orang Tua / Wali -->
                    <div>
                        <label for="parent_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Orang Tua / Wali</label>
                        <input type="text" id="parent_name" name="parent_name" value="{{ old('parent_name') }}" placeholder="Nama ayah / ibu / wali"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>

                    <!-- No HP Orang Tua -->
                    <div>
                        <label for="parent_phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">No. HP Orang Tua / Kontak Darurat</label>
                        <input type="text" id="parent_phone" name="parent_phone" value="{{ old('parent_phone') }}" placeholder="08xxxxxxxxxx"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>

                    <!-- Alamat -->
                    <div class="sm:col-span-2">
                        <label for="address" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Alamat Tempat Tinggal</label>
                        <textarea id="address" name="address" rows="2" placeholder="Alamat lengkap siswa..."
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">{{ old('address') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- 3. AKUN LOGIN SISWA (OPSIONAL) -->
            <div class="pt-6 border-t border-slate-100">
                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200">
                    <label class="flex items-center gap-3 cursor-pointer select-none">
                        <input type="checkbox" id="create_user_account" name="create_user_account" value="1" {{ old('create_user_account') ? 'checked' : '' }}
                            onchange="toggleAccountFields()"
                            class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">Buatkan Akun Login Siswa</span>
                            <span class="text-[11px] text-slate-500">Aktifkan agar siswa dapat login ke SIUKS untuk melihat riwayat kunjungannya sendiri.</span>
                        </div>
                    </label>

                    <div id="account_fields" class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4 {{ old('create_user_account') ? '' : 'hidden' }}">
                        <div>
                            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Email Siswa</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="siswa@sekolah.sch.id"
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                            @error('email')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kata Sandi (Default: NIS)</label>
                            <input type="password" id="password" name="password" placeholder="Minimal 6 karakter"
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                            <p class="text-[10px] text-slate-400 mt-1">Kosongkan untuk otomatis menggunakan NIS sebagai password.</p>
                            @error('password')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-3">
                <a href="{{ route('admin.students.index') }}" class="w-full sm:w-auto text-center px-5 py-3 sm:py-2.5 text-xs font-bold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                    Batal
                </a>
                <button type="submit" class="w-full sm:w-auto justify-center px-6 py-3 sm:py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-md shadow-emerald-600/20 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Simpan Siswa</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleAccountFields() {
        const checkbox = document.getElementById('create_user_account');
        const fields = document.getElementById('account_fields');
        if (checkbox.checked) {
            fields.classList.remove('hidden');
        } else {
            fields.classList.add('hidden');
        }
    }
</script>
@endsection
