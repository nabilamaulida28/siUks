<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfficerRequest;
use App\Http\Requests\UpdateOfficerRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class OfficerController extends Controller
{
    /**
     * Tampilkan data petugas UKS dan Admin.
     */
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['admin', 'officer'])->withCount('visits');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $officers = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.officers.index', compact('officers'));
    }

    /**
     * Form tambah petugas.
     */
    public function create()
    {
        return view('admin.officers.create');
    }

    /**
     * Simpan petugas baru.
     */
    public function store(StoreOfficerRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('officers', 'public');
        }

        User::create($data);

        return redirect()->route('admin.officers.index')->with('success', 'Petugas UKS baru berhasil ditambahkan!');
    }

    /**
     * Form edit data petugas.
     */
    public function edit(User $officer)
    {
        return view('admin.officers.edit', compact('officer'));
    }

    /**
     * Update data petugas.
     */
    public function update(UpdateOfficerRequest $request, User $officer)
    {
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('profile_photo')) {
            if ($officer->profile_photo && Storage::disk('public')->exists($officer->profile_photo)) {
                Storage::disk('public')->delete($officer->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')->store('officers', 'public');
        }

        $officer->update($data);

        return redirect()->route('admin.officers.index')->with('success', 'Data petugas UKS berhasil diperbarui!');
    }

    /**
     * Hapus petugas UKS.
     */
    public function destroy(User $officer)
    {
        if ($officer->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        if ($officer->profile_photo && Storage::disk('public')->exists($officer->profile_photo)) {
            Storage::disk('public')->delete($officer->profile_photo);
        }

        $officer->delete();

        return redirect()->route('admin.officers.index')->with('success', 'Data petugas berhasil dihapus.');
    }
}
