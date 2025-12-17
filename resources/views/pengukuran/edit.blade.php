@extends('layouts.sidebar')

@section('title', 'Edit Pengukuran')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Edit Pengukuran</h1>
        <p class="text-gray-500 text-sm">Perbarui data pengukuran balita</p>
    </div>

    @if(session('success'))
        <div class="p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('pengukuran.update', $pengukuran->id_pengukuran) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Pilih Balita -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Pilih Balita *</label>
                    <select name="id_balita" id="id_balita" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm" required>
                        <option value="">-- Pilih balita --</option>
                        @foreach($balitas as $balita)
                            <option value="{{ $balita->id_balita }}" {{ $balita->id_balita == $pengukuran->id_balita ? 'selected' : '' }}>
                                {{ $balita->nama_balita }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal Pengukuran -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Tanggal Pengukuran *</label>
                    <input type="date" name="tanggal_pengukuran" id="tanggal_pengukuran" value="{{ $pengukuran->tanggal_pengukuran }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm" required>
                </div>

                <!-- Jenis Kelamin (readonly) -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Jenis Kelamin</label>
                    <input type="text" id="jenis_kelamin" class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-sm" readonly>
                </div>

                <!-- Usia (readonly) -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Usia (bulan)</label>
                    <input type="number" id="usia" name="usia_bulan" value="{{ $pengukuran->usia_bulan }}" class="w-full px-3 py-2 border rounded-lg bg-gray-50 text-sm" readonly min="12">
                    <p class="text-xs text-gray-400 mt-1">Min: 12 bulan (1 tahun)</p>
                </div>

                <!-- Berat Badan -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Berat Badan (kg) *</label>
                    <input type="number" step="0.1" name="berat_badan" id="berat_badan" value="{{ $pengukuran->berat_badan }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm" min="1" max="50" required onkeydown="return event.key !== '-' && event.key !== 'e'">
                </div>

                <!-- Tinggi Badan -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Tinggi Badan (cm) *</label>
                    <input type="number" step="0.1" name="tinggi_badan" id="tinggi_badan" value="{{ $pengukuran->tinggi_badan }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm" min="30" max="150" required onkeydown="return event.key !== '-' && event.key !== 'e'">
                </div>

                <!-- Lingkar Kepala -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Lingkar Kepala (cm) *</label>
                    <input type="number" step="0.1" name="lingkar_kepala" id="lingkar_kepala" value="{{ $pengukuran->lingkar_kepala }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm" min="20" max="60" required onkeydown="return event.key !== '-' && event.key !== 'e'">
                </div>

                <!-- LILA -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">LILA (cm) *</label>
                    <input type="number" step="0.1" name="lila" id="lila" value="{{ $pengukuran->lila }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm" min="5" max="30" required onkeydown="return event.key !== '-' && event.key !== 'e'">
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between mt-6">
                <a href="{{ route('pengukuran.index') }}" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 text-sm">
                    ← Kembali
                </a>
                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 text-sm">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('id_balita').addEventListener('change', function() {
        let balitaId = this.value;
        if (balitaId) {
            fetch(`/api/balita/${balitaId}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('jenis_kelamin').value = data.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
                    document.getElementById('usia').value = Math.max(12, Math.floor(data.usia_bulan));
                });
        }
    });

    // Trigger on page load
    if(document.getElementById('id_balita').value) {
        document.getElementById('id_balita').dispatchEvent(new Event('change'));
    }
</script>
@endsection
