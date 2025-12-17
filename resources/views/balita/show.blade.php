@extends('layouts.sidebar')

@section('title', 'Detail Balita - ' . $balita->nama_balita)

@section('content')
<div class="space-y-6">
    <!-- Back & Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('balita.index') }}" 
               class="p-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-purple-800">{{ $balita->nama_balita }}</h2>
                <p class="text-gray-600">Detail data balita dan riwayat prediksi</p>
            </div>
        </div>
        <a href="{{ route('prediksi.index', ['balita_id' => $balita->id_balita]) }}" 
           class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-5 py-2.5 rounded-xl shadow-lg hover:from-purple-700 hover:to-indigo-700 transition-all duration-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
            </svg>
            Prediksi Baru
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="text-center mb-6">
                <div class="w-24 h-24 mx-auto rounded-full bg-gradient-to-r {{ $balita->jenis_kelamin == 'L' ? 'from-blue-400 to-blue-600' : 'from-pink-400 to-pink-600' }} flex items-center justify-center mb-4">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">{{ $balita->nama_balita }}</h3>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mt-2 {{ $balita->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                    {{ $balita->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                </span>
            </div>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">Tanggal Lahir</span>
                    <span class="font-medium">{{ \Carbon\Carbon::parse($balita->tanggal_lahir)->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">Usia</span>
                    <span class="font-medium">{{ $usia }} bulan</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">Nama Orang Tua</span>
                    <span class="font-medium">{{ $balita->nama_ortu ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-500">Alamat</span>
                    <span class="font-medium text-right max-w-[150px]">{{ $balita->alamat ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Status Card -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Current Status -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Status Gizi Terkini</h4>
                @if($lastPrediksi)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center p-4 rounded-xl {{ $lastPrediksi->status_gizi_ml === 'Gizi Normal' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                        <div class="text-4xl mb-2">
                            @if($lastPrediksi->status_gizi_ml === 'Gizi Normal')
                                <svg class="w-12 h-12 mx-auto text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @else
                                <svg class="w-12 h-12 mx-auto text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            @endif
                        </div>
                        <p class="font-bold {{ $lastPrediksi->status_gizi_ml === 'Gizi Normal' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $lastPrediksi->status_gizi_ml }}
                        </p>
                    </div>
                    
                    <div class="text-center p-4 bg-indigo-50 rounded-xl border border-indigo-200">
                        <p class="text-3xl font-bold text-indigo-600">{{ $lastPrediksi->bmi ?? '-' }}</p>
                        <p class="text-sm text-gray-600">BMI</p>
                    </div>
                    
                    <div class="text-center p-4 bg-purple-50 rounded-xl border border-purple-200">
                        <p class="text-3xl font-bold text-purple-600">{{ $lastPrediksi->berat_badan ?? '-' }} kg</p>
                        <p class="text-sm text-gray-600">Berat Badan</p>
                    </div>
                </div>
                
                <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600">
                        <span class="font-medium">Pemeriksaan terakhir:</span> 
                        {{ $lastPrediksi->tanggal_pengukuran ? \Carbon\Carbon::parse($lastPrediksi->tanggal_pengukuran)->format('d M Y') : $lastPrediksi->created_at->format('d M Y') }}
                    </p>
                </div>
                @else
                <div class="text-center py-8 text-gray-400">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <p>Belum ada data prediksi untuk balita ini</p>
                    <a href="{{ route('prediksi.index', ['balita_id' => $balita->id_balita]) }}" 
                       class="inline-block mt-4 bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                        Lakukan Prediksi Sekarang
                    </a>
                </div>
                @endif
            </div>

            <!-- Rekomendasi -->
            @if($lastPrediksi && $lastPrediksi->rekomendasi)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg">
                <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                    Rekomendasi
                </h4>
                <ul class="space-y-2 text-sm text-gray-700">
                    @foreach(explode("\n", $lastPrediksi->rekomendasi) as $index => $rec)
                        @if(trim($rec))
                        <li class="flex items-start">
                            <span class="bg-yellow-400 text-yellow-800 rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold mr-2 flex-shrink-0">{{ $index + 1 }}</span>
                            <span>{{ $rec }}</span>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>

    <!-- History Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h4 class="text-lg font-semibold text-gray-800">Riwayat Pengukuran & Prediksi</h4>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usia</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">BB (kg)</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">TB (cm)</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">LK (cm)</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">LILA (cm)</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">BMI</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Gizi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pengukurans as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ $p->tanggal_pengukuran ? \Carbon\Carbon::parse($p->tanggal_pengukuran)->format('d M Y') : $p->created_at->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $p->usia_bulan }} bln</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $p->berat_badan }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $p->tinggi_badan }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $p->lingkar_kepala }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $p->lila }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $p->bmi ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @if($p->status_gizi_ml)
                                @if($p->status_gizi_ml === 'Gizi Normal')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Normal
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Buruk
                                    </span>
                                @endif
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">Belum ada riwayat pengukuran</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
