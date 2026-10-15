@extends('layouts.app')

@section('title', 'Data Kunjungan UKS')
@section('page_title', 'Pencatatan Kunjungan UKS')
@section('page_description', 'Kelola, cari, dan pantau seluruh catatan kunjungan siswa ke UKS')

@section('header_actions')
    <a href="{{ route('admin.visits.create') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-emerald-600/20 transition-all flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
        <span>Catat Kunjungan Baru</span>
    </a>
@endsection

@section('content')
<div class="space-y-6">

    <!-- FILTER & SEARCH CARD -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200 shadow-xs">
        <!-- Mobile Toggle Button -->
        <div class="flex items-center justify-between sm:hidden mb-3">
            <button type="button" onclick="document.getElementById('filterContainer').classList.toggle('hidden')" class="flex items-center gap-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 px-3 py-2 rounded-xl transition-colors">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                <span>Filter & Pencarian</span>
                @if(request()->hasAny(['search', 'date', 'class_id', 'complaint_type', 'final_status']))
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                @endif
            </button>
            <span class="text-xs text-slate-400 font-semibold">{{ $visits->total() }} Catatan</span>
        </div>

        <form action="{{ route('admin.visits.index') }}" method="GET" id="filterContainer" class="space-y-4 {{ request()->hasAny(['search', 'date', 'class_id', 'complaint_type', 'final_status']) ? '' : 'hidden sm:block' }}">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                <!-- Search Siswa / NIS -->
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Cari Siswa / NIS</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama siswa atau NIS..."
                            class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Filter Tanggal -->
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Tanggal Kunjungan</label>
                    <input type="date" name="date" value="{{ request('date') }}"
                        class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                </div>

                <!-- Filter Kelas -->
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Kelas</label>
                    <select name="class_id" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                        <option value="">Semua Kelas</option>
                        @foreach($classes as $c)
                            <option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Keluhan -->
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Jenis Keluhan</label>
                    <select name="complaint_type" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                        <option value="">Semua Keluhan</option>
                        @foreach($complaints as $comp)
                            <option value="{{ $comp }}" {{ request('complaint_type') == $comp ? 'selected' : '' }}>{{ $comp }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Status -->
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Status Kunjungan</label>
                    <select name="final_status" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                        <option value="">Semua Status</option>
                        @foreach($statuses as $st)
                            <option value="{{ $st }}" {{ request('final_status') == $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-3 border-t border-slate-100">
                <span class="text-xs text-slate-500 font-medium hidden sm:inline">Menampilkan total <strong>{{ $visits->total() }}</strong> catatan kunjungan</span>
                <div class="flex items-center justify-end gap-2">
                    @if(request()->hasAny(['search', 'date', 'class_id', 'complaint_type', 'final_status']))
                        <a href="{{ route('admin.visits.index') }}" class="px-3.5 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
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

    <!-- VISITS CONTENT -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        
        <!-- Mobile Card View (Visible on Mobile / Hidden on Desktop) -->
        <div class="divide-y divide-slate-100 lg:hidden">
            @forelse($visits as $index => $visit)
                <div class="p-4 hover:bg-slate-50/70 transition-colors">
                    <div class="flex items-start justify-between gap-2.5 mb-2">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-9 h-9 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold flex items-center justify-center shrink-0">
                                {{ strtoupper(substr($visit->student?->name ?? 'UK', 0, 2)) }}
                            </div>
                            <div class="min-w-0">
                                @if($visit->student)
                                    <a href="{{ route('admin.students.show', $visit->student_id) }}" class="font-bold text-xs text-slate-900 hover:text-emerald-600 block truncate">
                                        {{ $visit->student->name }}
                                    </a>
                                    <p class="text-[11px] text-slate-400">NIS: {{ $visit->student->nis }} • <span class="font-semibold text-emerald-700">{{ $visit->student->schoolClass->name ?? '-' }}</span></p>
                                @else
                                    <span class="font-bold text-xs text-slate-400 italic">Siswa Terhapus</span>
                                @endif
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold shrink-0 {{ $visit->status_badge_class }}">
                            {{ $visit->final_status }}
                        </span>
                    </div>

                    <!-- Details Grid -->
                    <div class="bg-slate-50 p-2.5 rounded-xl text-[11px] text-slate-600 grid grid-cols-2 gap-2 my-2.5">
                        <div>
                            <span class="text-[10px] text-slate-400 block">Waktu</span>
                            <span class="font-bold text-slate-800">{{ $visit->visit_date->format('d/m/Y') }}</span>
                            <span class="text-slate-500 block">{{ substr($visit->arrival_time, 0, 5) }} WIB ({{ $visit->lesson_period }})</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 block">Keluhan</span>
                            <span class="font-bold text-rose-600">{{ $visit->complaint_type }}</span>
                            <span class="text-slate-500 block truncate" title="{{ $visit->complaint }}">{{ $visit->complaint }}</span>
                        </div>
                        @if($visit->temperature || $visit->blood_pressure)
                            <div class="col-span-2 pt-1 border-t border-slate-200/60 flex items-center gap-3 text-[10px]">
                                @if($visit->temperature)
                                    <span>Suhu: <strong>{{ $visit->temperature }}°C</strong></span>
                                @endif
                                @if($visit->blood_pressure)
                                    <span>Tensi: <strong>{{ $visit->blood_pressure }} mmHg</strong></span>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Actions Bar -->
                    <div class="flex items-center justify-between pt-1">
                        <span class="text-[10px] text-slate-400">Oleh: <strong class="text-slate-700">{{ $visit->officer?->name ?? 'Petugas' }}</strong></span>
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('admin.visits.show', $visit) }}" class="px-2.5 py-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition-colors">
                                Rekam
                            </a>
                            <a href="{{ route('admin.visits.print_permit', $visit) }}" target="_blank" class="p-1.5 text-teal-600 hover:bg-teal-50 rounded-lg transition-colors" title="Cetak Surat Izin">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            </a>
                            <a href="{{ route('admin.visits.edit', $visit) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit Kunjungan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.visits.destroy', $visit) }}" method="POST" onsubmit="return confirm('Hapus catatan kunjungan ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus Kunjungan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-10 text-center text-slate-400 text-xs font-medium">
                    Tidak ada catatan kunjungan yang cocok dengan filter.
                </div>
            @endforelse
        </div>

        <!-- Desktop Table View (Hidden on Mobile) -->
        <div class="overflow-x-auto hidden lg:block">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/80 text-[11px] uppercase tracking-wider text-slate-400 font-bold border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Nama Siswa</th>
                        <th class="py-3.5 px-4">Kelas</th>
                        <th class="py-3.5 px-4">Tanggal & Jam</th>
                        <th class="py-3.5 px-4">Jam Pelajaran</th>
                        <th class="py-3.5 px-4">Keluhan</th>
                        <th class="py-3.5 px-4">Tindakan</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Petugas</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($visits as $index => $visit)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-4 text-center text-xs text-slate-400 font-semibold">
                                {{ $visits->firstItem() + $index }}
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($visit->student?->name ?? 'UK', 0, 2)) }}
                                    </div>
                                    <div>
                                        @if($visit->student)
                                            <a href="{{ route('admin.students.show', $visit->student_id) }}" class="font-bold text-slate-900 hover:text-emerald-600 transition-colors">
                                                {{ $visit->student->name }}
                                            </a>
                                            <p class="text-[11px] text-slate-400">NIS: {{ $visit->student->nis }}</p>
                                        @else
                                            <span class="font-bold text-slate-400 italic">Siswa Terhapus</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-xs font-semibold text-slate-600">
                                {{ $visit->student?->schoolClass?->name ?? '-' }}
                            </td>
                            <td class="py-4 px-4 text-xs">
                                <p class="font-bold text-slate-800">{{ $visit->visit_date->format('d/m/Y') }}</p>
                                <p class="text-slate-400">{{ substr($visit->arrival_time, 0, 5) }} {{ $visit->departure_time ? '- ' . substr($visit->departure_time, 0, 5) : 'WIB' }}</p>
                            </td>
                            <td class="py-4 px-4 text-xs font-medium text-slate-700">
                                <span class="block font-semibold">{{ $visit->lesson_period }}</span>
                                @if($visit->subject)
                                    <span class="text-[11px] text-slate-400 truncate max-w-[130px] block" title="{{ $visit->subject }}">{{ $visit->subject }}</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-slate-100 text-slate-700">
                                    {{ $visit->complaint_type }}
                                </span>
                                <p class="text-xs text-slate-500 mt-1 max-w-[150px] truncate" title="{{ $visit->complaint }}">
                                    {{ $visit->complaint }}
                                </p>
                            </td>
                            <td class="py-4 px-4 text-xs text-slate-600 max-w-[160px] truncate" title="{{ $visit->treatment }}">
                                {{ $visit->treatment }}
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $visit->status_badge_class }}">
                                    {{ $visit->final_status }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-xs text-slate-500">
                                {{ $visit->officer?->name ?? '-' }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- Detail -->
                                    <a href="{{ route('admin.visits.show', $visit) }}" title="Lihat Rekam Kunjungan" class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>

                                    <!-- Cetak Izin -->
                                    <a href="{{ route('admin.visits.print_permit', $visit) }}" title="Cetak Surat Izin UKS" target="_blank" class="p-1.5 text-slate-400 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.visits.edit', $visit) }}" title="Edit Catatan Kunjungan" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    <!-- Hapus -->
                                    <form action="{{ route('admin.visits.destroy', $visit) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan kunjungan siswa ini? Data yang terhapus tidak dapat dipulihkan.')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Kunjungan" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="py-12 text-center text-slate-400">
                                <div class="max-w-xs mx-auto">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-3 text-slate-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <p class="font-bold text-slate-700">Tidak ada catatan kunjungan</p>
                                    <p class="text-xs text-slate-400 mt-1">Belum ada data kunjungan yang cocok dengan kriteria filter Anda.</p>
                                    <a href="{{ route('admin.visits.create') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors">
                                        <span>+ Catat Kunjungan Baru</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($visits->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $visits->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
