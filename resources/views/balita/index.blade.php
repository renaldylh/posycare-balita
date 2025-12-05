@extends('layouts.sidebar')

@section('content')
<div class="flex justify-between items-center mb-4">
  <h1 class="text-2xl font-bold">Data Balita</h1>
  <div class="text-sm text-gray-600" id="tanggalWaktu"></div>
</div>

  <table class="min-w-full bg-white">
    <thead>
      <tr>
        <th class="px-4 py-2">#</th>
        <th class="px-4 py-2">Nama</th>
        <th class="px-4 py-2">Jenis Kelamin</th>
        <th class="px-4 py-2">Tanggal Lahir</th>
        <th class="px-4 py-2">Nama Ortu</th>
        <th class="px-4 py-2">Alamat</th>
        <th class="px-4 py-2">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($balitas as $b)
      <tr>
        <td class="border px-4 py-2">{{ $loop->iteration + ($balitas->currentPage()-1)*$balitas->perPage() }}</td>
        <td class="border px-4 py-2">
          <a href="{{ route('balita.show', $b->id_balita) }}" class="text-blue-600 hover:underline">
            {{ $b->nama_balita }}
          </a>
        </td>
        <td class="border px-4 py-2">{{ $b->jenis_kelamin }}</td>
        <td class="border px-4 py-2">{{ $b->tanggal_lahir }}</td>
        <td class="border px-4 py-2">{{ $b->nama_ortu }}</td>
        <td class="border px-4 py-2">{{ $b->alamat }}</td>
        <td class="border px-4 py-2">
          <a href="{{ route('balita.show', $b->id_balita) }}" class="px-3 py-1 bg-green-500 text-white rounded">Lihat</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="mt-4">
    {{ $balitas->links() }}
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
