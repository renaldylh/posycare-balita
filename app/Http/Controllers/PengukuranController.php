<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Balita;
use App\Models\Pengukuran;

class PengukuranController extends Controller
{
    public function index()
    {
        $pengukurans = Pengukuran::with('balita')->latest()->get();
        return view('pengukuran.index', compact('pengukurans'));
    }

    public function create()
    {
        $balitas = Balita::all();
        return view('pengukuran.create', compact('balitas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_balita' => 'required|exists:balita,id_balita',
            'tanggal_pengukuran' => 'required|date',
            'usia_bulan' => 'required|integer',
            'berat_badan' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
            'lingkar_kepala' => 'required|numeric',
            'lila' => 'required|numeric',
        ]);

        Pengukuran::create($data);

        return redirect()->route('pengukuran.index')
            ->with('success', 'Data pengukuran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pengukuran = Pengukuran::with('balita')->findOrFail($id);
        $balitas = Balita::all();
        return view('pengukuran.edit', compact('pengukuran', 'balitas'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'id_balita' => 'required|exists:balita,id_balita',
            'tanggal_pengukuran' => 'required|date',
            'usia_bulan' => 'required|integer',
            'berat_badan' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
            'lingkar_kepala' => 'required|numeric',
            'lila' => 'required|numeric',
        ]);

        $pengukuran = Pengukuran::findOrFail($id);
        $pengukuran->update($data);

        return redirect()->route('pengukuran.index')
            ->with('success', 'Data pengukuran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengukuran = Pengukuran::findOrFail($id);
        $pengukuran->delete();

        return redirect()->route('pengukuran.index')
            ->with('success', 'Data pengukuran berhasil dihapus.');
    }
}
