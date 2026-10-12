{{-- resources/views/tendik/data/dosen/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Lihat Dosen')

@section('content')
    <h1 class="display-4 fw-bold mb-4" style="color: #581da4ff;">Menu Data Dosen</h1>

    <div class="card p-5 border-0" style="background-color: #31065f; border-radius: 15px;">
        <h4 class="text-white mb-4">Lihat Dosen</h4>
        
        <div class="row mb-2">
            <div class="col-4 text-white fw-bold">NIDN:</div>
            <div class="col-8 text-white-50">{{ $dosen->nidn }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-4 text-white fw-bold">Nama:</div>
            <div class="col-8 text-white-50">{{ $dosen->nama_dosen }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-4 text-white fw-bold">Mata Kuliah:</div>
            <div class="col-8 text-white-50">
                @if ($dosen->mataKuliahs->count())
                    {{ $dosen->mataKuliahs->pluck('nama_matkul')->implode(', ') }}
                @else
                    —
                @endif
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-4 text-white fw-bold">Tendik Input:</div>
            <div class="col-8 text-white-50">{{ $dosen->user->name ?? 'N/A' }} | {{ $dosen->created_at->format('d/m/Y') }}</div>
        </div>
        
        <a href="{{ route('tendik.dosen.index') }}" class="btn btn-secondary" style="width: 150px;">Kembali</a>
    </div>
@endsection