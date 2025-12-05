@extends('layouts.sidebar')

@section('content')
<div class="p-6">
  <h2 class="text-2xl font-bold mb-3">Dashboard Balita - {{ $balita->nama_balita }}</h2>

  <div class="bg-white p-4 rounded shadow mb-6">
    <p><strong>Nama Orang Tua:</strong> {{ $balita->nama_ortu }}</p>
    <p><strong>Jenis Kelamin:</strong> {{ $balita->jenis_kelamin }}</p>
    <p><strong>Tanggal Lahir:</strong> {{ $balita->tanggal_lahir }}</p>
    <p><strong>Alamat:</strong> {{ $balita->alamat }}</p>
  </div>

  <h3 class="text-lg font-semibold mb-2">Riwayat Pengukuran</h3>
  <table class="min-w-full bg-white mb-6">
    <thead>
      <tr>
        <th class="px-4 py-2">Waktu</th>
        <th class="px-4 py-2">Usia (bln)</th>
        <th class="px-4 py-2">BB (kg)</th>
        <th class="px-4 py-2">TB (cm)</th>
        <th class="px-4 py-2">LK (cm)</th>
        <th class="px-4 py-2">Status Gizi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($balita->pengukuran as $p)
      <tr>
        <td class="border px-4 py-2">{{ $p->created_at->format('M Y') }}</td>
        <td class="border px-4 py-2">{{ $p->usia_bulan }}</td>
        <td class="border px-4 py-2">{{ $p->berat_badan }}</td>
        <td class="border px-4 py-2">{{ $p->tinggi_badan }}</td>
        <td class="border px-4 py-2">{{ $p->lingkar_kepala }}</td>
        <td class="border px-4 py-2">
          {{ $p->statusGizi->hasil_status_gizi ?? '-' }}
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{-- Saran sederhana berdasarkan hasil pengukuran terakhir --}}
  <div class="bg-white p-4 rounded shadow">
    <h4 class="font-semibold">Saran Menurut Pengukuran Terakhir</h4>
    @if($last && $last->statusGizi)
      <p class="mt-2">Status Gizi terakhir: <strong>{{ $last->statusGizi->hasil_status_gizi }}</strong></p>
      {{-- contoh saran, nanti bisa disesuaikan dengan aturan fuzzymu --}}
      @if(Str::contains($last->statusGizi->hasil_status_gizi, 'Gizi buruk') )
        <p>Perhatikan asupan gizi, konsultasikan dengan tenaga kesehatan.</p>
      @else
        <p>Pertahankan pola pemberian makan sesuai umur.</p>
      @endif
    @else
      <p class="mt-2">Belum ada pengukuran/hasil gizi untuk balita ini.</p>
    @endif
  </div>
</div>
@endsection
