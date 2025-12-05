<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POSYCARE - Sistem Penentuan Status Gizi Balita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .feature-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="fas fa-heartbeat text-3xl feature-icon mr-3"></i>
                        <span class="text-2xl font-bold text-gray-800">POSYCARE</span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/predict" class="text-gray-700 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        <i class="fas fa-calculator mr-2"></i>Prediksi
                    </a>
                    <a href="/login" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Sistem Penentuan Status Gizi Balita
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-purple-100">
                    Monitoring kesehatan dan gizi balita dengan teknologi modern
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/predict" class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                        <i class="fas fa-calculator mr-2"></i>Coba Prediksi Gratis
                    </a>
                    <a href="/login" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-purple-600 transition-colors">
                        <i class="fas fa-user-md mr-2"></i>Login Kader/Bidan
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    Fitur Unggulan Kami
                </h2>
                <p class="text-xl text-gray-600">
                    Teknologi modern untuk monitoring kesehatan balita
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="card-hover bg-white rounded-xl shadow-lg p-8 text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-chart-line text-2xl feature-icon"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Prediksi Akurat</h3>
                    <p class="text-gray-600">
                        Sistem cerdas untuk menganalisis status gizi balita berdasarkan parameter kesehatan standar
                    </p>
                </div>

                <div class="card-hover bg-white rounded-xl shadow-lg p-8 text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-database text-2xl feature-icon"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Data Terintegrasi</h3>
                    <p class="text-gray-600">
                        Kelola data balita dan riwayat pengukuran dalam satu sistem yang terintegrasi
                    </p>
                </div>

                <div class="card-hover bg-white rounded-xl shadow-lg p-8 text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-file-medical text-2xl feature-icon"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Laporan Lengkap</h3>
                    <p class="text-gray-600">
                        Generate laporan status gizi balita untuk kepentingan monitoring dan evaluasi
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-4xl font-bold feature-icon mb-2">500+</div>
                    <div class="text-gray-600">Balita Terdaftar</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold feature-icon mb-2">95%</div>
                    <div class="text-gray-600">Akurasi Prediksi</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold feature-icon mb-2">24/7</div>
                    <div class="text-gray-600">Monitoring Real-time</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold feature-icon mb-2">10+</div>
                    <div class="text-gray-600">Posyandu Terhubung</div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    Cara Kerja Sistem
                </h2>
                <p class="text-xl text-gray-600">
                    3 langkah mudah untuk monitoring gizi balita
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-20 h-20 bg-purple-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                        1
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Input Data</h3>
                    <p class="text-gray-600">
                        Masukkan data pengukuran balita (berat, tinggi, usia, dll)
                    </p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 bg-purple-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                        2
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Analisis AI</h3>
                    <p class="text-gray-600">
                        Sistem menganalisis data menggunakan algoritma cerdas
                    </p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 bg-purple-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                        3
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Hasil Prediksi</h3>
                    <p class="text-gray-600">
                        Dapatkan hasil status gizi dan rekomendasi tindakan
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="gradient-bg text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Mulai Monitoring Gizi Balita Sekarang
            </h2>
            <p class="text-xl mb-8 text-purple-100">
                Bergabung dengan ribuan kader dan bidan yang sudah menggunakan POSYCARE
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/predict" class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    <i class="fas fa-calculator mr-2"></i>Coba Prediksi Gratis
                </a>
                <a href="/login" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-purple-600 transition-colors">
                    <i class="fas fa-user-md mr-2"></i>Login Kader/Bidan
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-heartbeat text-2xl text-purple-400 mr-2"></i>
                        <span class="text-xl font-bold">POSYCARE</span>
                    </div>
                    <p class="text-gray-400">
                        Sistem monitoring kesehatan dan gizi balita untuk mendukung program kesehatan anak
                    </p>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Fitur</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="/predict" class="hover:text-purple-400 transition-colors">Prediksi Gizi</a></li>
                        <li><a href="/login" class="hover:text-purple-400 transition-colors">Dashboard</a></li>
                        <li><a href="#" class="hover:text-purple-400 transition-colors">Data Balita</a></li>
                        <li><a href="#" class="hover:text-purple-400 transition-colors">Laporan</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Bantuan</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-purple-400 transition-colors">Panduan</a></li>
                        <li><a href="#" class="hover:text-purple-400 transition-colors">FAQ</a></li>
                        <li><a href="#" class="hover:text-purple-400 transition-colors">Kontak</a></li>
                        <li><a href="#" class="hover:text-purple-400 transition-colors">Support</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-envelope mr-2"></i>info@posycare.id</li>
                        <li><i class="fas fa-phone mr-2"></i>(0281) 123456</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i>Indonesia</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} POSYCARE. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add scroll effect to navigation
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('shadow-xl');
            } else {
                nav.classList.remove('shadow-xl');
            }
        });
    </script>
</body>
</html>
