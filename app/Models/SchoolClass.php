<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'grade',
        'major',
        'homeroom_teacher',
        'status',
    ];

    /**
     * Relasi ke data siswa di kelas ini.
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    /**
     * Scope untuk kelas yang aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
