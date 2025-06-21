<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasienManagementController extends Controller
{
    public function index()
    {
        $users = User::all()->where('role','pasien');
        return view('admin.pasien.index')->with([
            'users' => $users,
        ]);
    }

    public function create()
    {

        return view('admin.pasien.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required','string'],
            'alamat' => ['required', 'string', 'max:255'],
            'no_ktp' => ['required', 'string', 'max:16', 'unique:'.User::class],
            'no_hp' => ['required', 'string', 'max:15', 'unique:'.User::class],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role'=> 'pasien',
        ]);

        return redirect(route('admin.pasien.index', absolute: false));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.pasien.edit', compact(['user']));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'alamat' => ['required', 'string', 'max:255'],
            'no_ktp' => ['required', 'string', 'max:16', 'unique:users,no_ktp,' . $user->id],
            'no_hp' => ['required', 'string', 'max:15', 'unique:users,no_hp,' . $user->id],
            'password' => ['nullable', 'string', 'min:8']
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),

        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('admin.pasien.index')->with('success', 'Data dokter berhasil diubah.');
    }

    public function destroy($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.pasien.index')->with('success', 'Data dokter berhasil dihapus.');
    }

}
