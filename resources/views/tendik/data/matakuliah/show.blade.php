{{-- resources/views/tendik/data/matakuliah/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Lihat Mata Kuliah')

@section('content')
    <h1 class="display-4 fw-bold mb-4" style="color: #581da4ff;">Menu Data Mata Kuliah</h1>

    <div class="card p-5 border-0" style="background-color: #31065f; border-radius: 15px;">
        <h4 class="text-white mb-4">Lihat Matkul</h4>
        
        <div class="row">
            <div class="col-5 text-white fw-bold py-2">ID</div>
            <div class="col-7 text-white py-2">: {{ $matkul->kode_matkul }}</div>
            
            <div class="col-5 text-white fw-bold py-2">Nama Matkul</div>
            <div class="col-7 text-white py-2">: {{ $matkul->nama_matkul }}</div>
            
            <div class="col-5 text-white fw-bold py-2">SKS</div>
            <div class="col-7 text-white py-2">: {{ $matkul->sks ?? 3 }}</div>
            
            <div class="col-5 text-white fw-bold py-2">Dosen Pengampu</div>
            {{-- KOREKSI UTAMA: Mengambil semua nama dosen dan menggabungkannya dengan koma --}}
            <div class="col-7 text-white py-2">: {{ $matkul->dosens->pluck('nama_dosen')->implode(', ') ?: 'N/A' }}</div>
            
            <div class="col-5 text-white fw-bold py-2">Tanggal Input</div>
            <div class="col-7 text-white py-2">: {{ $matkul->created_at->format('d/m/Y') }}</div>
        </div>

        <a href="{{ route('tendik.matakuliah.index') }}" class="btn btn-secondary mt-4" style="width: 150px;">Kembali</a>
    </div>
@endsection