@extends('layouts.sidebar')

@section('title', 'Detail Prediksi')

@section('content')
<div class="space-y-6">
    <!-- Back Button & Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('prediksi.rekap') }}" 
               class="p-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-purple-800">Detail Hasil Prediksi</h2>
                <p class="text-gray-600 mt-1">{{ $prediksi->balita->nama_balita ?? 'N/A' }}</p>
            </div>
        </div>
        <div class="flex gap-2">
            <button onclick="window.print()" 
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-purple-100">
        <!-- Patient Info -->
        <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Data Balita
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div>
                    <span class="text-gray-500">Nama:</span>
                    <span class="font-medium ml-2">{{ $prediksi->balita->nama_balita ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Jenis Kelamin:</span>
                    <span class="font-medium ml-2">{{ $prediksi->balita->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Tanggal Lahir:</span>
                    <span class="font-medium ml-2">{{ $prediksi->balita->tanggal_lahir ? \Carbon\Carbon::parse($prediksi->balita->tanggal_lahir)->format('d M Y') : '-' }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Nama Ortu:</span>
                    <span class="font-medium ml-2">{{ $prediksi->balita->nama_ortu ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Measurement Info -->
        <div class="mb-6 p-4 bg-purple-50 rounded-lg border border-purple-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Data Pengukuran
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div>
                    <span class="text-gray-500">Tanggal:</span>
                    <span class="font-medium ml-2">{{ $prediksi->tanggal_pengukuran ? \Carbon\Carbon::parse($prediksi->tanggal_pengukuran)->format('d M Y') : '-' }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Usia:</span>
                    <span class="font-medium ml-2">{{ $prediksi->usia_bulan }} bulan</span>
                </div>
                <div>
                    <span class="text-gray-500">Berat Badan:</span>
                    <span class="font-medium ml-2">{{ $prediksi->berat_badan }} kg</span>
                </div>
                <div>
                    <span class="text-gray-500">Tinggi Badan:</span>
                    <span class="font-medium ml-2">{{ $prediksi->tinggi_badan }} cm</span>
                </div>
                <div>
                    <span class="text-gray-500">Lingkar Kepala:</span>
                    <span class="font-medium ml-2">{{ $prediksi->lingkar_kepala }} cm</span>
                </div>
                <div>
                    <span class="text-gray-500">LILA:</span>
                    <span class="font-medium ml-2">{{ $prediksi->lila }} cm</span>
                </div>
            </div>
        </div>

        <!-- Status Result -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Status Gizi -->
            <div class="text-center p-6 rounded-xl {{ $prediksi->status_gizi_ml === 'Gizi Normal' ? 'bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200' : 'bg-gradient-to-r from-red-50 to-orange-50 border border-red-200' }}">
                <div class="text-5xl mb-4">
                    @if($prediksi->status_gizi_ml === 'Gizi Normal')
                        <svg class="w-16 h-16 mx-auto text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @else
                        <svg class="w-16 h-16 mx-auto text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    @endif
                </div>
                <div class="text-3xl font-bold mb-2 {{ $prediksi->status_gizi_ml === 'Gizi Normal' ? 'text-green-600' : 'text-red-600' }}">
                    {{ $prediksi->status_gizi_ml }}
                </div>
                <div class="text-gray-600">Status Gizi</div>
            </div>

            <!-- BMI -->
            <div class="text-center p-6 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl border border-indigo-200">
                <div class="text-5xl mb-4 text-indigo-600">
                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="text-3xl font-bold text-indigo-600 mb-2">{{ $prediksi->bmi ?? '-' }}</div>
                <div class="text-gray-600">Indeks Massa Tubuh (BMI)</div>
            </div>
        </div>

        <!-- Recommendations -->
        @if($prediksi->rekomendasi)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                Rekomendasi
            </h3>
            <ul class="space-y-2 text-gray-700">
                @foreach(explode("\n", $prediksi->rekomendasi) as $index => $rec)
                    @if(trim($rec))
                    <li class="flex items-start">
                        <span class="bg-yellow-400 text-yellow-800 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 flex-shrink-0">{{ $index + 1 }}</span>
                        <span>{{ $rec }}</span>
                    </li>
                    @endif
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Disclaimer -->
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg text-sm">
            <p class="text-blue-800">
                <strong>Catatan:</strong> Hasil prediksi ini dihasilkan menggunakan model Machine Learning berdasarkan data training posyandu. 
                Untuk diagnosis yang akurat, silakan konsultasikan dengan tenaga kesehatan profesional.
            </p>
        </div>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    .bg-white.rounded-xl.shadow-lg, .bg-white.rounded-xl.shadow-lg * {
        visibility: visible;
    }
    .bg-white.rounded-xl.shadow-lg {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
}
</style>
@endsection
