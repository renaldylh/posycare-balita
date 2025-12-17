@extends('layouts.sidebar')

@section('title', 'Data Balita')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Balita</h1>
            <p class="text-gray-500 text-sm">Kelola data balita terdaftar di posyandu</p>
        </div>
        <button onclick="openAddModal()" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-4 py-2 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all text-sm">
            + Tambah Balita
        </button>
    </div>

    @if(session('success'))
        <div class="p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">{{ session('success') }}</div>
    @endif

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow p-4">
        <form action="{{ route('balita.index') }}" method="GET" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs text-gray-500 mb-1">Cari Nama</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama balita..." class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm">
            </div>
            <div class="w-32">
                <label class="block text-xs text-gray-500 mb-1">Jenis Kelamin</label>
                <select name="jk" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm">
                    <option value="">Semua</option>
                    <option value="L" {{ request('jk') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ request('jk') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="w-36">
                <label class="block text-xs text-gray-500 mb-1">Status Gizi</label>
                <select name="status" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm">
                    <option value="">Semua</option>
                    <option value="normal" {{ request('status') == 'normal' ? 'selected' : '' }}>Gizi Normal</option>
                    <option value="buruk" {{ request('status') == 'buruk' ? 'selected' : '' }}>Gizi Buruk</option>
                    <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum Diprediksi</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm">Filter</button>
            @if(request()->hasAny(['search', 'jk', 'status']))
            <a href="{{ route('balita.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm">Reset</a>
            @endif
        </form>
    </div>

    @php
        $query = App\Models\Balita::query();
        
        if(request('search')) {
            $query->where('nama_balita', 'like', '%'.request('search').'%');
        }
        if(request('jk')) {
            $query->where('jenis_kelamin', request('jk'));
        }
        
        $balitas = $query->orderBy('nama_balita')->paginate(15)->withQueryString();
        
        $maleCount = App\Models\Balita::where('jenis_kelamin', 'L')->count();
        $femaleCount = App\Models\Balita::where('jenis_kelamin', 'P')->count();
    @endphp

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-purple-500">
            <p class="text-sm text-gray-500">Total Balita</p>
            <p class="text-3xl font-bold text-gray-800">{{ App\Models\Balita::count() }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-blue-500">
            <p class="text-sm text-gray-500">Laki-laki</p>
            <p class="text-3xl font-bold text-blue-600">{{ $maleCount }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-pink-500">
            <p class="text-sm text-gray-500">Perempuan</p>
            <p class="text-3xl font-bold text-pink-600">{{ $femaleCount }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-green-500">
            <p class="text-sm text-gray-500">Sudah Diprediksi</p>
            <p class="text-3xl font-bold text-green-600">{{ App\Models\Pengukuran::whereNotNull('status_gizi_ml')->distinct('id_balita')->count('id_balita') }}</p>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
                <tr>
                    <th class="px-4 py-3 text-left font-medium">No</th>
                    <th class="px-4 py-3 text-left font-medium">Nama</th>
                    <th class="px-4 py-3 text-left font-medium">JK</th>
                    <th class="px-4 py-3 text-left font-medium">Tgl Lahir</th>
                    <th class="px-4 py-3 text-left font-medium">Usia</th>
                    <th class="px-4 py-3 text-left font-medium">Ortu</th>
                    <th class="px-4 py-3 text-left font-medium">Status Gizi</th>
                    <th class="px-4 py-3 text-center font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($balitas as $b)
                @php
                    $lastPrediksi = App\Models\Pengukuran::where('id_balita', $b->id_balita)->whereNotNull('status_gizi_ml')->latest()->first();
                    $usia = \Carbon\Carbon::parse($b->tanggal_lahir)->diffInMonths(\Carbon\Carbon::now());
                    
                    // Filter by status
                    if(request('status')) {
                        if(request('status') == 'normal' && (!$lastPrediksi || $lastPrediksi->status_gizi_ml != 'Gizi Normal')) continue;
                        if(request('status') == 'buruk' && (!$lastPrediksi || $lastPrediksi->status_gizi_ml != 'Gizi Buruk')) continue;
                        if(request('status') == 'belum' && $lastPrediksi) continue;
                    }
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-600">{{ $loop->iteration + ($balitas->currentPage()-1)*$balitas->perPage() }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $b->nama_balita }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded text-xs {{ $b->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                            {{ $b->jenis_kelamin }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($b->tanggal_lahir)->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ floor($usia) }} bln</td>
                    <td class="px-4 py-3 text-gray-600">{{ $b->nama_ortu ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @if($lastPrediksi)
                            <span class="px-2 py-0.5 rounded-full text-xs {{ $lastPrediksi->status_gizi_ml === 'Gizi Normal' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $lastPrediksi->status_gizi_ml === 'Gizi Normal' ? 'Normal' : 'Buruk' }}
                            </span>
                        @else
                            <span class="text-gray-400 text-xs">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center gap-2 text-xs">
                            <a href="{{ route('balita.show', $b->id_balita) }}" class="text-purple-600 hover:text-purple-800">Detail</a>
                            <a href="{{ route('prediksi.index', ['balita' => $b->id_balita]) }}" class="text-green-600 hover:text-green-800">Prediksi</a>
                            <button onclick="openEditModal({{ json_encode($b) }})" class="text-indigo-600 hover:text-indigo-800">Edit</button>
                            <form action="{{ route('balita.destroy', $b->id_balita) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-4 py-8 text-center text-gray-400">Belum ada data</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($balitas->hasPages())
        <div class="px-4 py-3 border-t">{{ $balitas->links() }}</div>
        @endif
    </div>
</div>

<!-- Modal -->
<div id="balitaModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black/50" onclick="closeModal()"></div>
        <div class="relative bg-white rounded-xl shadow-lg w-full max-w-md p-6 z-10">
            <div class="flex justify-between items-center mb-4">
                <h3 id="modalTitle" class="text-lg font-bold text-gray-800">Tambah Balita</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>
            <form id="balitaForm" method="POST" action="{{ route('balita.store') }}">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Nama Balita *</label>
                        <input type="text" name="nama_balita" id="nama_balita" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Jenis Kelamin *</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm">
                                <option value="">Pilih</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Tanggal Lahir *</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Nama Orang Tua</label>
                        <input type="text" name="nama_ortu" id="nama_ortu" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Alamat</label>
                        <textarea name="alamat" id="alamat" rows="2" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 text-sm"></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-5">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 text-sm">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 text-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Tambah Balita';
    document.getElementById('balitaForm').action = '{{ route("balita.store") }}';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('balitaForm').reset();
    document.getElementById('balitaModal').classList.remove('hidden');
}
function openEditModal(b) {
    document.getElementById('modalTitle').textContent = 'Edit Balita';
    document.getElementById('balitaForm').action = '/balita/' + b.id_balita;
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('nama_balita').value = b.nama_balita || '';
    document.getElementById('jenis_kelamin').value = b.jenis_kelamin || '';
    document.getElementById('tanggal_lahir').value = b.tanggal_lahir || '';
    document.getElementById('nama_ortu').value = b.nama_ortu || '';
    document.getElementById('alamat').value = b.alamat || '';
    document.getElementById('balitaModal').classList.remove('hidden');
}
function closeModal() { document.getElementById('balitaModal').classList.add('hidden'); }
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
</script>
@endsection
