<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // Petugas UKS yang mencatat
            $table->date('visit_date');
            $table->time('arrival_time');
            $table->time('departure_time')->nullable();
            $table->string('lesson_period', 50); // Jam ke-1 s/d Jam ke-10
            $table->string('subject', 100)->nullable(); // Guru / Pelajaran yang sedang berlangsung
            $table->string('complaint_type', 100); // Pusing, Sakit kepala, Demam, Mual, dll
            $table->text('complaint'); // Rincian keluhan
            $table->decimal('temperature', 4, 1)->nullable(); // Suhu tubuh (°C)
            $table->string('blood_pressure', 30)->nullable(); // Tekanan darah (mmHg)
            $table->string('general_condition', 150)->nullable(); // Kondisi umum siswa
            $table->text('treatment'); // Tindakan petugas (Istirahat, Obat, Kompres, dll)
            $table->string('final_status', 100)->default('Kembali ke kelas'); // Kembali ke kelas, Istirahat di UKS, Dijemput orang tua, Dipulangkan, Dirujuk ke fasilitas kesehatan, Masih dalam pemantauan
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
