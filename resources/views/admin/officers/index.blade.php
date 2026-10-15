@extends('layouts.app')

@section('title', 'Petugas UKS')
@section('page_title', 'Master Data Petugas UKS')
@section('page_description', 'Kelola akun petugas kesehatan UKS, koordinator, dan administrator sistem')

@section('header_actions')
    <a href="{{ route('admin.officers.create') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-emerald-600/20 transition-all flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
        <span>Tambah Petugas Baru</span>
    </a>
@endsection

@section('content')
<div class="space-y-6">

    <!-- SEARCH & FILTER -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
        <form action="{{ route('admin.officers.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="flex-1 relative w-full">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau nomor HP petugas..."
                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <div class="w-full sm:w-48">
                <select name="role" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                    <option value="">Semua Peran</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                    <option value="officer" {{ request('role') === 'officer' ? 'selected' : '' }}>Petugas UKS</option>
                </select>
            </div>

            <button type="submit" class="w-full sm:w-auto px-4 py-2 text-xs font-bold text-white bg-slate-800 hover:bg-slate-900 rounded-xl transition-colors">
                Cari
            </button>
            @if(request()->hasAny(['search', 'role']))
                <a href="{{ route('admin.officers.index') }}" class="w-full sm:w-auto px-3 py-2 text-xs font-semibold text-slate-500 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- OFFICERS LIST (MOBILE CARDS & DESKTOP TABLE) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        
        <!-- Mobile Card View (block md:hidden) -->
        <div class="block md:hidden divide-y divide-slate-100">
            @forelse($officers as $index => $officer)
                <div class="p-4 space-y-3 hover:bg-slate-50/50 transition-colors">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-emerald-600 text-white font-bold text-xs flex items-center justify-center shrink-0">
                                {{ strtoupper(substr($officer->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <h3 class="text-sm font-bold text-slate-900">{{ $officer->name }}</h3>
                                    @if($officer->id === auth()->id())
                                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full ring-1 ring-emerald-600/20">Anda</span>
                                    @endif
                                </div>
                                <span class="text-[11px] font-semibold text-slate-500 block">{{ $officer->position ?: 'Petugas UKS' }}</span>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold shrink-0 {{ $officer->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                            {{ $officer->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>

                    <!-- Officer Details & Contact -->
                    <div class="bg-slate-50/80 p-2.5 rounded-xl space-y-1.5 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Email:</span>
                            <span class="font-semibold text-slate-800">{{ $officer->email }}</span>
                        </div>
                        @if($officer->phone)
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">No. HP:</span>
                                <a href="tel:{{ $officer->phone }}" class="font-semibold text-emerald-600 hover:underline flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    {{ $officer->phone }}
                                </a>
                            </div>
                        @endif
                        <div class="flex items-center justify-between pt-1 border-t border-slate-200/60">
                            <span class="text-slate-400">Peran & Catatan:</span>
                            <div class="flex items-center gap-1.5">
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold {{ $officer->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-teal-100 text-teal-700' }}">
                                    {{ $officer->role === 'admin' ? 'Admin' : 'Petugas' }}
                                </span>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-200 text-slate-700">
                                    {{ $officer->visits_count }} Catatan
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-2 pt-1">
                        <a href="{{ route('admin.officers.edit', $officer) }}" class="flex-1 text-center py-2 px-3 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-700 text-xs font-bold rounded-xl transition-colors">
                            Edit Profil
                        </a>
                        @if($officer->id !== auth()->id())
                            <form action="{{ route('admin.officers.destroy', $officer) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus petugas ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="py-2 px-3 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-bold rounded-xl transition-colors">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-10 px-4 text-center text-slate-400 font-medium text-xs">
                    Belum ada data petugas yang terdaftar.
                </div>
            @endforelse
        </div>

        <!-- Desktop Table View (hidden md:block) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/80 text-[11px] uppercase tracking-wider text-slate-400 font-bold border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-6">Nama Petugas</th>
                        <th class="py-3.5 px-4">Kontak (Email / HP)</th>
                        <th class="py-3.5 px-4">Jabatan</th>
                        <th class="py-3.5 px-4">Peran (Role)</th>
                        <th class="py-3.5 px-4 text-center">Kunjungan Ditangani</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($officers as $index => $officer)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-4 text-center text-xs text-slate-400">
                                {{ $officers->firstItem() + $index }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-emerald-600 text-white font-bold text-xs flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($officer->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $officer->name }}</p>
                                        @if($officer->id === auth()->id())
                                            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Akun Anda</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-xs">
                                <p class="font-semibold text-slate-800">{{ $officer->email }}</p>
                                <p class="text-slate-400">{{ $officer->phone ?: '-' }}</p>
                            </td>
                            <td class="py-4 px-4 text-xs font-semibold text-slate-700">
                                {{ $officer->position ?: 'Petugas UKS' }}
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ $officer->role === 'admin' ? 'bg-purple-50 text-purple-700 ring-1 ring-purple-600/20' : 'bg-teal-50 text-teal-700 ring-1 ring-teal-600/20' }}">
                                    {{ $officer->role === 'admin' ? 'Administrator' : 'Petugas UKS' }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                    {{ $officer->visits_count }} Catatan
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $officer->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                    {{ $officer->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.officers.edit', $officer) }}" title="Edit Petugas" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    @if($officer->id !== auth()->id())
                                        <form action="{{ route('admin.officers.destroy', $officer) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus petugas ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus Petugas" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-10 text-center text-slate-400 font-medium">
                                Belum ada data petugas yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($officers->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $officers->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
