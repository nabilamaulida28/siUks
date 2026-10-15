<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [
            [
                'name' => 'X PPLG 1',
                'grade' => 'X',
                'major' => 'Pengembangan Perangkat Lunak dan GIM',
                'homeroom_teacher' => 'Dra. Sri Wahyuni, M.Pd',
                'status' => 'active',
            ],
            [
                'name' => 'X PPLG 2',
                'grade' => 'X',
                'major' => 'Pengembangan Perangkat Lunak dan GIM',
                'homeroom_teacher' => 'Budi Santoso, S.Pd',
                'status' => 'active',
            ],
            [
                'name' => 'XI PPLG 1',
                'grade' => 'XI',
                'major' => 'Pengembangan Perangkat Lunak dan GIM',
                'homeroom_teacher' => 'Ahmad Fauzi, M.Kom',
                'status' => 'active',
            ],
            [
                'name' => 'XI PPLG 2',
                'grade' => 'XI',
                'major' => 'Pengembangan Perangkat Lunak dan GIM',
                'homeroom_teacher' => 'Rina Marlina, S.T',
                'status' => 'active',
            ],
            [
                'name' => 'XII PPLG 1',
                'grade' => 'XII',
                'major' => 'Pengembangan Perangkat Lunak dan GIM',
                'homeroom_teacher' => 'Hendra Pratama, S.Kom',
                'status' => 'active',
            ],
            [
                'name' => 'X DKV 1',
                'grade' => 'X',
                'major' => 'Desain Komunikasi Visual',
                'homeroom_teacher' => 'Siti Nurhaliza, S.Pd',
                'status' => 'active',
            ],
            [
                'name' => 'XI DKV 1',
                'grade' => 'XI',
                'major' => 'Desain Komunikasi Visual',
                'homeroom_teacher' => 'Joko Prasetyo, M.Sn',
                'status' => 'active',
            ],
        ];

        foreach ($classes as $class) {
            SchoolClass::updateOrCreate(['name' => $class['name']], $class);
        }
    }
}
