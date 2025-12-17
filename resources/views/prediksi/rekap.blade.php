@extends('layouts.sidebar')

@section('title', 'Rekap Prediksi')

@section('content')
@php
    $query = App\Models\Pengukuran::with('balita')->whereNotNull('status_gizi_ml');
    
    if(request('search')) {
        $query->whereHas('balita', function($q) {
            $q->where('nama_balita', 'like', '%'.request('search').'%');
        });
    }
    if(request('status')) {
        if(request('status') == 'normal') {
            $query->where('status_gizi_ml', 'Gizi Normal');
        } elseif(request('status') == 'buruk') {
            $query->where('status_gizi_ml', 'Gizi Buruk');
        }
    }
    if(request('dari')) {
        $query->whereDate('created_at', '>=', request('dari'));
    }
    if(request('sampai')) {
        $query->whereDate('created_at', '<=', request('sampai'));
    }
    
    $prediksiList = $query->latest()->paginate(15)->withQueryString();
    
    $totalPrediksi = App\Models\Pengukuran::whereNotNull('status_gizi_ml')->count();
    $giziNormal = App\Models\Pengukuran::where('status_gizi_ml', 'Gizi Normal')->count();
    $giziBuruk = App\Models\Pengukuran::where('status_gizi_ml', 'Gizi Buruk')->count();
@endphp

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Rekap Prediksi</h1>
            <p class="text-gray-500 text-sm">Riwayat hasil prediksi status gizi</p>
        </div>
        <a href="{{ route('dataset.export') }}" class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-4 py-2 rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all text-sm">
            Export CSV
        </a>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow p-4">
        <form action="{{ route('prediksi.rekap') }}" method="GET" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[180px]">
                <label class="block text-xs text-gray-500 mb-1">Cari Balita</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama balita..." class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm">
            </div>
            <div class="w-32">
                <label class="block text-xs text-gray-500 mb-1">Status Gizi</label>
                <select name="status" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm">
                    <option value="">Semua</option>
                    <option value="normal" {{ request('status') == 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="buruk" {{ request('status') == 'buruk' ? 'selected' : '' }}>Buruk</option>
                </select>
            </div>
            <div class="w-36">
                <label class="block text-xs text-gray-500 mb-1">Dari Tanggal</label>
                <input type="date" name="dari" value="{{ request('dari') }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm">
            </div>
            <div class="w-36">
                <label class="block text-xs text-gray-500 mb-1">Sampai</label>
                <input type="date" name="sampai" value="{{ request('sampai') }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm">
            </div>
            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm">Filter</button>
            @if(request()->hasAny(['search', 'status', 'dari', 'sampai']))
            <a href="{{ route('prediksi.rekap') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm">Reset</a>
            @endif
        </form>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-purple-500">
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
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-indigo-500">
            <p class="text-sm text-gray-500">Persentase Normal</p>
            <p class="text-3xl font-bold text-indigo-600">{{ $totalPrediksi > 0 ? round(($giziNormal / $totalPrediksi) * 100, 1) : 0 }}%</p>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
                <tr>
                    <th class="px-4 py-3 text-left font-medium">#</th>
                    <th class="px-4 py-3 text-left font-medium">Nama Balita</th>
                    <th class="px-4 py-3 text-left font-medium">Usia</th>
                    <th class="px-4 py-3 text-left font-medium">BB</th>
                    <th class="px-4 py-3 text-left font-medium">TB</th>
                    <th class="px-4 py-3 text-left font-medium">BMI</th>
                    <th class="px-4 py-3 text-left font-medium">Status Gizi</th>
                    <th class="px-4 py-3 text-left font-medium">Tanggal</th>
                    <th class="px-4 py-3 text-center font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($prediksiList as $index => $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-600">{{ $prediksiList->firstItem() + $index }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $p->balita->nama_balita ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ floor($p->usia_bulan) }} bln</td>
                    <td class="px-4 py-3 text-gray-600">{{ $p->berat_badan }} kg</td>
                    <td class="px-4 py-3 text-gray-600">{{ $p->tinggi_badan }} cm</td>
                    <td class="px-4 py-3 text-gray-600">{{ $p->bmi ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs {{ $p->status_gizi_ml === 'Gizi Normal' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $p->status_gizi_ml === 'Gizi Normal' ? 'Normal' : 'Buruk' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $p->created_at->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('prediksi.show', $p->id_pengukuran) }}" class="text-purple-600 hover:text-purple-800 text-xs">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="px-4 py-8 text-center text-gray-400">Belum ada data prediksi</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($prediksiList->hasPages())
        <div class="px-4 py-3 border-t">{{ $prediksiList->links() }}</div>
        @endif
    </div>
</div>
@endsection
