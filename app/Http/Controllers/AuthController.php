<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'student') {
                return redirect()->route('student.dashboard');
            }
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses login pengguna.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email atau NIS wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        try {
            // Mendukung login via email atau NIS (untuk siswa)
            $loginType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'nis';

            if ($loginType === 'nis') {
                // Cari siswa berdasarkan NIS
                $student = \App\Models\Student::where('nis', trim($request->email))->first();

                if ($student) {
                    if (!$student->user) {
                        return back()->withInput()->withErrors([
                            'email' => 'Siswa dengan NIS ' . $student->nis . ' belum memiliki akun login. Silakan hubungi petugas UKS.'
                        ]);
                    }

                    if (Hash::check($request->password, $student->user->password)) {
                        if (!$student->user->is_active) {
                            return back()->withInput()->withErrors(['email' => 'Akun Anda dinonaktifkan. Silakan hubungi petugas UKS.']);
                        }

                        Auth::login($student->user, $remember);
                        $request->session()->regenerate();
                        return redirect()->intended(route('student.dashboard'))->with('success', 'Selamat datang kembali, ' . $student->name . '!');
                    }
                }

                throw ValidationException::withMessages([
                    'email' => ['NIS atau kata sandi yang Anda masukkan tidak cocok.'],
                ]);
            }

            // Login dengan email (Admin / Petugas / Siswa yang memasukkan email)
            if (Auth::attempt(['email' => trim($request->email), 'password' => $request->password], $remember)) {
                $user = Auth::user();

                if (!$user->is_active) {
                    Auth::logout();
                    return back()->withInput()->withErrors(['email' => 'Akun Anda dinonaktifkan. Silakan hubungi admin.']);
                }

                $request->session()->regenerate();

                if ($user->role === 'student') {
                    return redirect()->intended(route('student.dashboard'))->with('success', 'Selamat datang kembali, ' . $user->name . '!');
                }

                return redirect()->intended(route('admin.dashboard'))->with('success', 'Selamat datang kembali, ' . $user->name . '!');
            }

            throw ValidationException::withMessages([
                'email' => ['Email atau kata sandi yang Anda masukkan tidak cocok.'],
            ]);
        } catch (\Illuminate\Database\QueryException | \PDOException $e) {
            return back()->withInput()->with('error', 'Koneksi ke database gagal: ' . $e->getMessage() . '. Pastikan MySQL di XAMPP Control Panel sudah aktif (Running).');
        }
    }

    /**
     * Logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }

    /**
     * Tampilkan halaman profil pengguna.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    /**
     * Update profil dan kata sandi pengguna.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:25',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'current_password.required_with' => 'Password lama wajib diisi jika ingin mengganti password.',
            'new_password.min' => 'Password baru minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama yang Anda masukkan salah.']);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->name = $validated['name'];
        $user->phone = $validated['phone'];
        $user->save();

        return back()->with('success', 'Profil dan informasi akun berhasil diperbarui.');
    }
}
