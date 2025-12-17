@extends('layouts.sidebar')

@section('title', 'Manajemen User')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen User</h1>
            <p class="text-gray-500 text-sm">Kelola akun pengguna sistem</p>
        </div>
        <a href="{{ route('users.create') }}" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-4 py-2 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all text-sm">
            + Tambah User
        </a>
    </div>

    @if(session('success'))
        <div class="p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">{{ session('success') }}</div>
    @endif

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-purple-500">
            <p class="text-sm text-gray-500">Total User</p>
            <p class="text-3xl font-bold text-gray-800">{{ $users->count() }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-green-500">
            <p class="text-sm text-gray-500">Admin</p>
            <p class="text-3xl font-bold text-green-600">{{ $users->where('role', 'admin')->count() }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-blue-500">
            <p class="text-sm text-gray-500">User Biasa</p>
            <p class="text-3xl font-bold text-blue-600">{{ $users->where('role', '!=', 'admin')->count() }}</p>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
                <tr>
                    <th class="px-4 py-3 text-left font-medium">No</th>
                    <th class="px-4 py-3 text-left font-medium">Nama</th>
                    <th class="px-4 py-3 text-left font-medium">Email</th>
                    <th class="px-4 py-3 text-left font-medium">Role</th>
                    <th class="px-4 py-3 text-left font-medium">Dibuat</th>
                    <th class="px-4 py-3 text-center font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $index => $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-600">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $user->name }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded text-xs {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ ucfirst($user->role ?? 'user') }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center gap-2 text-xs">
                            <a href="{{ route('users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-800">Edit</a>
                            @if(auth()->id() != $user->id)
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus user ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
