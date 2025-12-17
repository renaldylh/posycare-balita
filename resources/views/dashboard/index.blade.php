@extends('layouts.sidebar')

@section('title', 'Dashboard')

@section('content')
@php
    $totalBalita = App\Models\Balita::count();
    $totalPrediksi = App\Models\Pengukuran::whereNotNull('status_gizi_ml')->count();
    $giziNormal = App\Models\Pengukuran::where('status_gizi_ml', 'Gizi Normal')->count();
    $giziBuruk = App\Models\Pengukuran::where('status_gizi_ml', 'Gizi Buruk')->count();
    
    $recentPrediksi = App\Models\Pengukuran::with('balita')
        ->whereNotNull('status_gizi_ml')
        ->latest()
        ->take(5)
        ->get();
        
    $balitaBerisiko = App\Models\Pengukuran::with('balita')
        ->where('status_gizi_ml', 'Gizi Buruk')
        ->latest()
        ->take(5)
        ->get();
@endphp

<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-500 text-sm">Sistem Prediksi Status Gizi Balita</p>
        </div>
        <div class="text-sm text-gray-500" id="tanggalWaktu"></div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-purple-500">
            <p class="text-sm text-gray-500">Total Balita</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalBalita }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-indigo-500">
            <p class="text-sm text-gray-500">Total Prediksi</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalPrediksi }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-green-500">
            <p class="text-sm text-gray-500">Gizi Normal</p>
            <p class="text-3xl font-bold text-green-600">{{ $giziNormal }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-red-500">
            <p class="text-sm text-gray-500">Gizi Buruk</p>
            <p class="text-3xl font-bold text-red-600">{{ $giziBuruk }}</p>
        </div>
    </div>

    <!-- Chart & Recent Table -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pie Chart -->
        <div class="bg-white rounded-xl shadow p-5">
            <h3 class="font-semibold text-gray-800 mb-4">Distribusi Status Gizi</h3>
            @if($totalPrediksi > 0)
            <div class="flex justify-center">
                <canvas id="giziChart" class="max-h-52"></canvas>
            </div>
            @else
            <div class="flex flex-col items-center justify-center h-40 text-gray-400">
                <p>Belum ada data prediksi</p>
            </div>
            @endif
        </div>

        <!-- Recent Predictions -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="p-4 border-b flex justify-between items-center">
                <h3 class="font-semibold text-gray-800">Prediksi Terbaru</h3>
                <a href="{{ route('prediksi.rekap') }}" class="text-purple-600 hover:text-purple-800 text-sm">Lihat Semua →</a>
            </div>
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Balita</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">BMI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentPrediksi as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium text-gray-800">{{ $p->balita->nama_balita ?? '-' }}</td>
                        <td class="px-4 py-2">
                            @if($p->status_gizi_ml === 'Gizi Normal')
                                <span class="px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-800">Normal</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-xs bg-red-100 text-red-800">Buruk</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-gray-600">{{ $p->bmi ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-4 py-6 text-center text-gray-400">Belum ada data prediksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- At Risk Balita -->
    @if($balitaBerisiko->count() > 0)
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="p-4 border-b bg-red-50 flex justify-between items-center">
            <h3 class="font-semibold text-red-800">Balita Berisiko (Gizi Buruk)</h3>
            <a href="{{ route('prediksi.rekap', ['status' => 'Gizi Buruk']) }}" class="text-red-600 hover:text-red-800 text-sm">Lihat Semua →</a>
        </div>
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Balita</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Usia</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">BB / TB</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">BMI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($balitaBerisiko as $b)
                <tr class="hover:bg-red-50">
                    <td class="px-4 py-2 font-medium text-gray-800">{{ $b->balita->nama_balita ?? '-' }}</td>
                    <td class="px-4 py-2 text-gray-600">{{ $b->usia_bulan }} bulan</td>
                    <td class="px-4 py-2 text-gray-600">{{ $b->berat_badan }} kg / {{ $b->tinggi_badan }} cm</td>
                    <td class="px-4 py-2 text-gray-600">{{ $b->bmi ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function updateWaktu(){
        const now = new Date();
        const options = { weekday:'long', year:'numeric', month:'long', day:'numeric' };
        document.getElementById('tanggalWaktu').textContent = now.toLocaleDateString('id-ID', options);
    }
    updateWaktu();

    @if($totalPrediksi > 0)
    new Chart(document.getElementById('giziChart'), {
        type: 'doughnut',
        data: {
            labels: ['Gizi Normal', 'Gizi Buruk'],
            datasets: [{
                data: [{{ $giziNormal }}, {{ $giziBuruk }}],
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
