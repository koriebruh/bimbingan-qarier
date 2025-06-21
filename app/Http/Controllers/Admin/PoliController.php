<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    public function index()
    {
        $polis = Poli::latest()->paginate(10);
        return view('admin.poli.index', compact('polis'));
    }

    public function create()
    {
        return view('admin.poli.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        Poli::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.poli.index')->with('success', 'Poli berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $poli = Poli::findOrFail($id);
        return view('admin.poli.edit', compact('poli'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        $poli = Poli::findOrFail($id);
        $poli->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.poli.index')->with('success', 'Poli berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $poli = Poli::findOrFail($id);
        $poli->delete();

        return redirect()->route('admin.poli.index')->with('success', 'Poli berhasil dihapus.');
    }
}
