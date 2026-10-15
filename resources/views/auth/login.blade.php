@extends('layouts.auth')

@section('title', 'Masuk ke Sistem SIUKS')

@section('content')
<div class="w-full max-w-md bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
    <!-- Header Banner -->
    <div class="bg-gradient-to-br from-emerald-600 to-teal-700 p-8 text-white text-center relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-36 h-36 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/15 backdrop-blur-md mb-4 shadow-inner ring-1 ring-white/30">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
        </div>
        <h1 class="text-2xl font-black tracking-tight">SI<span class="text-emerald-200">UKS</span></h1>
        <p class="text-xs font-semibold uppercase tracking-widest text-emerald-100 mt-0.5">Sistem Informasi Kunjungan UKS</p>
        <p class="text-xs text-emerald-100/90 mt-2 max-w-xs mx-auto">Kelola pencatatan, pemantauan, dan rekapitulasi kesehatan siswa secara terintegrasi.</p>
    </div>

    <!-- Form Container -->
    <div class="p-8">
        @if(session('error'))
            <div class="mb-5 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold flex items-center gap-2">
                <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Email / NIS Field -->
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Email atau NIS Siswa</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <input type="text" id="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full pl-11 pr-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-rose-300 ring-2 ring-rose-100' : 'border-slate-200' }} text-sm focus:outline-none focus:border-emerald-500 focus:ring-3 focus:ring-emerald-100 transition-all placeholder-slate-400"
                        placeholder="admin@siuks.sch.id atau NIS Siswa">
                </div>
                @error('email')
                    <p class="text-rose-600 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kata Sandi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <input type="password" id="password" name="password" required
                        class="w-full pl-11 pr-11 py-3 rounded-xl border {{ $errors->has('password') ? 'border-rose-300 ring-2 ring-rose-100' : 'border-slate-200' }} text-sm focus:outline-none focus:border-emerald-500 focus:ring-3 focus:ring-emerald-100 transition-all placeholder-slate-400"
                        placeholder="••••••••">
                    <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600">
                        <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-rose-600 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between pt-1">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <span class="text-xs text-slate-600 font-medium select-none">Ingat saya di perangkat ini</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" class="w-full py-3.5 px-4 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-sm rounded-xl shadow-md shadow-emerald-600/25 transition-all flex items-center justify-center gap-2">
                    <span>Masuk ke SIUKS</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>

        <!-- Quick Demo Credentials for Fast Testing -->
        <div class="mt-8 pt-6 border-t border-slate-100">
            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 text-center mb-3">Akun Demo Cepat (Klik untuk Isi)</p>
            <div class="grid grid-cols-3 gap-2">
                <button type="button" onclick="fillDemo('admin@siuks.sch.id', 'password')" class="p-2 text-center rounded-xl bg-slate-50 hover:bg-emerald-50 hover:border-emerald-200 border border-slate-200 text-slate-700 hover:text-emerald-800 transition-all text-xs font-semibold">
                    <span class="block font-bold">Admin</span>
                    <span class="text-[10px] text-slate-400">Semua Akses</span>
                </button>
                <button type="button" onclick="fillDemo('petugas@siuks.sch.id', 'password')" class="p-2 text-center rounded-xl bg-slate-50 hover:bg-emerald-50 hover:border-emerald-200 border border-slate-200 text-slate-700 hover:text-emerald-800 transition-all text-xs font-semibold">
                    <span class="block font-bold">Petugas</span>
                    <span class="text-[10px] text-slate-400">Kelola UKS</span>
                </button>
                <button type="button" onclick="fillDemo('20241001', 'password')" class="p-2 text-center rounded-xl bg-slate-50 hover:bg-emerald-50 hover:border-emerald-200 border border-slate-200 text-slate-700 hover:text-emerald-800 transition-all text-xs font-semibold">
                    <span class="block font-bold">Siswa</span>
                    <span class="text-[10px] text-slate-400">NIS: 20241001</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        const input = document.getElementById('password');
        if (input.type === 'password') {
            input.type = 'text';
        } else {
            input.type = 'password';
        }
    }

    function fillDemo(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
    }
</script>
@endsection
