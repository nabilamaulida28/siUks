@extends('layouts.app')

@section('title', 'Edit Kelas — ' . $class->name)
@section('page_title', 'Perbarui Data Kelas')
@section('page_description', 'Ubah data rombongan belajar, jurusan, atau wali kelas')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-900">Perbarui Kelas: {{ $class->name }}</h3>
            <a href="{{ route('admin.classes.index') }}" class="px-3.5 py-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                Kembali
            </a>
        </div>

        <form action="{{ route('admin.classes.update', $class) }}" method="POST" class="p-6 sm:p-8 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Kelas <span class="text-rose-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $class->name) }}" required
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                @error('name')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="grade" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tingkat Jenjang <span class="text-rose-500">*</span></label>
                    <select id="grade" name="grade" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                        <option value="X" {{ old('grade', $class->grade) === 'X' ? 'selected' : '' }}>Tingkat X</option>
                        <option value="XI" {{ old('grade', $class->grade) === 'XI' ? 'selected' : '' }}>Tingkat XI</option>
                        <option value="XII" {{ old('grade', $class->grade) === 'XII' ? 'selected' : '' }}>Tingkat XII</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Status <span class="text-rose-500">*</span></label>
                    <select id="status" name="status" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                        <option value="active" {{ old('status', $class->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', $class->status) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="major" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Program Keahlian / Jurusan <span class="text-rose-500">*</span></label>
                <input type="text" id="major" name="major" value="{{ old('major', $class->major) }}" required
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                @error('major')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="homeroom_teacher" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Wali Kelas</label>
                <input type="text" id="homeroom_teacher" name="homeroom_teacher" value="{{ old('homeroom_teacher', $class->homeroom_teacher) }}"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
            </div>

            <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-3">
                <a href="{{ route('admin.classes.index') }}" class="w-full sm:w-auto text-center px-4 py-2.5 text-xs font-bold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
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
