<?php

namespace Tests\Feature;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use App\Models\Visit;
use Tests\TestCase;

class VisitAndReportTest extends TestCase
{
    /**
     * Admin dapat mencatat kunjungan baru dan melihat detail serta cetak surat izin.
     */
    public function test_admin_can_record_visit_and_print_permit(): void
    {
        $admin = User::where('role', 'admin')->first();
        $student = Student::first();

        $this->actingAs($admin);

        // 1. Simpan Kunjungan Baru
        $visitData = [
            'student_id' => $student->id,
            'visit_date' => date('Y-m-d'),
            'arrival_time' => '10:00',
            'departure_time' => '10:45',
            'lesson_period' => 'Jam ke-4',
            'subject' => 'Fisika',
            'complaint_type' => 'Pusing',
            'complaint' => 'Siswa merasa pusing dan kunang-kunang.',
            'temperature' => 36.6,
            'blood_pressure' => '110/70',
            'general_condition' => 'Tampak lemas',
            'treatment' => 'Istirahat di UKS dan minum air hangat.',
            'final_status' => 'Kembali ke kelas',
            'notes' => 'Kondisi sudah membaik.',
        ];

        $response = $this->post(route('admin.visits.store'), $visitData);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $createdVisit = Visit::latest('id')->first();
        $this->assertEquals('Pusing', $createdVisit->complaint_type);

        // 2. Akses halaman detail rekam kunjungan
        $detailResponse = $this->get(route('admin.visits.show', $createdVisit));
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('Kartu Rekam Kunjungan UKS');
        $detailResponse->assertSee($student->name);

        // 3. Akses halaman cetak surat izin UKS
        $permitResponse = $this->get(route('admin.visits.print_permit', $createdVisit));
        $permitResponse->assertStatus(200);
        $permitResponse->assertSee('SURAT KETERANGAN KUNJUNGAN UKS');

        // 4. Akses halaman laporan
        $reportResponse = $this->get(route('admin.reports.index'));
        $reportResponse->assertStatus(200);
        $reportResponse->assertSee('Laporan & Rekapitulasi UKS');

        // 5. Download export CSV laporan
        $csvResponse = $this->get(route('admin.reports.export_csv'));
        $csvResponse->assertStatus(200);
        $csvResponse->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }

    /**
     * Siswa dapat melihat detail kunjungannya sendiri, namun dicegah melihat milik siswa lain.
     */
    public function test_student_visit_authorization(): void
    {
        $student1 = Student::where('nis', '20241001')->first();
        $student2 = Student::where('nis', '20241002')->first();

        // Kunjungan untuk siswa 1
        $visit1 = Visit::where('student_id', $student1->id)->first();
        if (!$visit1) {
            $visit1 = Visit::create([
                'student_id' => $student1->id,
                'user_id' => 1,
                'visit_date' => date('Y-m-d'),
                'arrival_time' => '09:00',
                'lesson_period' => 'Jam ke-2',
                'complaint_type' => 'Demam',
                'complaint' => 'Badan panas dingin',
                'treatment' => 'Paracetamol',
                'final_status' => 'Istirahat di UKS',
            ]);
        }

        // Kunjungan untuk siswa 2
        $visit2 = Visit::where('student_id', $student2->id)->first();
        if (!$visit2) {
            $visit2 = Visit::create([
                'student_id' => $student2->id,
                'user_id' => 1,
                'visit_date' => date('Y-m-d'),
                'arrival_time' => '11:00',
                'lesson_period' => 'Jam ke-5',
                'complaint_type' => 'Maag',
                'complaint' => 'Perut perih',
                'treatment' => 'Antasida',
                'final_status' => 'Kembali ke kelas',
            ]);
        }

        // Siswa 1 login
        $this->actingAs($student1->user);

        // Siswa 1 dapat melihat kunjungannya sendiri
        $response1 = $this->get(route('student.visits.show', $visit1));
        $response1->assertStatus(200);

        // Siswa 1 dapat mencetak surat izin kunjungannya sendiri
        $printResponse = $this->get(route('student.visits.print_permit', $visit1));
        $printResponse->assertStatus(200);
        $printResponse->assertSee('SURAT KETERANGAN KUNJUNGAN UKS');

        // Siswa 1 dilarang melihat kunjungan siswa 2 (403 Forbidden)
        $responseForbidden = $this->get(route('student.visits.show', $visit2));
        $responseForbidden->assertStatus(403);

        // Siswa 1 dilarang mengakses admin dashboard (dialihkan ke dashboard siswa dengan pesan error)
        $adminDashboardResponse = $this->get(route('admin.dashboard'));
        $adminDashboardResponse->assertRedirect(route('student.dashboard'));
        $adminDashboardResponse->assertSessionHas('error');
    }
}
