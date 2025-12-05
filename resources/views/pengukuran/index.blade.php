@extends('layouts.sidebar')

@section('content')
<div class="bg-white shadow-lg rounded-xl p-6 border border-purple-100">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-purple-800">Data Pengukuran Balita</h2>
        <a href="{{ route('pengukuran.create') }}" 
           class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-5 py-2.5 rounded-xl shadow-lg hover:from-purple-700 hover:to-indigo-700 transition-all duration-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Ukur Balita Baru
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full border border-purple-200 rounded-xl overflow-hidden">
            <thead class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Nama Balita</th>
                    <th class="px-6 py-3 text-left font-semibold">Usia (bln)</th>
                    <th class="px-6 py-3 text-left font-semibold">BB (kg)</th>
                    <th class="px-6 py-3 text-left font-semibold">TB (cm)</th>
                    <th class="px-6 py-3 text-left font-semibold">LK (cm)</th>
                    <th class="px-6 py-3 text-left font-semibold">LiLA (cm)</th>
                    <th class="px-6 py-3 text-left font-semibold">Tanggal</th>
                    <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-purple-100">
                @forelse($pengukurans as $p)
                <tr class="hover:bg-purple-50 transition-colors duration-150">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $p->balita->nama_balita }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $p->usia_bulan }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $p->berat_badan }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $p->tinggi_badan }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $p->lingkar_kepala }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $p->lila }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ \Carbon\Carbon::parse($p->tanggal_pengukuran)->format('d-m-Y') }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('pengukuran.edit', $p->id_pengukuran) }}" 
                               class="bg-indigo-500 text-white px-3 py-1.5 rounded-lg hover:bg-indigo-600 transition-colors duration-200 inline-flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                            <form action="{{ route('pengukuran.destroy', $p->id_pengukuran) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-500 text-white px-3 py-1.5 rounded-lg hover:bg-red-600 transition-colors duration-200 inline-flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-lg font-medium">Belum ada data pengukuran</span>
                            <span class="text-sm text-gray-400 mt-1">Tambahkan data pengukuran balita untuk memulai</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
