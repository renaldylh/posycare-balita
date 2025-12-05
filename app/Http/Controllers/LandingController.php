<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function predict()
    {
        return view('predict.index');
    }

    public function calculate(Request $request)
    {
        $data = $request->validate([
            'usia_bulan' => 'required|integer|min:0|max:60',
            'jenis_kelamin' => 'required|in:L,P',
            'berat_badan' => 'required|numeric|min:0|max:50',
            'tinggi_badan' => 'required|numeric|min:30|max:150',
            'lingkar_kepala' => 'required|numeric|min:20|max:60',
            'lila' => 'required|numeric|min:5|max:30',
        ]);

        // Simple calculation logic (can be enhanced with ML model)
        $usia = $data['usia_bulan'];
        $jk = $data['jenis_kelamin'];
        $bb = $data['berat_badan'];
        $tb = $data['tinggi_badan'];
        
        // Calculate BMI
        $tb_m = $tb / 100;
        $bmi = $bb / ($tb_m * $tb_m);
        
        // Simple status determination based on WHO standards
        $status_gizi = $this->determineStatusGizi($usia, $jk, $bb, $tb, $bmi);
        
        return response()->json([
            'success' => true,
            'data' => $data,
            'bmi' => round($bmi, 2),
            'status_gizi' => $status_gizi,
            'recommendations' => $this->getRecommendations($status_gizi)
        ]);
    }

    private function determineStatusGizi($usia, $jk, $bb, $tb, $bmi)
    {
        // Simplified logic - in real implementation, use WHO growth standards
        if ($usia < 6) {
            if ($bb < 5) return 'Sangat Kurus';
            if ($bb < 6) return 'Kurus';
            if ($bb > 9) return 'Gemuk';
            if ($bb > 10) return 'Sangat Gemuk';
            return 'Normal';
        } elseif ($usia < 12) {
            if ($bb < 6.5) return 'Sangat Kurus';
            if ($bb < 7.5) return 'Kurus';
            if ($bb > 11) return 'Gemuk';
            if ($bb > 12) return 'Sangat Gemuk';
            return 'Normal';
        } elseif ($usia < 24) {
            if ($bb < 8) return 'Sangat Kurus';
            if ($bb < 9) return 'Kurus';
            if ($bb > 13) return 'Gemuk';
            if ($bb > 14) return 'Sangat Gemuk';
            return 'Normal';
        } else {
            if ($bmi < 14) return 'Sangat Kurus';
            if ($bmi < 15) return 'Kurus';
            if ($bmi > 18) return 'Gemuk';
            if ($bmi > 19) return 'Sangat Gemuk';
            return 'Normal';
        }
    }

    private function getRecommendations($status)
    {
        $recommendations = [
            'Sangat Kurus' => [
                'Segera konsultasi ke fasilitas kesehatan terdekat',
                'Tingkatkan frekuensi makan (5-6 kali/hari)',
                'Berikan makanan bergizi tinggi protein',
                'Monitor pertumbuhan setiap minggu'
            ],
            'Kurus' => [
                'Tingkatkan asupan kalori dan protein',
                'Berikan makanan padat gizi',
                'Jadwalkan makan teratur (3 kali utama + 2 kali selingan)',
                'Monitor pertumbuhan setiap 2 minggu'
            ],
            'Normal' => [
                'Pertahankan pola makan sehat',
                'Lanjutkan ASI hingga 2 tahun',
                'Berikan makanan variatif',
                'Monitor pertumbuhan setiap bulan'
            ],
            'Gemuk' => [
                'Kontrol asupan kalori berlebih',
                'Tingkatkan aktivitas fisik',
                'Kurangi makanan tinggi gula dan lemak',
                'Monitor pertumbuhan setiap bulan'
            ],
            'Sangat Gemuk' => [
                'Konsultasi ke dokter atau ahli gizi',
                'Program penurunan berat badan terarah',
                'Tingkatkan aktivitas fisik harian',
                'Monitor kesehatan secara rutin'
            ]
        ];

        return $recommendations[$status] ?? $recommendations['Normal'];
    }
}
