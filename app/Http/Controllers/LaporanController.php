<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengukuran;
use App\Models\Balita;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

        $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();

        $stats = [
            'total_balita' => Balita::count(),
            'balita_baru' => Balita::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_pengukuran' => Pengukuran::whereBetween('created_at', [$startDate, $endDate])->count(),
            'prediksi_bulan' => Pengukuran::whereBetween('created_at', [$startDate, $endDate])
                ->whereNotNull('status_gizi_ml')->count(),
            'gizi_normal' => Pengukuran::whereBetween('created_at', [$startDate, $endDate])
                ->where('status_gizi_ml', 'Gizi Normal')->count(),
            'gizi_buruk' => Pengukuran::whereBetween('created_at', [$startDate, $endDate])
                ->where('status_gizi_ml', 'Gizi Buruk')->count(),
        ];

        $balitaBerisiko = Pengukuran::with('balita')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status_gizi_ml', 'Gizi Buruk')
            ->get();

        $prediksiList = Pengukuran::with('balita')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('status_gizi_ml')
            ->latest()
            ->get();

        return view('laporan.index', compact('stats', 'balitaBerisiko', 'prediksiList', 'bulan', 'tahun'));
    }

    public function print(Request $request)
    {
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

        $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();

        $stats = $this->getStats($startDate, $endDate);
        $balitaBerisiko = $this->getBalitaBerisiko($startDate, $endDate);
        $prediksiList = $this->getPrediksiList($startDate, $endDate);

        return view('laporan.print', compact('stats', 'balitaBerisiko', 'prediksiList', 'bulan', 'tahun'));
    }

    public function export(Request $request)
    {
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        $format = $request->get('format', 'excel');

        $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();

        $prediksiList = Pengukuran::with('balita')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('status_gizi_ml')
            ->latest()
            ->get();

        $namaBulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        if ($format === 'pdf') {
            return $this->exportPDF($prediksiList, $bulan, $tahun, $namaBulan);
        } else {
            return $this->exportExcel($prediksiList, $bulan, $tahun, $namaBulan);
        }
    }

    private function exportPDF($data, $bulan, $tahun, $namaBulan)
    {
        // Generate HTML for PDF
        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8">
        <title>Laporan Posyandu</title>
        <style>
            body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
            h1 { text-align: center; font-size: 18px; margin-bottom: 5px; }
            h2 { text-align: center; font-size: 14px; color: #666; margin-bottom: 20px; }
            table { width: 100%; border-collapse: collapse; margin-top: 15px; }
            th, td { border: 1px solid #333; padding: 6px 8px; text-align: left; }
            th { background: #f0f0f0; font-weight: bold; }
            .normal { background: #d4edda; }
            .buruk { background: #f8d7da; }
            .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #666; }
        </style></head><body>';
        
        $html .= '<h1>LAPORAN BULANAN POSYANDU</h1>';
        $html .= '<h2>Periode: ' . $namaBulan[(int)$bulan] . ' ' . $tahun . '</h2>';
        
        $html .= '<table><thead><tr>
            <th>No</th><th>Nama Balita</th><th>JK</th><th>Usia</th>
            <th>BB (kg)</th><th>TB (cm)</th><th>BMI</th><th>Status Gizi</th><th>Tanggal</th>
        </tr></thead><tbody>';
        
        foreach ($data as $idx => $p) {
            $class = $p->status_gizi_ml === 'Gizi Normal' ? 'normal' : 'buruk';
            $html .= '<tr class="' . $class . '">';
            $html .= '<td>' . ($idx + 1) . '</td>';
            $html .= '<td>' . ($p->balita->nama_balita ?? '-') . '</td>';
            $html .= '<td>' . ($p->balita->jenis_kelamin ?? '-') . '</td>';
            $html .= '<td>' . $p->usia_bulan . ' bln</td>';
            $html .= '<td>' . $p->berat_badan . '</td>';
            $html .= '<td>' . $p->tinggi_badan . '</td>';
            $html .= '<td>' . $p->bmi . '</td>';
            $html .= '<td>' . $p->status_gizi_ml . '</td>';
            $html .= '<td>' . $p->created_at->format('d/m/Y') . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table>';
        $html .= '<div class="footer">Dicetak pada: ' . now()->format('d/m/Y H:i') . ' | POSYCARE</div>';
        $html .= '</body></html>';

        $filename = 'laporan_posyandu_' . $bulan . '_' . $tahun . '.html';
        
        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    private function exportExcel($data, $bulan, $tahun, $namaBulan)
    {
        $filename = 'laporan_posyandu_' . $bulan . '_' . $tahun . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($data, $bulan, $tahun, $namaBulan) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for Excel UTF-8 compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Title rows
            fputcsv($file, ['LAPORAN BULANAN POSYANDU']);
            fputcsv($file, ['Periode: ' . $namaBulan[(int)$bulan] . ' ' . $tahun]);
            fputcsv($file, []);
            
            // Header
            fputcsv($file, ['No', 'Nama Balita', 'JK', 'Usia (bulan)', 'BB (kg)', 'TB (cm)', 'BMI', 'Status Gizi', 'Tanggal']);
            
            // Data
            foreach ($data as $idx => $p) {
                fputcsv($file, [
                    $idx + 1,
                    $p->balita->nama_balita ?? '-',
                    $p->balita->jenis_kelamin ?? '-',
                    $p->usia_bulan,
                    $p->berat_badan,
                    $p->tinggi_badan,
                    $p->bmi,
                    $p->status_gizi_ml,
                    $p->created_at->format('d/m/Y')
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getStats($startDate, $endDate)
    {
        return [
            'total_balita' => Balita::count(),
            'balita_baru' => Balita::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_pengukuran' => Pengukuran::whereBetween('created_at', [$startDate, $endDate])->count(),
            'prediksi_bulan' => Pengukuran::whereBetween('created_at', [$startDate, $endDate])
                ->whereNotNull('status_gizi_ml')->count(),
            'gizi_normal' => Pengukuran::whereBetween('created_at', [$startDate, $endDate])
                ->where('status_gizi_ml', 'Gizi Normal')->count(),
            'gizi_buruk' => Pengukuran::whereBetween('created_at', [$startDate, $endDate])
                ->where('status_gizi_ml', 'Gizi Buruk')->count(),
        ];
    }

    private function getBalitaBerisiko($startDate, $endDate)
    {
        return Pengukuran::with('balita')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status_gizi_ml', 'Gizi Buruk')
            ->get();
    }

    private function getPrediksiList($startDate, $endDate)
    {
        return Pengukuran::with('balita')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('status_gizi_ml')
            ->latest()
            ->get();
    }
}
