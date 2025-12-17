@extends('layouts.sidebar')

@section('title', 'Dataset ML')

@section('content')
@php
    $pengukurans = App\Models\Pengukuran::with('balita')->whereNotNull('status_gizi_ml')->latest()->paginate(20);
    $totalData = App\Models\Pengukuran::whereNotNull('status_gizi_ml')->count();
    $giziNormal = App\Models\Pengukuran::where('status_gizi_ml', 'Gizi Normal')->count();
    $giziBuruk = App\Models\Pengukuran::where('status_gizi_ml', 'Gizi Buruk')->count();
@endphp

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dataset ML</h1>
            <p class="text-gray-500 text-sm">Data training untuk model Machine Learning</p>
        </div>
        <a href="{{ route('dataset.export') }}" class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-4 py-2 rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all text-sm">
            Export CSV
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-purple-500">
            <p class="text-sm text-gray-500">Total Data</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalData }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-green-500">
            <p class="text-sm text-gray-500">Gizi Normal</p>
            <p class="text-3xl font-bold text-green-600">{{ $giziNormal }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-red-500">
            <p class="text-sm text-gray-500">Gizi Buruk</p>
            <p class="text-3xl font-bold text-red-600">{{ $giziBuruk }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-blue-500">
            <p class="text-sm text-gray-500">Balance Ratio</p>
            <p class="text-3xl font-bold text-blue-600">{{ $giziBuruk > 0 ? round($giziNormal / $giziBuruk, 2) . ':1' : '-' }}</p>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
                <tr>
                    <th class="px-3 py-3 text-left font-medium">#</th>
                    <th class="px-3 py-3 text-left font-medium">Nama</th>
                    <th class="px-3 py-3 text-left font-medium">JK</th>
                    <th class="px-3 py-3 text-left font-medium">Usia</th>
                    <th class="px-3 py-3 text-left font-medium">BB</th>
                    <th class="px-3 py-3 text-left font-medium">TB</th>
                    <th class="px-3 py-3 text-left font-medium">LK</th>
                    <th class="px-3 py-3 text-left font-medium">LILA</th>
                    <th class="px-3 py-3 text-left font-medium">BMI</th>
                    <th class="px-3 py-3 text-left font-medium">Label</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pengukurans as $index => $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-2 text-gray-600">{{ $pengukurans->firstItem() + $index }}</td>
                    <td class="px-3 py-2 font-medium text-gray-800">{{ $p->balita->nama_balita ?? '-' }}</td>
                    <td class="px-3 py-2">
                        <span class="px-2 py-0.5 rounded text-xs {{ $p->balita->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                            {{ $p->balita->jenis_kelamin ?? '-' }}
                        </span>
                    </td>
                    <td class="px-3 py-2 text-gray-600">{{ $p->usia_bulan }}</td>
                    <td class="px-3 py-2 text-gray-600">{{ $p->berat_badan }}</td>
                    <td class="px-3 py-2 text-gray-600">{{ $p->tinggi_badan }}</td>
                    <td class="px-3 py-2 text-gray-600">{{ $p->lingkar_kepala }}</td>
                    <td class="px-3 py-2 text-gray-600">{{ $p->lila }}</td>
                    <td class="px-3 py-2 text-gray-600">{{ $p->bmi ?? '-' }}</td>
                    <td class="px-3 py-2">
                        <span class="px-2 py-0.5 rounded-full text-xs {{ $p->status_gizi_ml === 'Gizi Normal' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $p->status_gizi_ml === 'Gizi Normal' ? 'Normal' : 'Buruk' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="10" class="px-4 py-8 text-center text-gray-400">Belum ada data. Lakukan prediksi untuk menambah data.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($pengukurans->hasPages())
        <div class="px-4 py-3 border-t">{{ $pengukurans->links() }}</div>
        @endif
    </div>
</div>
@endsection
