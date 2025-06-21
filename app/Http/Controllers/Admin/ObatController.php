<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::paginate(10);
        return view('admin.obat.index')->with([
            'obats' => $obats,
        ]);
    }

    public function create()
    {
        return view('admin.obat.create');
    }

    public function edit($id)
    {
//        $obat = Obat::find($id); karena ada softdelete
        $obat = Obat::withTrashed()->findOrFail($id);
        return view('admin.obat.edit')->with([
            'obat' => $obat,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan' => 'required|string|max:255',
            'harga'    => 'required|numeric|min:0',
        ]);

        Obat::create([
            'nama_obat' => $request->nama_obat,
            'kemasan'   => $request->kemasan,
            'harga'     => $request->harga,
        ]);

        return redirect()->route('admin.obat.index')->with('status', 'obat-created');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan'   => 'required|string|max:255',
            'harga'     => 'required|numeric|min:0',
        ]);

        $obat = Obat::withTrashed()->findOrFail($id);

        $obat->update([
            'nama_obat' => $request->nama_obat,
            'kemasan'   => $request->kemasan,
            'harga'     => $request->harga,
        ]);

        return redirect()->route('admin.obat.index')->with('status', 'obat-updated');
    }

    public function destroy($id)
    {
        $obat = Obat::find($id);
        $obat->delete();

        return redirect()->route('admin.obat.index');
    }

    public function recycle()
    {
        $obats = Obat::onlyTrashed()->get();
        return view('admin.obat.restore')->with([
            'obats' => $obats,
        ]);
    }

    public function restore($id)
    {
        $obat = Obat::withTrashed()->find($id);
        if ($obat) {
            $obat->restore();
            return redirect()->route('admin.obat.index')->with('status', 'obat-restored');
        }
        return redirect()->route('admin.obat.index')->with('error', 'obat-not-found');
    }
}
