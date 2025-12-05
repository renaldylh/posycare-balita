@extends('layouts.sidebar')

@section('title', 'Dataset')

@section('content')
<div class="flex justify-between items-center mb-4">
  <h1 class="text-2xl font-bold">Dataset</h1>
  <div class="text-sm text-gray-600" id="tanggalWaktu"></div>
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
