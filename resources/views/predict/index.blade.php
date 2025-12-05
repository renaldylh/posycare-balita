@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-100">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <a href="/" class="flex items-center">
                        <i class="fas fa-heartbeat text-3xl text-purple-600 mr-3"></i>
                        <span class="text-2xl font-bold text-gray-800">POSYCARE</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/" class="text-gray-700 hover:text-purple-600 transition-colors">
                        <i class="fas fa-home mr-2"></i>Beranda
                    </a>
                    <a href="/login" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">
                Prediksi Status Gizi Balita
            </h1>
            <p class="text-xl text-gray-600">
                Masukkan data pengukuran balita untuk mengetahui status gizi
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form id="predictForm" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Usia -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-baby mr-2 text-purple-600"></i>Usia (bulan)
                        </label>
                        <input type="number" id="usia_bulan" name="usia_bulan" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="Contoh: 12" min="0" max="60" required>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-venus-mars mr-2 text-purple-600"></i>Jenis Kelamin
                        </label>
                        <select id="jenis_kelamin" name="jenis_kelamin" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                    <!-- Berat Badan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-weight mr-2 text-purple-600"></i>Berat Badan (kg)
                        </label>
                        <input type="number" id="berat_badan" name="berat_badan" step="0.1"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="Contoh: 8.5" min="0" max="50" required>
                    </div>

                    <!-- Tinggi Badan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-ruler-vertical mr-2 text-purple-600"></i>Tinggi Badan (cm)
                        </label>
                        <input type="number" id="tinggi_badan" name="tinggi_badan" step="0.1"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="Contoh: 72" min="30" max="150" required>
                    </div>

                    <!-- Lingkar Kepala -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-circle mr-2 text-purple-600"></i>Lingkar Kepala (cm)
                        </label>
                        <input type="number" id="lingkar_kepala" name="lingkar_kepala" step="0.1"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="Contoh: 44" min="20" max="60" required>
                    </div>

                    <!-- LILA -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tape mr-2 text-purple-600"></i>LILA (cm)
                        </label>
                        <input type="number" id="lila" name="lila" step="0.1"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="Contoh: 15" min="5" max="30" required>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center">
                    <button type="submit" 
                            class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-lg transition-colors flex items-center">
                        <i class="fas fa-calculator mr-2"></i>
                        <span id="btnText">Hitung Prediksi</span>
                        <i class="fas fa-spinner fa-spin ml-2 hidden" id="btnLoading"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Section (Hidden by default) -->
        <div id="results" class="hidden mt-8">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                    <i class="fas fa-chart-line mr-2 text-purple-600"></i>
                    Hasil Prediksi
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Status Gizi -->
                    <div class="text-center p-6 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl">
                        <div class="text-3xl font-bold text-purple-600 mb-2" id="statusGizi">-</div>
                        <div class="text-gray-600">Status Gizi</div>
                    </div>

                    <!-- BMI -->
                    <div class="text-center p-6 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl">
                        <div class="text-3xl font-bold text-indigo-600 mb-2" id="bmiValue">-</div>
                        <div class="text-gray-600">Indeks Massa Tubuh (BMI)</div>
                    </div>
                </div>

                <!-- Recommendations -->
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-lightbulb mr-2 text-yellow-600"></i>
                        Rekomendasi
                    </h3>
                    <ul id="recommendations" class="space-y-2 text-gray-700">
                        <!-- Recommendations will be inserted here -->
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-center space-x-4 mt-8">
                    <button onclick="window.print()" 
                            class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition-colors">
                        <i class="fas fa-print mr-2"></i>Cetak Hasil
                    </button>
                    <a href="/login" 
                       class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg transition-colors">
                        <i class="fas fa-user-md mr-2"></i>Login Kader
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('predictForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const btn = e.target.querySelector('button[type="submit"]');
    const btnText = document.getElementById('btnText');
    const btnLoading = document.getElementById('btnLoading');
    const results = document.getElementById('results');
    
    // Show loading
    btn.disabled = true;
    btnText.textContent = 'Menghitung...';
    btnLoading.classList.remove('hidden');
    
    // Get form data
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);
    
    // Send to server
    fetch('/predict/calculate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            // Display results
            document.getElementById('statusGizi').textContent = result.status_gizi;
            document.getElementById('bmiValue').textContent = result.bmi;
            
            // Display recommendations
            const recommendationsList = document.getElementById('recommendations');
            recommendationsList.innerHTML = '';
            result.recommendations.forEach(rec => {
                const li = document.createElement('li');
                li.className = 'flex items-start';
                li.innerHTML = `<i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i><span>${rec}</span>`;
                recommendationsList.appendChild(li);
            });
            
            // Show results section
            results.classList.remove('hidden');
            results.scrollIntoView({ behavior: 'smooth' });
            
            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Perhitungan Selesai!',
                text: 'Hasil prediksi status gizi telah dihitung.',
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            throw new Error('Terjadi kesalahan');
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Terjadi kesalahan saat memproses data.',
        });
    })
    .finally(() => {
        // Hide loading
        btn.disabled = false;
        btnText.textContent = 'Hitung Prediksi';
        btnLoading.classList.add('hidden');
    });
});
</script>
@endsection
