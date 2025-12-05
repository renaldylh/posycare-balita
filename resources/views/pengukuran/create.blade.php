@extends('layouts.sidebar')

@section('content')
<div class="bg-white shadow-lg rounded-xl p-6 border border-purple-100">
    <div class="flex items-center mb-6">
        <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        <h2 class="text-2xl font-bold text-purple-800">Form Tambah Ukur Balita Baru</h2>
    </div>

    <form action="{{ route('pengukuran.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Pilih Balita --}}
            <div>
                <label for="id_balita" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Balita</label>
                <select name="id_balita" id="id_balita" class="w-full px-4 py-2.5 border border-purple-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                    <option value="">-- Pilih balita yang akan diukur --</option>
                    @foreach($balitas as $balita)
                        <option value="{{ $balita->id_balita }}">{{ $balita->nama_balita }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tanggal Pengukuran --}}
            <div>
                <label for="tanggal_pengukuran" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Pengukuran</label>
                <input type="date" name="tanggal_pengukuran" id="tanggal_pengukuran" class="w-full px-4 py-2.5 border border-purple-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
            </div>

            {{-- Jenis Kelamin (readonly) --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kelamin</label>
                <input type="text" id="jenis_kelamin" class="w-full px-4 py-2.5 border border-purple-200 rounded-lg bg-purple-50" readonly>
            </div>

            {{-- Usia (readonly, otomatis hitung dari tgl lahir) --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Usia</label>
                <input type="text" id="usia" name="usia_bulan" class="w-full px-4 py-2.5 border border-purple-200 rounded-lg bg-purple-50" readonly>
                <small class="text-gray-500">Dalam bulan</small>
            </div>

            {{-- Berat Badan --}}
            <div>
                <label for="berat_badan" class="block text-sm font-semibold text-gray-700 mb-2">Berat Badan</label>
                <div class="relative">
                    <input type="number" step="0.1" name="berat_badan" id="berat_badan" class="w-full px-4 py-2.5 pr-12 border border-purple-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="0.0">
                    <span class="absolute right-3 top-2.5 text-gray-500">kg</span>
                </div>
            </div>

            {{-- Tinggi Badan --}}
            <div>
                <label for="tinggi_badan" class="block text-sm font-semibold text-gray-700 mb-2">Tinggi Badan</label>
                <div class="relative">
                    <input type="number" step="0.1" name="tinggi_badan" id="tinggi_badan" class="w-full px-4 py-2.5 pr-12 border border-purple-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="0.0">
                    <span class="absolute right-3 top-2.5 text-gray-500">cm</span>
                </div>
            </div>

            {{-- Lingkar Kepala --}}
            <div>
                <label for="lingkar_kepala" class="block text-sm font-semibold text-gray-700 mb-2">Lingkar Kepala</label>
                <div class="relative">
                    <input type="number" step="0.1" name="lingkar_kepala" id="lingkar_kepala" class="w-full px-4 py-2.5 pr-12 border border-purple-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="0.0">
                    <span class="absolute right-3 top-2.5 text-gray-500">cm</span>
                </div>
            </div>

            {{-- LiLA --}}
            <div>
                <label for="lila" class="block text-sm font-semibold text-gray-700 mb-2">Lingkar Lengan Atas (LiLA)</label>
                <div class="relative">
                    <input type="number" step="0.1" name="lila" id="lila" class="w-full px-4 py-2.5 pr-12 border border-purple-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="0.0">
                    <span class="absolute right-3 top-2.5 text-gray-500">cm</span>
                </div>
            </div>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-between mt-8">
            <a href="{{ route('pengukuran.index') }}" 
               class="bg-gray-500 text-white px-6 py-2.5 rounded-lg hover:bg-gray-600 transition-colors duration-200 inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
            <button type="submit" 
                    class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-2.5 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all duration-200 inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Simpan Data
            </button>
        </div>
    </form>
</div>

{{-- Script untuk autofill jenis kelamin & usia --}}
<script>
    document.getElementById('id_balita').addEventListener('change', function() {
        let balitaId = this.value;
        if (balitaId) {
            fetch(`/api/balita/${balitaId}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('jenis_kelamin').value = data.jenis_kelamin;
                    document.getElementById('usia').value = data.usia_bulan;
                });
        }
    });
</script>
@endsection
