<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Tamu dapat melihat halaman utama tanpa harus masuk.
     */
    public function test_guest_can_view_the_landing_page(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sistem Informasi Kesehatan Siswa');
        $response->assertSee('Kenali lebih cepat,');
        $response->assertSee('Masuk ke portal');
        $response->assertSee('href="/login"', false);
    }

    public function test_authenticated_users_are_redirected_to_their_dashboard(): void
    {
        $student = User::where('role', 'student')->firstOrFail();
        $this->actingAs($student)
            ->get('/')
            ->assertRedirect(route('student.dashboard'));

        $admin = User::where('role', 'admin')->firstOrFail();
        $this->actingAs($admin)
            ->get('/')
            ->assertRedirect(route('admin.dashboard'));
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
