@extends('layouts.app')

@section('title', 'Data Siswa')
@section('page_title', 'Master Data Siswa')
@section('page_description', 'Kelola data identitas siswa, kelas, kontak orang tua, dan riwayat kesehatan')

@section('header_actions')
    <a href="{{ route('admin.students.create') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-emerald-600/20 transition-all flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
        <span>Tambah Siswa Baru</span>
    </a>
@endsection

@section('content')
<div class="space-y-6">

    <!-- SEARCH & FILTER -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200 shadow-xs">
        <!-- Mobile Toggle Button -->
        <div class="flex items-center justify-between sm:hidden mb-3">
            <button type="button" onclick="document.getElementById('studentFilterContainer').classList.toggle('hidden')" class="flex items-center gap-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 px-3 py-2 rounded-xl transition-colors">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                <span>Filter Siswa</span>
                @if(request()->hasAny(['search', 'class_id', 'status']))
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                @endif
            </button>
            <span class="text-xs text-slate-400 font-semibold">{{ $students->total() }} Siswa</span>
        </div>

        <form action="{{ route('admin.students.index') }}" method="GET" id="studentFilterContainer" class="space-y-4 {{ request()->hasAny(['search', 'class_id', 'status']) ? '' : 'hidden sm:block' }}">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Cari Nama / NIS / NISN</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama atau NIS..."
                            class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Filter Kelas</label>
                    <select name="class_id" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                        <option value="">Semua Kelas</option>
                        @foreach($classes as $c)
                            <option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Status Siswa</label>
                    <select name="status" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-3 border-t border-slate-100">
                <span class="text-xs text-slate-500 font-medium hidden sm:inline">Total: <strong>{{ $students->total() }}</strong> siswa terdaftar</span>
                <div class="flex items-center justify-end gap-2">
                    @if(request()->hasAny(['search', 'class_id', 'status']))
                        <a href="{{ route('admin.students.index') }}" class="px-3.5 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                            Reset
                        </a>
                    @endif
                    <button type="submit" class="flex-1 sm:flex-initial px-4 py-2 text-xs font-bold text-white bg-slate-800 hover:bg-slate-900 rounded-xl transition-colors flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        <span>Terapkan Filter</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- STUDENTS CONTENT -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        
        <!-- Mobile Card View (Visible on Mobile / Hidden on Desktop) -->
        <div class="divide-y divide-slate-100 md:hidden">
            @forelse($students as $index => $student)
                <div class="p-4 hover:bg-slate-50/70 transition-colors">
                    <div class="flex items-start justify-between gap-2.5 mb-2.5">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-10 h-10 rounded-full {{ $student->gender === 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }} text-xs font-black flex items-center justify-center shrink-0">
                                {{ strtoupper(substr($student->name, 0, 2)) }}
                            </div>
                            <div class="min-w-0">
                                <a href="{{ route('admin.students.show', $student) }}" class="font-bold text-xs text-slate-900 hover:text-emerald-600 block truncate">
                                    {{ $student->name }}
                                </a>
                                <p class="text-[11px] text-slate-400">NIS: {{ $student->nis }} • <span class="font-bold text-emerald-700">{{ $student->schoolClass->name ?? '-' }}</span></p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold shrink-0 {{ $student->status === 'active' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20' : 'bg-rose-50 text-rose-700 ring-1 ring-rose-600/20' }}">
                            {{ $student->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>

                    <div class="bg-slate-50 p-2.5 rounded-xl text-[11px] text-slate-600 grid grid-cols-2 gap-2 my-2.5">
                        <div>
                            <span class="text-[10px] text-slate-400 block">Kunjungan UKS</span>
                            <span class="font-black {{ $student->visits_count > 0 ? 'text-emerald-700' : 'text-slate-400' }}">
                                {{ $student->visits_count }} Kali
                            </span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 block">Orang Tua / Wali</span>
                            <span class="font-semibold text-slate-800 block truncate">{{ $student->parent_name ?: '-' }}</span>
                            @if($student->parent_phone)
                                <a href="tel:{{ $student->parent_phone }}" class="text-emerald-600 underline font-bold text-[10px]">
                                    📞 {{ $student->parent_phone }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Actions Row -->
                    <div class="flex items-center justify-end gap-2 pt-1">
                        <a href="{{ route('admin.visits.create') }}?student_id={{ $student->id }}" class="px-2.5 py-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition-colors">
                            + Kunjungan
                        </a>
                        <a href="{{ route('admin.students.show', $student) }}" class="px-2.5 py-1 text-[11px] font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                            Detail
                        </a>
                        <a href="{{ route('admin.students.edit', $student) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Hapus data siswa ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="py-10 text-center text-slate-400 text-xs font-medium">
                    Tidak ada siswa yang cocok dengan pencarian Anda.
                </div>
            @endforelse
        </div>

        <!-- Desktop Table (Hidden on Mobile) -->
        <div class="overflow-x-auto hidden md:block">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/80 text-[11px] uppercase tracking-wider text-slate-400 font-bold border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Nama Siswa</th>
                        <th class="py-3.5 px-4">Kelas</th>
                        <th class="py-3.5 px-4">L/P</th>
                        <th class="py-3.5 px-4">Kontak Orang Tua</th>
                        <th class="py-3.5 px-4 text-center">Kunjungan UKS</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($students as $index => $student)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-4 text-center text-xs text-slate-400 font-semibold">
                                {{ $students->firstItem() + $index }}
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full {{ $student->gender === 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }} text-xs font-black flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($student->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.students.show', $student) }}" class="font-bold text-slate-900 hover:text-emerald-600 transition-colors">
                                            {{ $student->name }}
                                        </a>
                                        <p class="text-[11px] text-slate-400">NIS: {{ $student->nis }} {{ $student->nisn ? '• NISN: ' . $student->nisn : '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-xs font-semibold text-slate-700">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 font-bold text-slate-800">
                                    {{ $student->schoolClass->name ?? '-' }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-xs font-semibold">
                                <span class="px-2 py-0.5 rounded text-[11px] {{ $student->gender === 'L' ? 'bg-blue-50 text-blue-700' : 'bg-pink-50 text-pink-700' }}">
                                    {{ $student->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-xs">
                                <p class="font-bold text-slate-800">{{ $student->parent_name ?? '-' }}</p>
                                <p class="text-slate-400">{{ $student->parent_phone ?? '-' }}</p>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-xs font-black {{ $student->visits_count > 0 ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20' : 'bg-slate-100 text-slate-400' }}">
                                    {{ $student->visits_count }} Kali
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $student->status === 'active' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20' : 'bg-rose-50 text-rose-700 ring-1 ring-rose-600/20' }}">
                                    {{ $student->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- Detail Siswa & Riwayat -->
                                    <a href="{{ route('admin.students.show', $student) }}" title="Lihat Profil & Riwayat" class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>

                                    <!-- Edit Siswa -->
                                    <a href="{{ route('admin.students.edit', $student) }}" title="Edit Data Siswa" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    <!-- Hapus Siswa -->
                                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini? Seluruh riwayat kunjungannya juga akan terhapus.')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Siswa" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <div class="max-w-xs mx-auto">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-3 text-slate-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    </div>
                                    <p class="font-bold text-slate-700">Tidak ada data siswa</p>
                                    <p class="text-xs text-slate-400 mt-1">Belum ada siswa yang sesuai dengan pencarian Anda.</p>
                                    <a href="{{ route('admin.students.create') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors">
                                        <span>+ Tambah Siswa Baru</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($students->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $students->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
