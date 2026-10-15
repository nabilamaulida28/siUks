@extends(auth()->user()->role === 'student' ? 'layouts.student' : 'layouts.app')

@section('title', 'Profil Pengguna')
@section('page_title', 'Pengaturan Akun')
@section('page_description', 'Kelola informasi identitas akun dan perbarui kata sandi Anda')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Profile Overview Card -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200 p-6 sm:p-8 flex flex-col sm:flex-row items-center gap-6">
        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-emerald-500 to-teal-700 text-white font-black text-3xl flex items-center justify-center shadow-lg shadow-emerald-500/20 ring-4 ring-emerald-100">
            {{ strtoupper(substr($user->name, 0, 2)) }}
        </div>
        <div class="flex-1 text-center sm:text-left">
            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mb-1">
                <h3 class="text-xl font-black text-slate-900">{{ $user->name }}</h3>
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : ($user->role === 'officer' ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700') }}">
                    {{ $user->role === 'admin' ? 'Administrator' : ($user->role === 'officer' ? 'Petugas UKS' : 'Siswa') }}
                </span>
            </div>
            <p class="text-sm text-slate-500 font-medium">{{ $user->email }}</p>
            <p class="text-xs text-slate-400 mt-1">Status Akun: <span class="text-emerald-600 font-bold">Aktif</span> | Terdaftar sejak: {{ $user->created_at->translatedFormat('d F Y') }}</p>
        </div>
    </div>

    <!-- Edit Profile Form Card -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200 p-6 sm:p-8">
        <h4 class="text-base font-bold text-slate-900 mb-6 pb-3 border-b border-slate-100 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            Perbarui Informasi Akun
        </h4>

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    @error('name')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email (Read-only) -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Email Akun (Tidak dapat diubah)</label>
                    <input type="email" id="email" value="{{ $user->email }}" disabled
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-400 text-sm cursor-not-allowed">
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nomor HP / WhatsApp</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    @error('phone')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jabatan / Peran (Readonly) -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Jabatan</label>
                    <input type="text" value="{{ $user->position ?? '-' }}" disabled
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-400 text-sm cursor-not-allowed">
                </div>
            </div>

            <!-- Password Change Section -->
            <div class="pt-6 border-t border-slate-100">
                <h5 class="text-sm font-bold text-slate-900 mb-1">Ganti Kata Sandi</h5>
                <p class="text-xs text-slate-500 mb-4">Kosongkan bagian ini jika Anda tidak ingin mengganti kata sandi.</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="current_password" class="block text-xs font-semibold text-slate-700 mb-1.5">Kata Sandi Saat Ini</label>
                        <input type="password" id="current_password" name="current_password"
                            class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100" placeholder="••••••••">
                        @error('current_password')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="new_password" class="block text-xs font-semibold text-slate-700 mb-1.5">Kata Sandi Baru</label>
                        <input type="password" id="new_password" name="new_password"
                            class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100" placeholder="Minimal 6 karakter">
                        @error('new_password')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="new_password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1.5">Ulangi Sandi Baru</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                            class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100" placeholder="Ulangi kata sandi baru">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-4">
                <button type="submit" class="w-full sm:w-auto justify-center px-6 py-3 sm:py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-sm shadow-emerald-600/20 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
