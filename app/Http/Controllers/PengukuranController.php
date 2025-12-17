<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Balita;
use App\Models\Pengukuran;
use Carbon\Carbon;

class PengukuranController extends Controller
{
    private $mlApiUrl = 'http://localhost:5000';

    public function index()
    {
        $pengukurans = Pengukuran::with('balita')->latest()->paginate(15);
        return view('pengukuran.index', compact('pengukurans'));
    }

    public function create()
    {
        $balitas = Balita::orderBy('nama_balita')->get();
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

        // Get balita data for ML prediction
        $balita = Balita::find($data['id_balita']);
        
        // Calculate BMI
        $tb_m = $data['tinggi_badan'] / 100;
        $bmi = round($data['berat_badan'] / ($tb_m * $tb_m), 2);
        
        // Predict with ML
        $status_gizi = $this->predictWithML([
            'usia_bulan' => $data['usia_bulan'],
            'jenis_kelamin' => $balita->jenis_kelamin,
            'berat_badan' => $data['berat_badan'],
            'tinggi_badan' => $data['tinggi_badan'],
            'lingkar_kepala' => $data['lingkar_kepala'],
            'lila' => $data['lila'],
        ]);
        
        // Fallback if ML fails
        if ($status_gizi === null) {
            $status_gizi = $this->determineStatusGizi($data['usia_bulan'], $bmi);
        }
        
        // Get recommendations
        $rekomendasi = implode("\n", $this->getRecommendations($status_gizi));

        // Create pengukuran with prediction
        Pengukuran::create([
            'id_balita' => $data['id_balita'],
            'tanggal_pengukuran' => $data['tanggal_pengukuran'],
            'usia_bulan' => $data['usia_bulan'],
            'berat_badan' => $data['berat_badan'],
            'tinggi_badan' => $data['tinggi_badan'],
            'lingkar_kepala' => $data['lingkar_kepala'],
            'lila' => $data['lila'],
            'bmi' => $bmi,
            'status_gizi_ml' => $status_gizi,
            'rekomendasi' => $rekomendasi,
        ]);

        return redirect()->route('pengukuran.index')
            ->with('success', 'Data pengukuran berhasil ditambahkan. Status Gizi: ' . $status_gizi);
    }

    public function edit($id)
    {
        $pengukuran = Pengukuran::with('balita')->findOrFail($id);
        $balitas = Balita::orderBy('nama_balita')->get();
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
        $balita = Balita::find($data['id_balita']);
        
        // Recalculate BMI and prediction
        $tb_m = $data['tinggi_badan'] / 100;
        $bmi = round($data['berat_badan'] / ($tb_m * $tb_m), 2);
        
        $status_gizi = $this->predictWithML([
            'usia_bulan' => $data['usia_bulan'],
            'jenis_kelamin' => $balita->jenis_kelamin,
            'berat_badan' => $data['berat_badan'],
            'tinggi_badan' => $data['tinggi_badan'],
            'lingkar_kepala' => $data['lingkar_kepala'],
            'lila' => $data['lila'],
        ]);
        
        if ($status_gizi === null) {
            $status_gizi = $this->determineStatusGizi($data['usia_bulan'], $bmi);
        }
        
        $rekomendasi = implode("\n", $this->getRecommendations($status_gizi));

        $pengukuran->update([
            'id_balita' => $data['id_balita'],
            'tanggal_pengukuran' => $data['tanggal_pengukuran'],
            'usia_bulan' => $data['usia_bulan'],
            'berat_badan' => $data['berat_badan'],
            'tinggi_badan' => $data['tinggi_badan'],
            'lingkar_kepala' => $data['lingkar_kepala'],
            'lila' => $data['lila'],
            'bmi' => $bmi,
            'status_gizi_ml' => $status_gizi,
            'rekomendasi' => $rekomendasi,
        ]);

        return redirect()->route('pengukuran.index')
            ->with('success', 'Data pengukuran berhasil diperbarui. Status Gizi: ' . $status_gizi);
    }

    public function destroy($id)
    {
        $pengukuran = Pengukuran::findOrFail($id);
        $pengukuran->delete();

        return redirect()->route('pengukuran.index')
            ->with('success', 'Data pengukuran berhasil dihapus.');
    }

    private function predictWithML($data)
    {
        try {
            $response = Http::timeout(5)->post($this->mlApiUrl . '/predict', $data);
            
            if ($response->successful()) {
                $result = $response->json();
                if ($result['success'] ?? false) {
                    return $result['status_gizi'];
                }
            }
            return null;
        } catch (\Exception $e) {
            Log::warning('ML API call failed', ['error' => $e->getMessage()]);
            return null;
        }
    }

    private function determineStatusGizi($usia, $bmi)
    {
        if ($usia < 6) {
            return $bmi < 12 ? 'Gizi Buruk' : 'Gizi Normal';
        } elseif ($usia < 24) {
            return $bmi < 13 ? 'Gizi Buruk' : 'Gizi Normal';
        } else {
            return $bmi < 14 ? 'Gizi Buruk' : 'Gizi Normal';
        }
    }

    private function getRecommendations($status)
    {
        $recommendations = [
            'Gizi Buruk' => [
                'Segera konsultasi ke fasilitas kesehatan terdekat',
                'Tingkatkan frekuensi makan (5-6 kali/hari)',
                'Berikan makanan bergizi tinggi protein dan kalori',
                'Monitor pertumbuhan setiap minggu',
                'Berikan suplemen vitamin sesuai anjuran dokter'
            ],
            'Gizi Normal' => [
                'Pertahankan pola makan sehat dan seimbang',
                'Lanjutkan ASI hingga 2 tahun jika memungkinkan',
                'Berikan makanan variatif dari berbagai sumber gizi',
                'Monitor pertumbuhan setiap bulan di Posyandu',
                'Jaga kebersihan makanan dan lingkungan'
            ],
        ];

        return $recommendations[$status] ?? $recommendations['Gizi Normal'];
    }
}
