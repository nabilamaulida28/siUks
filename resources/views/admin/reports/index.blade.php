@extends('layouts.app')

@section('title', 'Laporan Kunjungan UKS')
@section('page_title', 'Laporan & Rekapitulasi UKS')
@section('page_description', 'Laporan periodik kunjungan siswa, rekapitulasi keluhan, cetak berkas dan ekspor dokumen')

@section('header_actions')
    <div class="flex items-center gap-2">
        <!-- Print Button -->
        <a href="{{ route('admin.reports.print', request()->query()) }}" target="_blank" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl shadow-xs transition-colors flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            <span>Cetak Laporan Resmi</span>
        </a>

        <!-- Export CSV Button -->
        <a href="{{ route('admin.reports.export_csv', request()->query()) }}" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-xs transition-colors flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span>Export Excel / CSV</span>
        </a>
    </div>
@endsection

@section('content')
<div class="space-y-6">

    <!-- FILTER PERIODE LAPORAN -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="space-y-4">
            
            <!-- Preset Buttons -->
            <div>
                <span class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Pilih Periode Waktu Laporan:</span>
                <div class="flex overflow-x-auto gap-2 pb-1.5 sm:pb-0 sm:flex-wrap no-scrollbar">
                    <a href="{{ route('admin.reports.index', ['preset' => 'today']) }}" class="whitespace-nowrap px-3.5 py-1.5 text-xs font-bold rounded-xl transition-all shrink-0 {{ $preset === 'today' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Hari Ini
                    </a>
                    <a href="{{ route('admin.reports.index', ['preset' => 'this_week']) }}" class="whitespace-nowrap px-3.5 py-1.5 text-xs font-bold rounded-xl transition-all shrink-0 {{ $preset === 'this_week' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Minggu Ini
                    </a>
                    <a href="{{ route('admin.reports.index', ['preset' => 'this_month']) }}" class="whitespace-nowrap px-3.5 py-1.5 text-xs font-bold rounded-xl transition-all shrink-0 {{ $preset === 'this_month' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Bulan Ini
                    </a>
                    <a href="{{ route('admin.reports.index', ['preset' => 'this_year']) }}" class="whitespace-nowrap px-3.5 py-1.5 text-xs font-bold rounded-xl transition-all shrink-0 {{ $preset === 'this_year' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Tahun Ini
                    </a>
                </div>
            </div>

            <input type="hidden" name="preset" value="custom">

            <!-- Custom Date Range & Filters Grid -->
            <div class="pt-4 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ $startDate }}"
                        class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate }}"
                        class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Kelas</label>
                    <select name="class_id" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                        <option value="">Semua Kelas</option>
                        @foreach($classes as $c)
                            <option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Keluhan</label>
                    <select name="complaint_type" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 bg-white">
                        <option value="">Semua Keluhan</option>
                        @foreach($complaints as $comp)
                            <option value="{{ $comp }}" {{ request('complaint_type') == $comp ? 'selected' : '' }}>{{ $comp }}</option>
                        @endforeach
                    </select>
                </div>

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

            <div class="flex justify-end pt-2">
                <button type="submit" class="w-full sm:w-auto justify-center px-5 py-2.5 text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 rounded-xl transition-colors flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Tampilkan Laporan
                </button>
            </div>
        </form>
    </div>

    <!-- SUMMARY METRICS CARDS -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Kunjungan</span>
            <p class="text-2xl sm:text-3xl font-black text-slate-900 mt-1 sm:mt-1.5">{{ $totalVisits }}</p>
            <p class="text-[11px] text-slate-400 mt-1 truncate">{{ date('d/m/y', strtotime($startDate)) }} - {{ date('d/m/y', strtotime($endDate)) }}</p>
        </div>

        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Siswa</span>
            <p class="text-2xl sm:text-3xl font-black text-emerald-600 mt-1 sm:mt-1.5">{{ $totalUniqueStudents }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Siswa unik</p>
        </div>

        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-slate-400">Keluhan Terbanyak</span>
            <p class="text-lg sm:text-2xl font-black text-slate-900 mt-1 sm:mt-1.5 truncate">{{ $topComplaint ? $topComplaint->complaint_type : '-' }}</p>
            <p class="text-[11px] text-slate-400 mt-1">{{ $topComplaint ? $topComplaint->total . ' kasus' : 'Belum ada data' }}</p>
        </div>

        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-slate-400">Kelas Terbanyak</span>
            <p class="text-lg sm:text-2xl font-black text-blue-600 mt-1 sm:mt-1.5 truncate">{{ $topClass ? $topClass->class_name : '-' }}</p>
            <p class="text-[11px] text-slate-400 mt-1">{{ $topClass ? $topClass->total . ' kunjungan' : 'Belum ada data' }}</p>
        </div>
    </div>

    <!-- REPORT LIST (MOBILE CARDS & DESKTOP TABLE) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h3 class="text-base font-bold text-slate-900">Rincian Seluruh Kunjungan Periode Ini</h3>
                <p class="text-xs text-slate-500 mt-0.5">Periode {{ date('d/m/Y', strtotime($startDate)) }} s/d {{ date('d/m/Y', strtotime($endDate)) }}</p>
            </div>
            <span class="text-xs font-bold px-3 py-1 bg-slate-100 rounded-lg text-slate-700 w-fit">{{ $visits->count() }} Data Ditemukan</span>
        </div>

        <!-- Mobile Card View (block lg:hidden) -->
        <div class="block lg:hidden divide-y divide-slate-100">
            @forelse($visits as $index => $visit)
                <div class="p-4 space-y-2.5 hover:bg-slate-50/50 transition-colors">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-400">#{{ $index + 1 }}</span>
                                <h4 class="text-sm font-black text-slate-900">{{ $visit->student?->name ?? 'Siswa Terhapus' }}</h4>
                            </div>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">
                                <span class="font-bold text-emerald-700">{{ $visit->student?->schoolClass?->name ?? '-' }}</span> • NIS: {{ $visit->student?->nis ?? '-' }}
                            </p>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold shrink-0 {{ $visit->status_badge_class }}">
                            {{ $visit->final_status }}
                        </span>
                    </div>

                    <!-- Date & Period -->
                    <div class="flex items-center justify-between text-xs text-slate-500 bg-slate-50 p-2 rounded-xl">
                        <div class="flex items-center gap-1.5 font-medium">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>{{ $visit->visit_date->format('d/m/Y') }} ({{ substr($visit->arrival_time, 0, 5) }} WIB)</span>
                        </div>
                        <span class="font-semibold text-slate-700">{{ $visit->lesson_period }}</span>
                    </div>

                    <!-- Complaint & Treatment -->
                    <div class="text-xs space-y-1">
                        <div>
                            <span class="font-semibold text-slate-400">Keluhan:</span>
                            <span class="font-bold text-slate-800">{{ $visit->complaint_type }}</span>
                            @if($visit->complaint)
                                <p class="text-slate-600 text-[11px] mt-0.5 italic">"{{ $visit->complaint }}"</p>
                            @endif
                        </div>
                        @if($visit->treatment)
                            <div>
                                <span class="font-semibold text-slate-400">Tindakan:</span>
                                <span class="font-medium text-slate-700">{{ $visit->treatment }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Footer Officer -->
                    <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                        <span>Petugas: <strong class="text-slate-700">{{ $visit->officer?->name ?? '-' }}</strong></span>
                        <a href="{{ route('admin.visits.show', $visit) }}" class="font-bold text-emerald-600 hover:underline">
                            Lihat Rekam →
                        </a>
                    </div>
                </div>
            @empty
                <div class="py-10 px-4 text-center text-slate-400 font-medium text-xs">
                    Tidak ada catatan kunjungan dalam rentang periode yang dipilih.
                </div>
            @endforelse
        </div>

        <!-- Desktop Table View (hidden lg:block) -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/80 text-[11px] uppercase tracking-wider text-slate-400 font-bold border-b border-slate-100">
                    <tr>
                        <th class="py-3 px-4 w-12 text-center">No</th>
                        <th class="py-3 px-4">Tanggal & Jam</th>
                        <th class="py-3 px-4">Nama Siswa</th>
                        <th class="py-3 px-4">Kelas</th>
                        <th class="py-3 px-4">Jam Ke</th>
                        <th class="py-3 px-4">Keluhan</th>
                        <th class="py-3 px-4">Tindakan</th>
                        <th class="py-3 px-4">Status Akhir</th>
                        <th class="py-3 px-4">Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-xs">
                    @forelse($visits as $index => $visit)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3.5 px-4 text-center text-slate-400 font-semibold">{{ $index + 1 }}</td>
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-900">{{ $visit->visit_date->format('d/m/Y') }}</span>
                                <span class="block text-slate-400">{{ substr($visit->arrival_time, 0, 5) }} WIB</span>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                {{ $visit->student?->name ?? 'Siswa Terhapus' }}
                                <span class="block text-[11px] font-normal text-slate-400">NIS: {{ $visit->student?->nis ?? '-' }}</span>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-700">
                                {{ $visit->student?->schoolClass?->name ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4 font-medium text-slate-600">
                                {{ $visit->lesson_period }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-900">{{ $visit->complaint_type }}</span>
                                <p class="text-slate-500 truncate max-w-[140px]" title="{{ $visit->complaint }}">{{ $visit->complaint }}</p>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 truncate max-w-[160px]" title="{{ $visit->treatment }}">
                                {{ $visit->treatment }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $visit->status_badge_class }}">
                                    {{ $visit->final_status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500">
                                {{ $visit->officer?->name ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-10 text-center text-slate-400">
                                Tidak ada catatan kunjungan dalam rentang periode yang dipilih.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
