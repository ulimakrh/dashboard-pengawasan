<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private function checkSuperAdmin()
    {
        $user = auth()->user();
        if (!$user || !$user->isSuperAdmin()) {
            abort(403, 'Akses Ditolak. Hanya Super Admin yang dapat mengakses fitur ini.');
        }
    }

    public function index()
    {
        $this->checkSuperAdmin();
        $users = User::orderBy('name', 'asc')->get();
        $satkers = \App\Models\Satker::orderBy('nama_entitas', 'asc')->get();
        return view('users.index', compact('users', 'satkers'));
    }

    private function generateName($request)
    {
        if ($request->role === 'satker' && $request->satker_id) {
            $satker = \App\Models\Satker::find($request->satker_id);
            return $satker ? $satker->nama_entitas : 'Admin Satker';
        } elseif ($request->role === 'itwil' && $request->wilayah_id) {
            return 'Auditor ' . $request->wilayah_id;
        } elseif ($request->role === 'super_admin') {
            return 'Super Admin';
        } elseif ($request->role === 'manager') {
            return 'Manager';
        }
        return 'User';
    }

    public function store(Request $request)
    {
        $this->checkSuperAdmin();

        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:super_admin,manager,itwil,satker',
            'satker_id' => 'nullable|exists:satkers,id',
            'wilayah_id' => 'nullable|string',
        ]);

        $name = $this->generateName($request);

        User::create([
            'name' => $name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'satker_id' => $request->satker_id,
            'wilayah_id' => $request->wilayah_id,
        ]);

        return back()->with('success', 'User baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $this->checkSuperAdmin();

        $user = User::findOrFail($id);

        $request->validate([
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:super_admin,manager,itwil,satker',
            'satker_id' => 'nullable|exists:satkers,id',
            'wilayah_id' => 'nullable|string',
        ]);

        $user->name = $this->generateName($request);
        $user->email = $request->email;
        $user->role = $request->role;
        $user->satker_id = $request->satker_id;
        $user->wilayah_id = $request->wilayah_id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $this->checkSuperAdmin();

        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus!');
    }
}
