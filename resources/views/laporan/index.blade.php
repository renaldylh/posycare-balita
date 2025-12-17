@extends('layouts.sidebar')

@section('title', 'Laporan Bulanan')

@section('content')
@php
    $namaBulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
@endphp

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Laporan Bulanan</h1>
            <p class="text-gray-500 text-sm">Periode: {{ $namaBulan[(int)$bulan] }} {{ $tahun }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('laporan.export', ['bulan' => $bulan, 'tahun' => $tahun, 'format' => 'pdf']) }}" 
               class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-all text-sm">
                PDF
            </a>
            <a href="{{ route('laporan.export', ['bulan' => $bulan, 'tahun' => $tahun, 'format' => 'excel']) }}" 
               class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all text-sm">
                Excel
            </a>
            <a href="{{ route('laporan.print', ['bulan' => $bulan, 'tahun' => $tahun]) }}" target="_blank"
               class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-4 py-2 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all text-sm">
                Cetak
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow p-4">
        <form action="{{ route('laporan.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Bulan</label>
                <select name="bulan" class="px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ $bulan == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                            {{ $namaBulan[$i] }}
                        </option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Tahun</label>
                <select name="tahun" class="px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm">
                    @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-4 py-2 rounded-lg hover:from-purple-700 hover:to-indigo-700 text-sm">
                Tampilkan
            </button>
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="bg-white rounded-xl shadow p-4 border-l-4 border-purple-500">
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_balita'] }}</p>
            <p class="text-xs text-gray-500">Total Balita</p>
        </div>
        <div class="bg-white rounded-xl shadow p-4 border-l-4 border-blue-500">
            <p class="text-2xl font-bold text-blue-600">{{ $stats['balita_baru'] }}</p>
            <p class="text-xs text-gray-500">Balita Baru</p>
        </div>
        <div class="bg-white rounded-xl shadow p-4 border-l-4 border-indigo-500">
            <p class="text-2xl font-bold text-indigo-600">{{ $stats['total_pengukuran'] }}</p>
            <p class="text-xs text-gray-500">Pengukuran</p>
        </div>
        <div class="bg-white rounded-xl shadow p-4 border-l-4 border-cyan-500">
            <p class="text-2xl font-bold text-cyan-600">{{ $stats['prediksi_bulan'] }}</p>
            <p class="text-xs text-gray-500">Prediksi</p>
        </div>
        <div class="bg-white rounded-xl shadow p-4 border-l-4 border-green-500">
            <p class="text-2xl font-bold text-green-600">{{ $stats['gizi_normal'] }}</p>
            <p class="text-xs text-gray-500">Gizi Normal</p>
        </div>
        <div class="bg-white rounded-xl shadow p-4 border-l-4 border-red-500">
            <p class="text-2xl font-bold text-red-600">{{ $stats['gizi_buruk'] }}</p>
            <p class="text-xs text-gray-500">Gizi Buruk</p>
        </div>
    </div>

    <!-- Chart & At Risk -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pie Chart -->
        <div class="bg-white rounded-xl shadow p-5">
            <h3 class="font-semibold text-gray-800 mb-4">Distribusi Status Gizi</h3>
            @if($stats['prediksi_bulan'] > 0)
            <canvas id="giziChart" class="max-h-52"></canvas>
            @else
            <div class="flex items-center justify-center h-40 text-gray-400">Tidak ada data</div>
            @endif
        </div>

        <!-- At Risk List -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="p-4 border-b bg-red-50">
                <h3 class="font-semibold text-red-800">Balita Gizi Buruk ({{ $balitaBerisiko->count() }})</h3>
            </div>
            <div class="max-h-52 overflow-y-auto">
                @forelse($balitaBerisiko as $b)
                <div class="px-4 py-3 border-b flex justify-between items-center hover:bg-gray-50">
                    <div>
                        <p class="font-medium text-gray-800 text-sm">{{ $b->balita->nama_balita ?? '-' }}</p>
                        <p class="text-xs text-gray-500">BMI: {{ $b->bmi }} | BB: {{ $b->berat_badan }}kg</p>
                    </div>
                    <a href="{{ route('balita.show', $b->id_balita) }}" class="text-purple-600 hover:text-purple-800 text-xs">Detail</a>
                </div>
                @empty
                <div class="px-4 py-8 text-center text-gray-400 text-sm">Tidak ada balita gizi buruk</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="p-4 border-b">
            <h3 class="font-semibold text-gray-800">Data Prediksi {{ $namaBulan[(int)$bulan] }} {{ $tahun }}</h3>
        </div>
        <table class="min-w-full text-sm">
            <thead class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
                <tr>
                    <th class="px-4 py-3 text-left font-medium">#</th>
                    <th class="px-4 py-3 text-left font-medium">Nama</th>
                    <th class="px-4 py-3 text-left font-medium">Usia</th>
                    <th class="px-4 py-3 text-left font-medium">BB</th>
                    <th class="px-4 py-3 text-left font-medium">TB</th>
                    <th class="px-4 py-3 text-left font-medium">BMI</th>
                    <th class="px-4 py-3 text-left font-medium">Status</th>
                    <th class="px-4 py-3 text-left font-medium">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($prediksiList as $index => $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-600">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $p->balita->nama_balita ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $p->usia_bulan }} bln</td>
                    <td class="px-4 py-3 text-gray-600">{{ $p->berat_badan }} kg</td>
                    <td class="px-4 py-3 text-gray-600">{{ $p->tinggi_badan }} cm</td>
                    <td class="px-4 py-3 text-gray-600">{{ $p->bmi }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs {{ $p->status_gizi_ml === 'Gizi Normal' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $p->status_gizi_ml === 'Gizi Normal' ? 'Normal' : 'Buruk' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $p->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-4 py-8 text-center text-gray-400">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@if($stats['prediksi_bulan'] > 0)
new Chart(document.getElementById('giziChart'), {
    type: 'doughnut',
    data: {
        labels: ['Gizi Normal', 'Gizi Buruk'],
        datasets: [{
            data: [{{ $stats['gizi_normal'] }}, {{ $stats['gizi_buruk'] }}],
            backgroundColor: ['#10B981', '#EF4444'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } },
        cutout: '60%'
    }
});
@endif
</script>
@endsection
