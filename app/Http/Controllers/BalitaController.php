<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Balita;

class BalitaController extends Controller
{
    public function index(Request $request)
    {
        // paging sederhana (10/baris)
        $balitas = Balita::paginate(10);
        return view('balita.index', compact('balitas'));
    }

    public function show($id)
    {
        $balita = Balita::with(['pengukuran.statusGizi'])->findOrFail($id);

        // ambil pengukuran terbaru untuk menampilkan saran terakhir
        $last = $balita->pengukuran()->with('statusGizi')->first();

        return view('balita.show', compact('balita','last'));
    }

    public function getBalitaData($id)
    {
        $balita = Balita::findOrFail($id);
        
        // Hitung usia dalam bulan
        $tanggalLahir = \Carbon\Carbon::parse($balita->tanggal_lahir);
        $usiaBulan = $tanggalLahir->diffInMonths(\Carbon\Carbon::now());
        
        return response()->json([
            'jenis_kelamin' => $balita->jenis_kelamin,
            'usia_bulan' => $usiaBulan
        ]);
    }
}
