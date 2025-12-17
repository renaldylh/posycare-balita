<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Balita;
use App\Models\Pengukuran;
use Carbon\Carbon;

class PrediksiController extends Controller
{
    // Python ML API URL
    private $mlApiUrl = 'http://localhost:5000';

    /**
     * Form prediksi - pilih balita atau input manual
     */
    public function index()
    {
        $balitas = Balita::orderBy('nama_balita')->get();
        return view('prediksi.index', compact('balitas'));
    }

    /**
     * Rekap semua prediksi
     */
    public function rekap(Request $request)
    {
        $query = Pengukuran::with('balita')
            ->whereNotNull('status_gizi_ml')
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_gizi_ml', $request->status);
        }

        // Filter by date range
        if ($request->filled('dari')) {
            $query->whereDate('tanggal_pengukuran', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_pengukuran', '<=', $request->sampai);
        }

        // Filter by balita
        if ($request->filled('balita_id')) {
            $query->where('id_balita', $request->balita_id);
        }

        $prediksis = $query->paginate(15);

        // Statistics
        $totalPrediksi = Pengukuran::whereNotNull('status_gizi_ml')->count();
        $giziNormal = Pengukuran::where('status_gizi_ml', 'Gizi Normal')->count();
        $giziBuruk = Pengukuran::where('status_gizi_ml', 'Gizi Buruk')->count();
        
        $balitas = Balita::orderBy('nama_balita')->get();

        return view('prediksi.rekap', compact('prediksis', 'balitas', 'totalPrediksi', 'giziNormal', 'giziBuruk'));
    }

    /**
     * Detail satu prediksi
     */
    public function show($id)
    {
        $prediksi = Pengukuran::with('balita')->findOrFail($id);
        return view('prediksi.show', compact('prediksi'));
    }

    /**
     * Get balita data for auto-fill (including last pengukuran)
     */
    public function getBalitaData($id)
    {
        $balita = Balita::findOrFail($id);
        
        // Hitung usia dalam bulan (integer, min 12)
        $tanggalLahir = Carbon::parse($balita->tanggal_lahir);
        $usiaBulan = max(12, (int) $tanggalLahir->diffInMonths(Carbon::now()));
        
        // Get last pengukuran for auto-fill
        $lastPengukuran = Pengukuran::where('id_balita', $id)
            ->latest()
            ->first();
        
        return response()->json([
            'nama_balita' => $balita->nama_balita,
            'jenis_kelamin' => $balita->jenis_kelamin,
            'usia_bulan' => $usiaBulan,
            'tanggal_lahir' => $balita->tanggal_lahir,
            // Data dari pengukuran terakhir (jika ada)
            'berat_badan' => $lastPengukuran->berat_badan ?? null,
            'tinggi_badan' => $lastPengukuran->tinggi_badan ?? null,
            'lingkar_kepala' => $lastPengukuran->lingkar_kepala ?? null,
            'lila' => $lastPengukuran->lila ?? null,
        ]);
    }

    /**
     * Proses prediksi dan simpan ke database
     */
    public function calculate(Request $request)
    {
        $data = $request->validate([
            'id_balita' => 'nullable|exists:balita,id_balita',
            'nama_balita' => 'nullable|string|max:255',
            'usia_bulan' => 'required|integer|min:12|max:60',
            'jenis_kelamin' => 'required|in:L,P',
            'berat_badan' => 'required|numeric|min:0|max:50',
            'tinggi_badan' => 'required|numeric|min:30|max:150',
            'lingkar_kepala' => 'required|numeric|min:20|max:60',
            'lila' => 'required|numeric|min:5|max:30',
        ]);

        // Calculate BMI
        $tb_m = $data['tinggi_badan'] / 100;
        $bmi = $data['berat_badan'] / ($tb_m * $tb_m);
        
        // Try to call ML API first
        $status_gizi = $this->predictWithML($data);
        
        // If ML API fails, fallback to rule-based logic
        if ($status_gizi === null) {
            $status_gizi = $this->determineStatusGizi(
                $data['usia_bulan'],
                $data['jenis_kelamin'],
                $data['berat_badan'],
                $data['tinggi_badan'],
                $bmi
            );
        }

        $recommendations = $this->getRecommendations($status_gizi);

        // Save to database if balita is selected
        $pengukuranId = null;
        if (!empty($data['id_balita'])) {
            $pengukuran = Pengukuran::create([
                'id_balita' => $data['id_balita'],
                'usia_bulan' => $data['usia_bulan'],
                'berat_badan' => $data['berat_badan'],
                'tinggi_badan' => $data['tinggi_badan'],
                'lingkar_kepala' => $data['lingkar_kepala'],
                'lila' => $data['lila'],
                'status_gizi_ml' => $status_gizi,
                'bmi' => round($bmi, 2),
                'rekomendasi' => implode("\n", $recommendations),
                'tanggal_pengukuran' => now()->toDateString(),
            ]);
            $pengukuranId = $pengukuran->id_pengukuran;
        }
        
        return response()->json([
            'success' => true,
            'data' => $data,
            'bmi' => round($bmi, 2),
            'status_gizi' => $status_gizi,
            'recommendations' => $recommendations,
            'pengukuran_id' => $pengukuranId,
            'saved' => !empty($data['id_balita'])
        ]);
    }

    /**
     * Predict using ML API (Python Flask)
     */
    private function predictWithML($data)
    {
        try {
            $response = Http::timeout(5)->post($this->mlApiUrl . '/predict', [
                'usia_bulan' => $data['usia_bulan'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'berat_badan' => $data['berat_badan'],
                'tinggi_badan' => $data['tinggi_badan'],
                'lingkar_kepala' => $data['lingkar_kepala'],
                'lila' => $data['lila'],
            ]);
            
            if ($response->successful()) {
                $result = $response->json();
                if ($result['success'] ?? false) {
                    return $result['status_gizi'];
                }
            }
            
            Log::warning('ML API returned unsuccessful response', ['response' => $response->body()]);
            return null;
            
        } catch (\Exception $e) {
            Log::warning('ML API call failed, using fallback', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Fallback: Rule-based status determination
     */
    private function determineStatusGizi($usia, $jk, $bb, $tb, $bmi)
    {
        // Simplified logic - fallback when ML API is unavailable
        if ($usia < 6) {
            if ($bb < 5) return 'Gizi Buruk';
            if ($bb < 6) return 'Gizi Buruk';
            return 'Gizi Normal';
        } elseif ($usia < 12) {
            if ($bb < 6.5) return 'Gizi Buruk';
            if ($bb < 7.5) return 'Gizi Buruk';
            return 'Gizi Normal';
        } elseif ($usia < 24) {
            if ($bb < 8) return 'Gizi Buruk';
            if ($bb < 9) return 'Gizi Buruk';
            return 'Gizi Normal';
        } else {
            if ($bmi < 14) return 'Gizi Buruk';
            if ($bmi < 15) return 'Gizi Buruk';
            return 'Gizi Normal';
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
