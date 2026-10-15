<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cetak Dokumen UKS')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
                color: black !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .print-page {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                width: 100% !important;
            }
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen text-slate-800 font-sans p-4 sm:p-8">

    <!-- Top Action Bar for Printing -->
    <div class="no-print max-w-4xl mx-auto mb-6 flex items-center justify-between bg-white p-4 rounded-2xl shadow-sm border border-slate-200">
        <div class="flex items-center gap-3">
            <button onclick="window.history.back()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </button>
            <span class="text-sm font-bold text-slate-700">Pratinjau Cetak Dokumen</span>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Sekarang (Print / PDF)
            </button>
        </div>
    </div>

    <!-- Printable Paper Sheet -->
    <div class="print-page max-w-4xl mx-auto bg-white p-8 sm:p-12 rounded-2xl shadow-md border border-slate-200">
        <!-- Kop Surat Resmi -->
        <div class="border-b-4 border-double border-slate-800 pb-4 mb-6">
            <div class="flex items-center justify-between gap-6">
                <div class="w-20 h-20 rounded-2xl bg-emerald-700 text-white flex flex-col items-center justify-center font-bold">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="text-[10px] tracking-widest mt-0.5">UKS</span>
                </div>
                <div class="flex-1 text-center">
                    <h2 class="text-sm font-bold tracking-wider text-slate-700 uppercase">PEMERINTAH PROVINSI DAERAH KHUSUS IBUKOTA JAKARTA</h2>
                    <h1 class="text-xl sm:text-2xl font-black text-slate-950 tracking-tight uppercase">SMK NEGERI CONTOH JAKARTA</h1>
                    <h3 class="text-sm font-extrabold text-emerald-800 uppercase tracking-widest">UNIT KESEHATAN SEKOLAH (UKS)</h3>
                    <p class="text-xs text-slate-500 mt-1">Jl. Pendidikan No. 45, Kebayoran Baru, Jakarta Selatan | Telp: (021) 7890123 | Email: uks@smknegeri.sch.id</p>
                </div>
                <div class="w-20 hidden sm:block"></div>
            </div>
        </div>

        <!-- Document Content -->
        @yield('content')
    </div>

</body>
</html>
