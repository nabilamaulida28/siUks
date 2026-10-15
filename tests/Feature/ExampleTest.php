<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Pengguna belum login dialihkan ke halaman login.
     */
    public function test_unauthenticated_user_is_redirected_to_login(): void
    {
        $response = $this->get('/');
        $response->assertRedirect('/login');
    }

    /**
     * Halaman login dapat dirender dengan sukses.
     */
    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('SIUKS');
        $response->assertSee('Masuk ke SIUKS');
    }

    /**
     * Admin dapat mengakses dashboard admin.
     */
    public function test_admin_can_access_dashboard(): void
    {
        $admin = User::where('role', 'admin')->first();
        $this->actingAs($admin);

        $response = $this->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Statistik UKS');
    }

    /**
     * Siswa dapat mengakses dashboard siswa.
     */
    public function test_student_can_access_student_dashboard(): void
    {
        $student = User::where('role', 'student')->first();
        $this->actingAs($student);

        $response = $this->get('/student/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Portal Siswa');
    }
}
