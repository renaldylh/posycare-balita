<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Bulanan Posyandu - {{ $namaBulan[(int)$bulan] ?? '' }} {{ $tahun }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
@php
    $namaBulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
@endphp
<body class="bg-white p-8">
    <!-- Print Button -->
    <div class="no-print mb-6 flex gap-4">
        <button onclick="window.print()" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">
            🖨️ Cetak Laporan
        </button>
        <a href="{{ route('laporan.index', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
            ← Kembali
        </a>
    </div>

    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">LAPORAN BULANAN POSYANDU</h1>
        <h2 class="text-xl font-semibold text-purple-600">POSYCARE - Sistem Prediksi Status Gizi Balita</h2>
        <p class="text-gray-600 mt-2">Periode: {{ $namaBulan[(int)$bulan] }} {{ $tahun }}</p>
        <p class="text-sm text-gray-500">Dicetak: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <!-- Summary Stats -->
    <div class="mb-8">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b-2 border-purple-500 pb-2">RINGKASAN STATISTIK</h3>
        <div class="grid grid-cols-3 gap-4">
            <div class="border rounded-lg p-4 text-center">
                <p class="text-3xl font-bold text-purple-600">{{ $stats['total_balita'] }}</p>
                <p class="text-sm text-gray-600">Total Balita Terdaftar</p>
            </div>
            <div class="border rounded-lg p-4 text-center">
                <p class="text-3xl font-bold text-blue-600">{{ $stats['balita_baru'] }}</p>
                <p class="text-sm text-gray-600">Balita Baru Bulan Ini</p>
            </div>
            <div class="border rounded-lg p-4 text-center">
                <p class="text-3xl font-bold text-indigo-600">{{ $stats['prediksi_bulan'] }}</p>
                <p class="text-sm text-gray-600">Total Prediksi Bulan Ini</p>
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-4 mt-4">
            <div class="border rounded-lg p-4 bg-green-50">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['gizi_normal'] }}</p>
                        <p class="text-sm text-gray-600">Balita Gizi Normal</p>
                    </div>
                    <div class="text-green-600 text-4xl">✓</div>
                </div>
            </div>
            <div class="border rounded-lg p-4 bg-red-50">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-2xl font-bold text-red-600">{{ $stats['gizi_buruk'] }}</p>
                        <p class="text-sm text-gray-600">Balita Gizi Buruk</p>
                    </div>
                    <div class="text-red-600 text-4xl">⚠</div>
                </div>
            </div>
        </div>
    </div>

    @if($balitaBerisiko->count() > 0)
    <!-- At Risk Section -->
    <div class="mb-8">
        <h3 class="text-lg font-bold text-red-700 mb-4 border-b-2 border-red-500 pb-2">⚠️ BALITA DENGAN GIZI BURUK (PERLU PERHATIAN KHUSUS)</h3>
        <table class="min-w-full border">
            <thead class="bg-red-100">
                <tr>
                    <th class="border px-3 py-2 text-left">No</th>
                    <th class="border px-3 py-2 text-left">Nama Balita</th>
                    <th class="border px-3 py-2 text-left">Usia</th>
                    <th class="border px-3 py-2 text-left">Berat Badan</th>
                    <th class="border px-3 py-2 text-left">Tinggi Badan</th>
                    <th class="border px-3 py-2 text-left">BMI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($balitaBerisiko as $idx => $b)
                <tr class="hover:bg-red-50">
                    <td class="border px-3 py-2">{{ $idx + 1 }}</td>
                    <td class="border px-3 py-2 font-medium">{{ $b->balita->nama_balita ?? 'N/A' }}</td>
                    <td class="border px-3 py-2">{{ $b->usia_bulan }} bulan</td>
                    <td class="border px-3 py-2">{{ $b->berat_badan }} kg</td>
                    <td class="border px-3 py-2">{{ $b->tinggi_badan }} cm</td>
                    <td class="border px-3 py-2">{{ $b->bmi }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Full Data -->
    <div class="mb-8">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b-2 border-purple-500 pb-2">DATA PREDIKSI LENGKAP</h3>
        <table class="min-w-full border text-sm">
            <thead class="bg-purple-100">
                <tr>
                    <th class="border px-2 py-2 text-left">No</th>
                    <th class="border px-2 py-2 text-left">Nama</th>
                    <th class="border px-2 py-2 text-left">JK</th>
                    <th class="border px-2 py-2 text-left">Usia</th>
                    <th class="border px-2 py-2 text-left">BB</th>
                    <th class="border px-2 py-2 text-left">TB</th>
                    <th class="border px-2 py-2 text-left">BMI</th>
                    <th class="border px-2 py-2 text-left">Status Gizi</th>
                    <th class="border px-2 py-2 text-left">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prediksiList as $idx => $p)
                <tr class="{{ $p->status_gizi_ml === 'Gizi Buruk' ? 'bg-red-50' : '' }}">
                    <td class="border px-2 py-1">{{ $idx + 1 }}</td>
                    <td class="border px-2 py-1">{{ $p->balita->nama_balita ?? 'N/A' }}</td>
                    <td class="border px-2 py-1">{{ $p->balita->jenis_kelamin ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $p->usia_bulan }} bln</td>
                    <td class="border px-2 py-1">{{ $p->berat_badan }} kg</td>
                    <td class="border px-2 py-1">{{ $p->tinggi_badan }} cm</td>
                    <td class="border px-2 py-1">{{ $p->bmi }}</td>
                    <td class="border px-2 py-1">
                        <span class="px-2 py-0.5 rounded text-xs {{ $p->status_gizi_ml === 'Gizi Normal' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                            {{ $p->status_gizi_ml }}
                        </span>
                    </td>
                    <td class="border px-2 py-1">{{ $p->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="border px-4 py-4 text-center text-gray-500">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="mt-12 pt-8 border-t">
        <div class="flex justify-between">
            <div class="text-center">
                <p class="text-sm text-gray-600">Mengetahui,</p>
                <p class="text-sm text-gray-600 mt-16">________________________</p>
                <p class="text-sm font-medium">Kepala Posyandu</p>
            </div>
            <div class="text-center">
                <p class="text-sm text-gray-600">Dibuat oleh,</p>
                <p class="text-sm text-gray-600 mt-16">________________________</p>
                <p class="text-sm font-medium">Kader Posyandu</p>
            </div>
        </div>
    </div>

    <script>
        // Auto print when page loads
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
