<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Kader/Bidan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    * {
      box-sizing: border-box;
    }

    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #6B46C1, #9333EA);
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 30px;
    }

    .card {
      background: white;
      border-radius: 18px;
      box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
      padding: 40px 35px;
      max-width: 440px;
      width: 100%;
      text-align: center;
      color: #333;
    }

    .card h1 {
      font-size: 22px;
      color: #6B46C1;
      margin-bottom: 20px;
    }

    .card .illustration {
      height: 120px;
      margin-bottom: 20px;
    }

    input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 14px;
      transition: border 0.3s;
    }

    input:focus {
      outline: none;
      border-color: #9333EA;
      box-shadow: 0 0 0 3px rgba(147, 51, 234, 0.2);
    }

    .password-wrapper {
      position: relative;
    }

    .toggle-password {
      position: absolute;
      top: 50%;
      right: 12px;
      transform: translateY(-50%);
      cursor: pointer;
    }

    .eye-icon {
      width: 22px;
      height: 22px;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #9333EA;
      color: white;
      border: none;
      font-size: 15px;
      font-weight: bold;
      border-radius: 10px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: #7C3AED;
    }

    .forgot-link {
      display: block;
      margin-top: 12px;
      font-size: 12px;
      color: #9333EA;
      text-decoration: none;
      transition: color 0.3s;
    }

    .forgot-link:hover {
      color: #7C3AED;
    }

    .footer {
      font-size: 11px;
      color: #aaa;
      margin-top: 25px;
    }
  </style>
</head>
<body>

  <div class="card">
    <!-- SVG ILUSTRASI -->
    <svg class="illustration" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" fill="none">
      <circle cx="60" cy="60" r="50" fill="#9333EA" opacity="0.08"/>
      <path d="M60 32a13 13 0 1 1 0 26 13 13 0 0 1 0-26zm0 34c11.05 0 33 5.5 33 16v5H27v-5c0-10.5 21.95-16 33-16z" fill="#9333EA"/>
    </svg>

    <h1>POSYCARE - Sistem Penentuan Status Gizi Balita</h1>

    <form method="POST" action="{{ url('/login') }}" autocomplete="off">
      @csrf
      <input type="email" name="email" placeholder="Alamat Email" required autocomplete="off" value="{{ old('email') }}">

      <div class="password-wrapper">
        <input type="password" name="password" id="password" placeholder="Kata Sandi" required autocomplete="new-password">
        <span class="toggle-password" onclick="togglePassword()">
          <!-- Ikon Mata Terbuka -->
          <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
            <circle cx="12" cy="12" r="3"/>
          </svg>

          <!-- Ikon Mata Tertutup -->
          <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-5 0-9.27-3.11-11-7a17.78 17.78 0 0 1 5.29-6.26"/>
            <path d="M1 1l22 22"/>
            <path d="M9.53 9.53A3.5 3.5 0 0 1 14.47 14.47"/>
          </svg>
        </span>
      </div>

      <button type="submit">Masuk</button>
    </form>

    <div class="footer">
      <div class="flex justify-center space-x-4 mb-3">
        <a href="/" class="text-purple-600 hover:text-purple-800 text-sm transition-colors">
          <i class="fas fa-home mr-1"></i>Kembali ke Beranda
        </a>
      </div>
      &copy; {{ date('Y') }} POSYCARE
    </div>
  </div>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const eyeOpen = document.getElementById('eye-open');
      const eyeClosed = document.getElementById('eye-closed');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeOpen.style.display = 'none';
        eyeClosed.style.display = 'block';
      } else {
        passwordInput.type = 'password';
        eyeOpen.style.display = 'block';
        eyeClosed.style.display = 'none';
      }
    }

    // SweetAlert feedback
    @if ($errors->any())
      Swal.fire({
        icon: 'error',
        title: 'Login Gagal',
        text: '{{ $errors->first() }}',
        confirmButtonColor: '#9333EA',
      });
    @endif

    @if(session('success'))
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false
      });
    @endif

    @if(session('error'))
      Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session('error') }}',
        timer: 2000,
        showConfirmButton: false
      });
    @endif
  </script>

</body>
</html>
