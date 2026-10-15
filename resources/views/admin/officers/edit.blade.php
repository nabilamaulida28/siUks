@extends('layouts.app')

@section('title', 'Edit Data Petugas — ' . $officer->name)
@section('page_title', 'Perbarui Data Petugas')
@section('page_description', 'Ubah data profil, peran, kontak, atau status akun petugas')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-900">Perbarui Petugas: {{ $officer->name }}</h3>
            <a href="{{ route('admin.officers.index') }}" class="px-3.5 py-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                Kembali
            </a>
        </div>

        <form action="{{ route('admin.officers.update', $officer) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $officer->name) }}" required
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                @error('name')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Email (Login) <span class="text-rose-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', $officer->email) }}" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    @error('email')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Ganti Kata Sandi (Opsional)</label>
                    <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak diubah"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    @error('password')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="role" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Peran Sistem (Role) <span class="text-rose-500">*</span></label>
                    <select id="role" name="role" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                        <option value="officer" {{ old('role', $officer->role) === 'officer' ? 'selected' : '' }}>Petugas UKS</option>
                        <option value="admin" {{ old('role', $officer->role) === 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                </div>

                <div>
                    <label for="is_active" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Status Akun <span class="text-rose-500">*</span></label>
                    <select id="is_active" name="is_active" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                        <option value="1" {{ old('is_active', $officer->is_active ? '1' : '0') === '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active', $officer->is_active ? '1' : '0') === '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="position" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Jabatan / Profesi</label>
                    <input type="text" id="position" name="position" value="{{ old('position', $officer->position) }}"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                </div>

                <div>
                    <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nomor HP / WhatsApp</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $officer->phone) }}"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-3">
                <a href="{{ route('admin.officers.index') }}" class="w-full sm:w-auto text-center px-4 py-2.5 text-xs font-bold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                    Batal
                </a>
                <button type="submit" class="w-full sm:w-auto justify-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
