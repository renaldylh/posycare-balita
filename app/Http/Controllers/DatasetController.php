<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengukuran;
use App\Models\Balita;

class DatasetController extends Controller
{
    public function index()
    {
        return view('dataset.index');
    }

    public function export()
    {
        $pengukurans = Pengukuran::with('balita')
            ->whereNotNull('status_gizi_ml')
            ->get();

        $filename = 'dataset_posycare_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($pengukurans) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, [
                'nama_balita',
                'jenis_kelamin',
                'usia_bulan',
                'berat_badan',
                'tinggi_badan',
                'lingkar_kepala',
                'lila',
                'bmi',
                'status_gizi'
            ]);
            
            // Data rows
            foreach ($pengukurans as $p) {
                fputcsv($file, [
                    $p->balita->nama_balita ?? 'N/A',
                    $p->balita->jenis_kelamin ?? '-',
                    $p->usia_bulan,
                    $p->berat_badan,
                    $p->tinggi_badan,
                    $p->lingkar_kepala,
                    $p->lila,
                    $p->bmi,
                    $p->status_gizi_ml
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
