<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class DokterManagementController extends Controller
{
    public function index()
    {
        $users = User::all()->where('role','dokter');
        return view('admin.dokter.index')->with([
            'users' => $users,
        ]);
    }

    public function create()
    {
        $polis = Poli::class::all();

        return view('admin.dokter.create', compact('polis'));
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
            'poli_id' => ['nullable', 'exists:poli,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role'=> 'dokter',
            'poli_id' => $request->poli_id,
        ]);

        return redirect(route('admin.dokter.index', absolute: false));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $polis = Poli::class::all();

        return view('admin.dokter.edit', compact(['user','polis']));
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
            'poli_id' => ['nullable', 'exists:poli,id'],
            'password' => ['nullable', 'string', 'min:8']
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'poli_id' => $request->poli_id,
            'password' => Hash::make($request->password),

        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('admin.dokter.index')->with('success', 'Data dokter berhasil diubah.');
    }

    public function destroy($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dokter.index')->with('success', 'Data dokter berhasil dihapus.');
    }

}
