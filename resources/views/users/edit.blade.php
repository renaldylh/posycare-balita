@extends('layouts.sidebar')

@section('title', 'Edit User')

@section('content')
<div class="flex justify-between items-center mb-6">
  <h1 class="text-3xl font-bold text-gray-800">Edit User</h1>
  <a href="{{ route('users.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
    Kembali
  </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
  <form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
        <input type="text" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required
               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        @error('nama')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        @error('email')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password (kosongkan jika tidak diubah)</label>
        <input type="password" id="password" name="password"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
               placeholder="Biarkan kosong jika tidak mengubah password">
        @error('password')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
        <select id="role" name="role" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
          <option value="">Pilih Role</option>
          <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
        </select>
        @error('role')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>
    </div>

    <div class="mt-6 flex justify-end gap-3">
      <a href="{{ route('users.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
        Batal
      </a>
      <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
        Update
      </button>
    </div>
  </form>
</div>
@endsection
