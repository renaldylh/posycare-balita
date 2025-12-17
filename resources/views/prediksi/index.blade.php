@extends('layouts.sidebar')

@section('title', 'Prediksi Status Gizi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Prediksi Status Gizi</h1>
            <p class="text-gray-500 text-sm">Analisis status gizi balita menggunakan Machine Learning</p>
        </div>
        <a href="{{ route('prediksi.rekap') }}" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-4 py-2 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all text-sm">
            Lihat Rekap
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow p-6">
        <form id="predictForm" class="space-y-6">
            @csrf
            
            <!-- Pilih Balita -->
            <div class="bg-purple-50 rounded-lg p-4 border border-purple-100">
                <h3 class="font-semibold text-gray-800 mb-3">Pilih Balita</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Dari Database</label>
                        <select id="id_balita" name="id_balita" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm">
                            <option value="">-- Pilih atau Input Manual --</option>
                            @foreach($balitas as $balita)
                                <option value="{{ $balita->id_balita }}">{{ $balita->nama_balita }} ({{ $balita->jenis_kelamin }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Nama Manual</label>
                        <input type="text" id="nama_balita" name="nama_balita" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm" placeholder="Jika tidak ada di database">
                    </div>
                </div>
            </div>

            <!-- Data Pengukuran -->
            <div>
                <h3 class="font-semibold text-gray-800 mb-3">Data Pengukuran</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Usia (bulan) *</label>
                        <input type="number" id="usia_bulan" name="usia_bulan" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm" placeholder="12" min="12" max="60" required onkeydown="return event.key !== '-' && event.key !== 'e'">
                        <p class="text-xs text-gray-400 mt-1">Min: 12 bulan (1 tahun)</p>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Jenis Kelamin *</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm" required>
                            <option value="">Pilih</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Berat Badan (kg) *</label>
                        <input type="number" id="berat_badan" name="berat_badan" step="0.1" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm" placeholder="8.5" min="1" max="50" required onkeydown="return event.key !== '-' && event.key !== 'e'">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Tinggi Badan (cm) *</label>
                        <input type="number" id="tinggi_badan" name="tinggi_badan" step="0.1" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm" placeholder="72" min="30" max="150" required onkeydown="return event.key !== '-' && event.key !== 'e'">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Lingkar Kepala (cm) *</label>
                        <input type="number" id="lingkar_kepala" name="lingkar_kepala" step="0.1" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm" placeholder="44" min="20" max="60" required onkeydown="return event.key !== '-' && event.key !== 'e'">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">LILA (cm) *</label>
                        <input type="number" id="lila" name="lila" step="0.1" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm" placeholder="15" min="5" max="30" required onkeydown="return event.key !== '-' && event.key !== 'e'">
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-center">
                <button type="submit" class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-medium py-2.5 px-6 rounded-lg transition-all text-sm">
                    <span id="btnText">Analisis dengan ML</span>
                    <span class="hidden" id="btnLoading">Memproses...</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Results Section -->
    <div id="results" class="hidden space-y-6">
        <!-- Patient Info -->
        <div class="bg-white rounded-xl shadow p-5">
            <h3 class="font-semibold text-gray-800 mb-3">Data Balita</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div><span class="text-gray-500">Nama:</span> <span class="font-medium" id="resultNama">-</span></div>
                <div><span class="text-gray-500">Usia:</span> <span class="font-medium"><span id="resultUsia">-</span> bulan</span></div>
                <div><span class="text-gray-500">Jenis Kelamin:</span> <span class="font-medium" id="resultJK">-</span></div>
                <div><span class="text-gray-500">Tanggal:</span> <span class="font-medium" id="resultDate">-</span></div>
                <div><span class="text-gray-500">Berat Badan:</span> <span class="font-medium"><span id="resultBB">-</span> kg</span></div>
                <div><span class="text-gray-500">Tinggi Badan:</span> <span class="font-medium"><span id="resultTB">-</span> cm</span></div>
                <div><span class="text-gray-500">Lingkar Kepala:</span> <span class="font-medium"><span id="resultLK">-</span> cm</span></div>
                <div><span class="text-gray-500">LILA:</span> <span class="font-medium"><span id="resultLila">-</span> cm</span></div>
            </div>
        </div>

        <!-- Status Result -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white rounded-xl shadow p-5 text-center" id="statusCard">
                <div class="text-4xl mb-2" id="statusIcon"></div>
                <div class="text-2xl font-bold mb-1" id="statusGizi">-</div>
                <div class="text-gray-500 text-sm">Status Gizi</div>
            </div>
            <div class="bg-white rounded-xl shadow p-5 text-center border-l-4 border-indigo-500">
                <div class="text-4xl mb-2 text-indigo-600">📊</div>
                <div class="text-2xl font-bold text-indigo-600 mb-1" id="bmiValue">-</div>
                <div class="text-gray-500 text-sm">BMI</div>
            </div>
        </div>

        <!-- Saved Notification -->
        <div id="savedNotification" class="hidden p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">
            ✓ Data prediksi berhasil disimpan ke database!
        </div>

        <!-- Recommendations -->
        <div class="bg-white rounded-xl shadow p-5">
            <h3 class="font-semibold text-gray-800 mb-3">Rekomendasi</h3>
            <ul id="recommendations" class="space-y-2 text-sm text-gray-700"></ul>
        </div>

        <!-- Disclaimer -->
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg text-sm text-blue-800">
            <strong>Catatan:</strong> Hasil prediksi ini dihasilkan menggunakan model Machine Learning. Untuk diagnosis yang akurat, silakan konsultasikan dengan tenaga kesehatan profesional.
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap justify-center gap-3">
            <button onclick="printResult()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm">Cetak</button>
            <button onclick="resetForm()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm">Prediksi Ulang</button>
            <a href="{{ route('prediksi.rekap') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm">Lihat Rekap</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('id_balita').addEventListener('change', function() {
    const balitaId = this.value;
    if (balitaId) {
        fetch(`/prediksi/balita/${balitaId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('nama_balita').value = data.nama_balita;
                document.getElementById('usia_bulan').value = Math.floor(data.usia_bulan);
                document.getElementById('jenis_kelamin').value = data.jenis_kelamin;
                // Auto-fill data pengukuran terakhir jika ada
                if (data.berat_badan) document.getElementById('berat_badan').value = data.berat_badan;
                if (data.tinggi_badan) document.getElementById('tinggi_badan').value = data.tinggi_badan;
                if (data.lingkar_kepala) document.getElementById('lingkar_kepala').value = data.lingkar_kepala;
                if (data.lila) document.getElementById('lila').value = data.lila;
            })
            .catch(error => console.error('Error:', error));
    } else {
        document.getElementById('nama_balita').value = '';
        document.getElementById('usia_bulan').value = '';
        document.getElementById('jenis_kelamin').value = '';
        document.getElementById('berat_badan').value = '';
        document.getElementById('tinggi_badan').value = '';
        document.getElementById('lingkar_kepala').value = '';
        document.getElementById('lila').value = '';
    }
});

document.getElementById('predictForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const btn = e.target.querySelector('button[type="submit"]');
    const btnText = document.getElementById('btnText');
    const btnLoading = document.getElementById('btnLoading');
    const results = document.getElementById('results');
    
    btn.disabled = true;
    btnText.classList.add('hidden');
    btnLoading.classList.remove('hidden');
    
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);
    
    fetch('/prediksi/calculate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            document.getElementById('resultNama').textContent = data.nama_balita || 'Tidak diisi';
            document.getElementById('resultUsia').textContent = data.usia_bulan;
            document.getElementById('resultJK').textContent = data.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
            document.getElementById('resultBB').textContent = data.berat_badan;
            document.getElementById('resultTB').textContent = data.tinggi_badan;
            document.getElementById('resultLK').textContent = data.lingkar_kepala;
            document.getElementById('resultLila').textContent = data.lila;
            
            const now = new Date();
            document.getElementById('resultDate').textContent = now.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
            
            document.getElementById('statusGizi').textContent = result.status_gizi;
            document.getElementById('bmiValue').textContent = result.bmi;
            
            if (result.saved) {
                document.getElementById('savedNotification').classList.remove('hidden');
            } else {
                document.getElementById('savedNotification').classList.add('hidden');
            }
            
            const statusCard = document.getElementById('statusCard');
            const statusIcon = document.getElementById('statusIcon');
            
            if (result.status_gizi === 'Gizi Normal') {
                statusCard.className = 'bg-white rounded-xl shadow p-5 text-center border-l-4 border-green-500';
                statusIcon.textContent = '✓';
                statusIcon.className = 'text-4xl mb-2 text-green-600';
                document.getElementById('statusGizi').className = 'text-2xl font-bold text-green-600 mb-1';
            } else {
                statusCard.className = 'bg-white rounded-xl shadow p-5 text-center border-l-4 border-red-500';
                statusIcon.textContent = '!';
                statusIcon.className = 'text-4xl mb-2 text-red-600';
                document.getElementById('statusGizi').className = 'text-2xl font-bold text-red-600 mb-1';
            }
            
            const recommendationsList = document.getElementById('recommendations');
            recommendationsList.innerHTML = '';
            result.recommendations.forEach((rec, index) => {
                const li = document.createElement('li');
                li.className = 'flex items-start';
                li.innerHTML = `<span class="bg-purple-100 text-purple-700 rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold mr-2 flex-shrink-0">${index + 1}</span><span>${rec}</span>`;
                recommendationsList.appendChild(li);
            });
            
            results.classList.remove('hidden');
            results.scrollIntoView({ behavior: 'smooth' });
            
            Swal.fire({
                icon: 'success',
                title: 'Analisis Selesai',
                text: result.saved ? 'Hasil disimpan ke database.' : 'Hasil berhasil dihitung.',
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            throw new Error(result.error || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        Swal.fire({ icon: 'error', title: 'Error', text: error.message });
    })
    .finally(() => {
        btn.disabled = false;
        btnText.classList.remove('hidden');
        btnLoading.classList.add('hidden');
    });
});

function printResult() { window.print(); }
function resetForm() {
    document.getElementById('predictForm').reset();
    document.getElementById('results').classList.add('hidden');
    document.getElementById('savedNotification').classList.add('hidden');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>
@endsection
