<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nis',
        'nisn',
        'name',
        'gender',
        'birth_place',
        'birth_date',
        'class_id',
        'major',
        'phone',
        'parent_name',
        'parent_phone',
        'address',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Akun login siswa (jika ada).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Kelas siswa.
     */
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Seluruh riwayat kunjungan UKS siswa ini.
     */
    public function visits()
    {
        return $this->hasMany(Visit::class, 'student_id')->orderBy('visit_date', 'desc')->orderBy('arrival_time', 'desc');
    }

    /**
     * Kunjungan terakhir siswa.
     */
    public function latestVisit()
    {
        return $this->hasOne(Visit::class, 'student_id')->latestOfMany('visit_date');
    }

    /**
     * Status apakah siswa saat ini sedang berada di UKS.
     */
    public function isCurrentlyInUks(): bool
    {
        $latest = $this->visits()->whereDate('visit_date', now()->toDateString())->first();
        if (!$latest) {
            return false;
        }

        return in_array($latest->final_status, ['Istirahat di UKS', 'Masih dalam pemantauan']);
    }

    /**
     * Scope siswa aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
