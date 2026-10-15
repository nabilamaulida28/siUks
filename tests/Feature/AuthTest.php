<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * Siswa dapat login menggunakan NIS dan dialihkan ke dashboard siswa.
     */
    public function test_student_can_login_with_nis(): void
    {
        $response = $this->post('/login', [
            'email' => '20241001',
            'password' => 'password',
        ]);

        $response->assertRedirect('/student/dashboard');
        $this->assertAuthenticated();
        $this->assertEquals('student', auth()->user()->role);
    }

    /**
     * Siswa kedua yang baru dibuat akunnya juga dapat login menggunakan NIS.
     */
    public function test_another_student_can_login_with_nis(): void
    {
        $response = $this->post('/login', [
            'email' => '20241003',
            'password' => 'password',
        ]);

        $response->assertRedirect('/student/dashboard');
        $this->assertAuthenticated();
        $this->assertEquals('student', auth()->user()->role);
    }

    /**
     * Admin dapat login menggunakan email dan dialihkan ke dashboard admin.
     */
    public function test_admin_can_login_with_email(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@siuks.sch.id',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticated();
        $this->assertEquals('admin', auth()->user()->role);
    }

    /**
     * Petugas UKS dapat login menggunakan email dan dialihkan ke dashboard admin.
     */
    public function test_officer_can_login_with_email(): void
    {
        $response = $this->post('/login', [
            'email' => 'petugas@siuks.sch.id',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticated();
        $this->assertEquals('officer', auth()->user()->role);
    }

    /**
     * Login gagal jika kata sandi salah.
     */
    public function test_login_fails_with_invalid_password(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@siuks.sch.id',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Pengguna dapat logout dengan sukses.
     */
    public function test_user_can_logout(): void
    {
        $user = User::where('role', 'admin')->first();
        $this->actingAs($user);

        $response = $this->post('/logout');
        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
