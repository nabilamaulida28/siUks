@extends('layouts.student')

@section('title', 'Profil Belum Terhubung')

@section('content')
<div class="max-w-md mx-auto py-12 text-center">
    <div class="w-16 h-16 rounded-3xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
    </div>
    <h2 class="text-xl font-bold text-slate-900">Profil Siswa Belum Dihubungkan</h2>
    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
        Akun login Anda ({{ auth()->user()->email }}) belum dihubungkan dengan data identitas siswa di sistem. Silakan hubungi Petugas UKS sekolah untuk mengaitkan akun Anda dengan nomor induk siswa Anda.
    </p>
    <div class="mt-6 flex justify-center gap-3">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition-colors">
                Keluar
            </button>
        </form>
    </div>
</div>
@endsection
