<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'user_id',
        'visit_date',
        'arrival_time',
        'departure_time',
        'lesson_period',
        'subject',
        'complaint_type',
        'complaint',
        'temperature',
        'blood_pressure',
        'general_condition',
        'treatment',
        'final_status',
        'notes',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'temperature' => 'float',
    ];

    public const COMPLAINTS = [
        'Pusing',
        'Sakit kepala',
        'Demam',
        'Mual',
        'Sakit perut',
        'Luka',
        'Batuk',
        'Sesak napas',
        'Lemas',
        'Cedera',
        'Menstruasi',
        'Pingsan',
        'Keluhan lainnya',
    ];

    public const LESSON_PERIODS = [
        'Jam ke-1',
        'Jam ke-2',
        'Jam ke-3',
        'Jam ke-4',
        'Jam ke-5',
        'Jam ke-6',
        'Jam ke-7',
        'Jam ke-8',
        'Jam ke-9',
        'Jam ke-10',
    ];

    public const FINAL_STATUSES = [
        'Kembali ke kelas',
        'Istirahat di UKS',
        'Dijemput orang tua',
        'Dipulangkan',
        'Dirujuk ke fasilitas kesehatan',
        'Masih dalam pemantauan',
    ];

    public const COMMON_TREATMENTS = [
        'Istirahat di ranjang UKS',
        'Pemberian obat',
        'Pemberian pertolongan pertama',
        'Kompres air hangat / dingin',
        'Membersihkan & membalut luka',
        'Pemeriksaan kondisi & tanda vital',
        'Menghubungi wali kelas',
        'Menghubungi orang tua/wali',
        'Dirujuk ke fasilitas kesehatan',
        'Tindakan lainnya',
    ];

    /**
     * Siswa yang berkunjung.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Petugas UKS yang menangani / mencatat.
     */
    public function officer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Helper untuk kelas badge status
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->final_status) {
            'Kembali ke kelas' => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20',
            'Istirahat di UKS' => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20',
            'Masih dalam pemantauan' => 'bg-yellow-50 text-yellow-800 ring-1 ring-inset ring-yellow-600/20',
            'Dijemput orang tua' => 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-700/20',
            'Dipulangkan' => 'bg-purple-50 text-purple-700 ring-1 ring-inset ring-purple-700/20',
            'Dirujuk ke fasilitas kesehatan' => 'bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20',
            default => 'bg-slate-50 text-slate-700 ring-1 ring-inset ring-slate-600/20',
        };
    }
}
