<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClassRequest;
use App\Http\Requests\UpdateClassRequest;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    /**
     * Tampilkan data kelas.
     */
    public function index(Request $request)
    {
        $query = SchoolClass::withCount('students');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('major', 'like', "%{$search}%")
                  ->orWhere('homeroom_teacher', 'like', "%{$search}%");
        }

        if ($request->filled('grade')) {
            $query->where('grade', $request->grade);
        }

        $classes = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.classes.index', compact('classes'));
    }

    /**
     * Form tambah kelas.
     */
    public function create()
    {
        return view('admin.classes.create');
    }

    /**
     * Simpan kelas baru.
     */
    public function store(StoreClassRequest $request)
    {
        SchoolClass::create($request->validated());

        return redirect()->route('admin.classes.index')->with('success', 'Data kelas berhasil ditambahkan!');
    }

    /**
     * Form edit kelas.
     */
    public function edit(SchoolClass $class)
    {
        return view('admin.classes.edit', compact('class'));
    }

    /**
     * Update data kelas.
     */
    public function update(UpdateClassRequest $request, SchoolClass $class)
    {
        $class->update($request->validated());

        return redirect()->route('admin.classes.index')->with('success', 'Data kelas berhasil diperbarui!');
    }

    /**
     * Hapus kelas.
     */
    public function destroy(SchoolClass $class)
    {
        if ($class->students()->count() > 0) {
            return back()->with('error', 'Kelas tidak dapat dihapus karena masih memiliki data siswa terkait.');
        }

        $class->delete();

        return redirect()->route('admin.classes.index')->with('success', 'Data kelas berhasil dihapus.');
    }
}
