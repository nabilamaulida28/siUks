<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VisitSeeder extends Seeder
{
    public function run(): void
    {
        $officers = User::whereIn('role', ['admin', 'officer'])->get();
        $students = Student::all();

        if ($students->isEmpty() || $officers->isEmpty()) {
            return;
        }

        $officer1 = $officers->first();
        $officer2 = $officers->count() > 1 ? $officers->get(1) : $officer1;

        $today = Carbon::today();

        // 1. Kunjungan HARI INI (termasuk yang sedang di UKS)
        $todayVisits = [
            [
                'student' => $students->firstWhere('nis', '20241001'), // Aditya
                'officer' => $officer1,
                'visit_date' => $today->toDateString(),
                'arrival_time' => '08:15:00',
                'departure_time' => null,
                'lesson_period' => 'Jam ke-2',
                'subject' => 'Pemrograman Web / Pak Ahmad',
                'complaint_type' => 'Pusing',
                'complaint' => 'Kepala terasa berputar dan mata berkunang-kunang setelah upacara/kegiatan pagi.',
                'temperature' => 36.8,
                'blood_pressure' => '110/70',
                'general_condition' => 'Tampak pucat dan lemas',
                'treatment' => 'Istirahat di ranjang UKS, kompres dahi, diberikan teh manis hangat.',
                'final_status' => 'Istirahat di UKS',
                'notes' => 'Diperiksa kembali 30 menit ke depan.',
            ],
            [
                'student' => $students->firstWhere('nis', '20241002'), // Anisa
                'officer' => $officer2,
                'visit_date' => $today->toDateString(),
                'arrival_time' => '09:00:00',
                'departure_time' => null,
                'lesson_period' => 'Jam ke-3',
                'subject' => 'Matematika / Bu Sri',
                'complaint_type' => 'Sakit perut',
                'complaint' => 'Perut melilit dan perih karena belum sempat sarapan pagi.',
                'temperature' => 36.5,
                'blood_pressure' => '115/75',
                'general_condition' => 'Sadar penuh, memegangi perut',
                'treatment' => 'Pemberian obat antasida dan biskuit gandum, istirahat berbaring.',
                'final_status' => 'Masih dalam pemantauan',
                'notes' => 'Jika membaik sebelum jam ke-4 diperbolehkan kembali ke kelas.',
            ],
            [
                'student' => $students->firstWhere('nis', '20241003'), // Bayu
                'officer' => $officer1,
                'visit_date' => $today->toDateString(),
                'arrival_time' => '07:30:00',
                'departure_time' => '08:10:00',
                'lesson_period' => 'Jam ke-1',
                'subject' => 'Bahasa Indonesia / Bu Rina',
                'complaint_type' => 'Luka',
                'complaint' => 'Lutut lecet tergores aspal saat turun dari motor di depan gerbang sekolah.',
                'temperature' => 36.6,
                'blood_pressure' => '120/80',
                'general_condition' => 'Sadar penuh, luka lecet ringan',
                'treatment' => 'Membersihkan luka dengan rivanol, pemberian antiseptik betadine dan plester.',
                'final_status' => 'Kembali ke kelas',
                'notes' => 'Luka sudah dibersihkan dan ditutup rapat.',
            ],
            [
                'student' => $students->firstWhere('nis', '20241004'), // Citra
                'officer' => $officer2,
                'visit_date' => $today->toDateString(),
                'arrival_time' => '10:30:00',
                'departure_time' => '11:15:00',
                'lesson_period' => 'Jam ke-5',
                'subject' => 'Bahasa Inggris / Pak Joko',
                'complaint_type' => 'Demam',
                'complaint' => 'Badan menggigil dan terasa panas sejak jam pelajaran kedua.',
                'temperature' => 38.6,
                'blood_pressure' => '110/70',
                'general_condition' => 'Badan panas tinggi, menggigil',
                'treatment' => 'Pemberian paracetamol 500mg, kompres hangat, menghubungi orang tua.',
                'final_status' => 'Dijemput orang tua',
                'notes' => 'Orang tua sudah menjemput pukul 11.15 WIB untuk dibawa ke dokter keluarga.',
            ],
        ];

        foreach ($todayVisits as $v) {
            if ($v['student']) {
                Visit::create([
                    'student_id' => $v['student']->id,
                    'user_id' => $v['officer']->id,
                    'visit_date' => $v['visit_date'],
                    'arrival_time' => $v['arrival_time'],
                    'departure_time' => $v['departure_time'],
                    'lesson_period' => $v['lesson_period'],
                    'subject' => $v['subject'],
                    'complaint_type' => $v['complaint_type'],
                    'complaint' => $v['complaint'],
                    'temperature' => $v['temperature'],
                    'blood_pressure' => $v['blood_pressure'],
                    'general_condition' => $v['general_condition'],
                    'treatment' => $v['treatment'],
                    'final_status' => $v['final_status'],
                    'notes' => $v['notes'],
                ]);
            }
        }

        // 2. Kunjungan Hari-Hari Sebelumnya (untuk tren grafik dan riwayat)
        $pastVisitsData = [
            [
                'days_ago' => 1,
                'period' => 'Jam ke-4',
                'subject' => 'Olahraga / Pak Hendra',
                'complaint_type' => 'Cedera',
                'complaint' => 'Pergelangan kaki kanan terkilir saat bermain bola basket.',
                'temperature' => 36.5,
                'blood_pressure' => '125/80',
                'general_condition' => 'Nyeri di pergelangan kaki kanan, bengkak ringan',
                'treatment' => 'Kompres es batu (RICE protocol), dibalut perban elastis, istirahat.',
                'final_status' => 'Dipulangkan',
                'notes' => 'Disarankan foto rontgen jika nyeri berlanjut.',
            ],
            [
                'days_ago' => 1,
                'period' => 'Jam ke-2',
                'subject' => 'Basis Data / Pak Budi',
                'complaint_type' => 'Mual',
                'complaint' => 'Mual dan muntah 1 kali di toilet kelas.',
                'temperature' => 37.1,
                'blood_pressure' => '105/65',
                'general_condition' => 'Lemas, bibir kering',
                'treatment' => 'Minum air hangat sedikit-sedikit, pemberian minyak kayu putih dan istirahat.',
                'final_status' => 'Kembali ke kelas',
                'notes' => 'Kondisi membaik setelah istirahat 45 menit.',
            ],
            [
                'days_ago' => 2,
                'period' => 'Jam ke-1',
                'subject' => 'Upacara / Wali Kelas',
                'complaint_type' => 'Pingsan',
                'complaint' => 'Pingsan saat pelaksanaan upacara bendera hari Senin.',
                'temperature' => 36.4,
                'blood_pressure' => '95/60',
                'general_condition' => 'Sempat hilang kesadaran 2 menit, setelah sadar lemas',
                'treatment' => 'Baringkan dengan kaki lebih tinggi, rangsang minyak kayu putih, beri teh manis hangat.',
                'final_status' => 'Kembali ke kelas',
                'notes' => 'Siswa mengaku tidur larut malam dan tidak sarapan.',
            ],
            [
                'days_ago' => 2,
                'period' => 'Jam ke-6',
                'subject' => 'Desain Grafis / Bu Siti',
                'complaint_type' => 'Sakit kepala',
                'complaint' => 'Sakit kepala sebelah (migrain) akibat terlalu lama menatap monitor komputer.',
                'temperature' => 36.7,
                'blood_pressure' => '115/75',
                'general_condition' => 'Mata lelah, nyeri kepala',
                'treatment' => 'Istirahat di ruangan redup, relaksasi mata, pemberian paracetamol.',
                'final_status' => 'Kembali ke kelas',
                'notes' => 'Sudah membaik dan izin masuk jam ke-8.',
            ],
            [
                'days_ago' => 3,
                'period' => 'Jam ke-3',
                'subject' => 'PKN / Bu Dra. Sri',
                'complaint_type' => 'Menstruasi',
                'complaint' => 'Dismenore / kram perut bawah hari pertama haid.',
                'temperature' => 36.8,
                'blood_pressure' => '110/70',
                'general_condition' => 'Meringkuk menahan nyeri haid',
                'treatment' => 'Kompres hangat di perut bawah, istirahat berbaring, teh hangat.',
                'final_status' => 'Kembali ke kelas',
                'notes' => 'Nyeri mereda setelah 1 jam kompres hangat.',
            ],
            [
                'days_ago' => 4,
                'period' => 'Jam ke-5',
                'subject' => 'Fisika / Pak Joko',
                'complaint_type' => 'Sesak napas',
                'complaint' => 'Riwayat asma kambuh setelah berlari di lapangan.',
                'temperature' => 36.6,
                'blood_pressure' => '120/80',
                'general_condition' => 'Napas berbunyi mengi (wheezing), gelisah',
                'treatment' => 'Duduk tegak, bantuan inhaler milik siswa, longgarkan pakaian, pantau saturasi oksigen.',
                'final_status' => 'Dirujuk ke fasilitas kesehatan',
                'notes' => 'Segera dibawa ke Puskesmas terdekat karena mengi belum berkurang.',
            ],
            [
                'days_ago' => 5,
                'period' => 'Jam ke-2',
                'subject' => 'Sejarah / Bu Rina',
                'complaint_type' => 'Batuk',
                'complaint' => 'Batuk terus menerus hingga dada sakit dan tenggorokan gatal.',
                'temperature' => 37.3,
                'blood_pressure' => '118/78',
                'general_condition' => 'Batuk kering berulang',
                'treatment' => 'Diberikan air putih hangat dan sirup batuk herbal.',
                'final_status' => 'Kembali ke kelas',
                'notes' => 'Disarankan memakai masker di kelas.',
            ],
            [
                'days_ago' => 6,
                'period' => 'Jam ke-4',
                'subject' => 'Kimia / Bu Siti',
                'complaint_type' => 'Pusing',
                'complaint' => 'Pusing berputar, riwayat vertigo ringan.',
                'temperature' => 36.6,
                'blood_pressure' => '110/70',
                'general_condition' => 'Tampak menunduk lemas',
                'treatment' => 'Istirahat tidur posisi nyaman, hindari gerakan tiba-tiba.',
                'final_status' => 'Kembali ke kelas',
                'notes' => 'Sudah stabil.',
            ],
            [
                'days_ago' => 8,
                'period' => 'Jam ke-3',
                'subject' => 'Animasi / Pak Joko',
                'complaint_type' => 'Lemas',
                'complaint' => 'Badan lemas sekali dan tidak bertenaga.',
                'temperature' => 36.4,
                'blood_pressure' => '100/65',
                'general_condition' => 'Hipotensi ringan, lemas',
                'treatment' => 'Diberi larutan gula dan istirahat 1 jam.',
                'final_status' => 'Kembali ke kelas',
                'notes' => 'Kondisi kembali segar.',
            ],
            [
                'days_ago' => 12,
                'period' => 'Jam ke-7',
                'subject' => 'PPLG / Pak Ahmad',
                'complaint_type' => 'Pusing',
                'complaint' => 'Pusing dan pandangan kabur.',
                'temperature' => 36.7,
                'blood_pressure' => '115/75',
                'general_condition' => 'Lemas',
                'treatment' => 'Istirahat dan minum air putih.',
                'final_status' => 'Kembali ke kelas',
                'notes' => 'Diizinkan kembali ke kelas jam ke-9.',
            ],
            [
                'days_ago' => 15,
                'period' => 'Jam ke-1',
                'subject' => 'Agama / Pak Fauzi',
                'complaint_type' => 'Demam',
                'complaint' => 'Suhu tubuh panas sejak malam hari.',
                'temperature' => 38.3,
                'blood_pressure' => '110/70',
                'general_condition' => 'Demam tinggi, muka memerah',
                'treatment' => 'Paracetamol, kompres air biasa, hubungi keluarga.',
                'final_status' => 'Dijemput orang tua',
                'notes' => 'Dipulangkan bersama orang tua.',
            ],
            [
                'days_ago' => 18,
                'period' => 'Jam ke-5',
                'subject' => 'BK / Bu Sri',
                'complaint_type' => 'Sakit perut',
                'complaint' => 'Nyeri lambung / maag kumat.',
                'temperature' => 36.7,
                'blood_pressure' => '115/75',
                'general_condition' => 'Nyeri tekan epigastrium',
                'treatment' => 'Antasida kunyah 1 tablet, minum air hangat.',
                'final_status' => 'Kembali ke kelas',
                'notes' => 'Nyeri berkurang signifikan.',
            ],
            [
                'days_ago' => 22,
                'period' => 'Jam ke-6',
                'subject' => 'PPLG / Pak Budi',
                'complaint_type' => 'Pusing',
                'complaint' => 'Kurang tidur karena mengerjakan tugas kelompok.',
                'temperature' => 36.5,
                'blood_pressure' => '110/70',
                'general_condition' => 'Mengantuk dan pusing',
                'treatment' => 'Istirahat di ranjang UKS selama 1 jam.',
                'final_status' => 'Kembali ke kelas',
                'notes' => 'Sudah segar kembali.',
            ],
            [
                'days_ago' => 25,
                'period' => 'Jam ke-2',
                'subject' => 'DKV / Pak Joko',
                'complaint_type' => 'Luka',
                'complaint' => 'Jari telunjuk terkena cutter saat memotong kertas duplek.',
                'temperature' => 36.6,
                'blood_pressure' => '120/80',
                'general_condition' => 'Perdarahan luka sayat kecil',
                'treatment' => 'Tekan luka hingga perdarahan berhenti, antiseptik povidone iodine, balut kasa steril.',
                'final_status' => 'Kembali ke kelas',
                'notes' => 'Perdarahan berhenti sempurna.',
            ],
        ];

        foreach ($pastVisitsData as $index => $item) {
            $student = $students[$index % $students->count()];
            $officer = $index % 2 === 0 ? $officer1 : $officer2;
            $visitDate = Carbon::today()->subDays($item['days_ago'])->toDateString();

            Visit::create([
                'student_id' => $student->id,
                'user_id' => $officer->id,
                'visit_date' => $visitDate,
                'arrival_time' => '08:30:00',
                'departure_time' => '09:30:00',
                'lesson_period' => $item['period'],
                'subject' => $item['subject'],
                'complaint_type' => $item['complaint_type'],
                'complaint' => $item['complaint'],
                'temperature' => $item['temperature'],
                'blood_pressure' => $item['blood_pressure'],
                'general_condition' => $item['general_condition'],
                'treatment' => $item['treatment'],
                'final_status' => $item['final_status'],
                'notes' => $item['notes'],
            ]);
        }
    }
}
