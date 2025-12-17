<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Balita;
use App\Models\Pengukuran;
use Carbon\Carbon;

class BalitaController extends Controller
{
    public function index(Request $request)
    {
        $balitas = Balita::orderBy('nama_balita')->paginate(15);
        return view('balita.index', compact('balitas'));
    }

    public function show($id)
    {
        $balita = Balita::findOrFail($id);
        
        // Get all pengukuran with predictions
        $pengukurans = Pengukuran::where('id_balita', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get latest prediction
        $lastPrediksi = Pengukuran::where('id_balita', $id)
            ->whereNotNull('status_gizi_ml')
            ->latest()
            ->first();

        // Calculate age
        $usia = Carbon::parse($balita->tanggal_lahir)->diffInMonths(Carbon::now());

        return view('balita.show', compact('balita', 'pengukurans', 'lastPrediksi', 'usia'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_balita' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'nama_ortu' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
        ]);

        Balita::create($data);

        return redirect()->route('balita.index')
            ->with('success', 'Data balita berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama_balita' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'nama_ortu' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
        ]);

        $balita = Balita::findOrFail($id);
        $balita->update($data);

        return redirect()->route('balita.index')
            ->with('success', 'Data balita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $balita = Balita::findOrFail($id);
        
        // Delete related pengukuran first
        Pengukuran::where('id_balita', $id)->delete();
        
        $balita->delete();

        return redirect()->route('balita.index')
            ->with('success', 'Data balita berhasil dihapus.');
    }

    public function getBalitaData($id)
    {
        $balita = Balita::findOrFail($id);
        
        // Hitung usia dalam bulan (integer)
        $tanggalLahir = Carbon::parse($balita->tanggal_lahir);
        $usiaBulan = (int) $tanggalLahir->diffInMonths(Carbon::now());
        
        return response()->json([
            'jenis_kelamin' => $balita->jenis_kelamin,
            'usia_bulan' => max(12, $usiaBulan)
        ]);
    }
}
