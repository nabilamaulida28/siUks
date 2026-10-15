@extends('layouts.app')

@section('title', 'Data Kelas')
@section('page_title', 'Master Data Kelas')
@section('page_description', 'Kelola daftar kelas rombongan belajar, wali kelas, dan jurusan')

@section('header_actions')
    <a href="{{ route('admin.classes.create') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-emerald-600/20 transition-all flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
        <span>Tambah Kelas Baru</span>
    </a>
@endsection

@section('content')
<div class="space-y-6">

    <!-- SEARCH & FILTER -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
        <form action="{{ route('admin.classes.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="flex-1 relative w-full">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kelas, jurusan, wali kelas..."
                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <div class="w-full sm:w-48">
                <select name="grade" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                    <option value="">Semua Tingkat</option>
                    <option value="X" {{ request('grade') === 'X' ? 'selected' : '' }}>Tingkat X</option>
                    <option value="XI" {{ request('grade') === 'XI' ? 'selected' : '' }}>Tingkat XI</option>
                    <option value="XII" {{ request('grade') === 'XII' ? 'selected' : '' }}>Tingkat XII</option>
                </select>
            </div>

            <button type="submit" class="w-full sm:w-auto px-4 py-2 text-xs font-bold text-white bg-slate-800 hover:bg-slate-900 rounded-xl transition-colors">
                Cari
            </button>
            @if(request()->hasAny(['search', 'grade']))
                <a href="{{ route('admin.classes.index') }}" class="w-full sm:w-auto px-3 py-2 text-xs font-semibold text-slate-500 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- CLASSES LIST (MOBILE CARDS & DESKTOP TABLE) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        
        <!-- Mobile Card View (block md:hidden) -->
        <div class="block md:hidden divide-y divide-slate-100">
            @forelse($classes as $index => $class)
                <div class="p-4 space-y-3 hover:bg-slate-50/50 transition-colors">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-400">#{{ $classes->firstItem() + $index }}</span>
                                <h3 class="text-base font-black text-slate-900">{{ $class->name }}</h3>
                                <span class="px-2 py-0.5 rounded-md text-[11px] font-bold bg-slate-100 text-slate-700">
                                    Kelas {{ $class->grade }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 font-medium mt-1">Jurusan: <strong class="text-slate-700">{{ $class->major }}</strong></p>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold shrink-0 {{ $class->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                            {{ $class->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between text-xs pt-1 border-t border-slate-100/80">
                        <div class="text-slate-500 truncate max-w-[200px]">
                            <span class="text-slate-400">Wali Kelas:</span>
                            <span class="font-semibold text-slate-800">{{ $class->homeroom_teacher ?: '-' }}</span>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20 shrink-0">
                            {{ $class->students_count }} Siswa
                        </span>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                        <a href="{{ route('admin.classes.edit', $class) }}" class="flex-1 text-center py-2 px-3 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-700 text-xs font-bold rounded-xl transition-colors">
                            Edit Kelas
                        </a>
                        <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" onsubmit="return confirm('Hapus kelas ini? Pastikan tidak ada siswa yang terdaftar di kelas ini.')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="py-2 px-3 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-bold rounded-xl transition-colors">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="py-10 px-4 text-center text-slate-400 font-medium text-xs">
                    Belum ada data kelas yang terdaftar.
                </div>
            @endforelse
        </div>

        <!-- Desktop Table View (hidden md:block) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/80 text-[11px] uppercase tracking-wider text-slate-400 font-bold border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-6">Nama Kelas</th>
                        <th class="py-3.5 px-4">Tingkat</th>
                        <th class="py-3.5 px-4">Jurusan</th>
                        <th class="py-3.5 px-4">Wali Kelas</th>
                        <th class="py-3.5 px-4 text-center">Jumlah Siswa</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($classes as $index => $class)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-4 text-center text-xs text-slate-400">
                                {{ $classes->firstItem() + $index }}
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-900">
                                <span class="text-emerald-700 font-black">{{ $class->name }}</span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-0.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-700">
                                    Kelas {{ $class->grade }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-xs font-semibold text-slate-600">
                                {{ $class->major }}
                            </td>
                            <td class="py-4 px-4 text-xs font-medium text-slate-800">
                                {{ $class->homeroom_teacher ?: '-' }}
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20">
                                    {{ $class->students_count }} Siswa
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $class->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                    {{ $class->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.classes.edit', $class) }}" title="Edit Kelas" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" onsubmit="return confirm('Hapus kelas ini? Pastikan tidak ada siswa yang terdaftar di kelas ini.')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Kelas" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-10 text-center text-slate-400 font-medium">
                                Belum ada data kelas yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($classes->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $classes->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
