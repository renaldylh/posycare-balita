@extends('layouts.sidebar')

@section('title', 'Dashboard')

@section('content')
<div class="flex justify-between items-center mb-6">
  <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
  <div class="text-sm text-gray-600" id="tanggalWaktu"></div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
  <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
    <div class="flex items-center">
      <div class="p-3 rounded-full bg-purple-100 mr-4">
        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
      </div>
      <div>
        <p class="text-sm text-gray-600">Total Balita</p>
        <p class="text-2xl font-bold text-gray-800">{{ App\Models\Balita::count() }}</p>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-lg shadow p-6 border-l-4 border-indigo-500">
    <div class="flex items-center">
      <div class="p-3 rounded-full bg-indigo-100 mr-4">
        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
        </svg>
      </div>
      <div>
        <p class="text-sm text-gray-600">Total Pengukuran</p>
        <p class="text-2xl font-bold text-gray-800">{{ App\Models\Pengukuran::count() }}</p>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
    <div class="flex items-center">
      <div class="p-3 rounded-full bg-green-100 mr-4">
        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
        </svg>
      </div>
      <div>
        <p class="text-sm text-gray-600">Dataset</p>
        <p class="text-2xl font-bold text-gray-800">{{ App\Models\Balita::count() }}</p>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
    <div class="flex items-center">
      <div class="p-3 rounded-full bg-yellow-100 mr-4">
        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
      </div>
      <div>
        <p class="text-sm text-gray-600">Total Users</p>
        <p class="text-2xl font-bold text-gray-800">{{ App\Models\User::count() }}</p>
      </div>
    </div>
  </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-lg shadow p-6">
  <h2 class="text-xl font-semibold text-gray-800 mb-4">Aksi Cepat</h2>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <a href="{{ route('balita.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white p-4 rounded-lg text-center transition-colors">
      <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
      </svg>
      <p>Data Balita</p>
    </a>

    <a href="{{ route('pengukuran.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white p-4 rounded-lg text-center transition-colors">
      <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
      </svg>
      <p>Tambah Pengukuran</p>
    </a>

    <a href="{{ route('dataset.index') }}" class="bg-green-600 hover:bg-green-700 text-white p-4 rounded-lg text-center transition-colors">
      <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
      </svg>
      <p>Dataset</p>
    </a>

    <a href="{{ route('users.index') }}" class="bg-yellow-600 hover:bg-yellow-700 text-white p-4 rounded-lg text-center transition-colors">
      <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
      </svg>
      <p>Manajemen User</p>
    </a>
  </div>
</div>

<script>
  function updateWaktu(){
    const now = new Date();
    const options = { weekday:'long', year:'numeric', month:'long', day:'numeric' };
    document.getElementById('tanggalWaktu').textContent = now.toLocaleDateString('id-ID', options) + ' | ' + now.toLocaleTimeString('id-ID');
  }
  updateWaktu(); 
  setInterval(updateWaktu, 1000);
</script>
@endsection
