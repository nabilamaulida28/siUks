<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Tampilkan data siswa dengan filter kelas dan pencarian.
     */
    public function index(Request $request)
    {
        $query = Student::with('schoolClass')->withCount('visits');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $students = $query->orderBy('name')->paginate(15)->withQueryString();
        $classes = SchoolClass::active()->orderBy('name')->get();

        return view('admin.students.index', compact('students', 'classes'));
    }

    /**
     * Form tambah siswa.
     */
    public function create()
    {
        $classes = SchoolClass::active()->orderBy('name')->get();
        return view('admin.students.create', compact('classes'));
    }

    /**
     * Simpan data siswa baru.
     */
    public function store(StoreStudentRequest $request)
    {
        DB::transaction(function () use ($request) {
            $userId = null;

            // Jika opsi akun login siswa dicentang
            if ($request->boolean('create_user_account') && $request->filled('email')) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password ?? $request->nis),
                    'role' => 'student',
                    'phone' => $request->phone,
                    'position' => 'Siswa',
                    'is_active' => true,
                ]);
                $userId = $user->id;
            }

            $data = $request->except(['create_user_account', 'email', 'password']);
            $data['user_id'] = $userId;

            Student::create($data);
        });

        return redirect()->route('admin.students.index')->with('success', 'Data siswa baru berhasil ditambahkan!');
    }

    /**
     * Detail siswa dan riwayat kunjungannya ke UKS.
     */
    public function show(Student $student)
    {
        $student->load(['schoolClass', 'user']);
        $totalVisits = $student->visits()->count();
        $latestVisit = $student->visits()->first();
        $visits = $student->visits()->with('officer')->paginate(10);

        return view('admin.students.show', compact('student', 'totalVisits', 'latestVisit', 'visits'));
    }

    /**
     * Form edit siswa.
     */
    public function edit(Student $student)
    {
        $classes = SchoolClass::active()->orderBy('name')->get();
        return view('admin.students.edit', compact('student', 'classes'));
    }

    /**
     * Update data siswa.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->validated());

        // Update nama di tabel user jika ada akunnya
        if ($student->user) {
            $student->user->update([
                'name' => $student->name,
                'phone' => $student->phone,
            ]);
        }

        return redirect()->route('admin.students.show', $student)->with('success', 'Data siswa berhasil diperbarui!');
    }

    /**
     * Hapus data siswa.
     */
    public function destroy(Student $student)
    {
        DB::transaction(function () use ($student) {
            if ($student->user) {
                $student->user->delete();
            }
            $student->delete();
        });

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
