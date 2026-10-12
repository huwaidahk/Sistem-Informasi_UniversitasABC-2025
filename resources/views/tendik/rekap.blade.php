{{-- resources/views/tendik/rekap.blade.php --}}

@extends('layouts.app')

@section('title', 'Rekap Data')

@section('content')
    {{-- Header hanya menampilkan Judul --}}
    <h1 class="display-4 fw-bold mb-4" style="color: #581da4ff;">Rekap Data</h1>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    {{-- 1. REKAP DATA DOSEN YANG DIINPUT --}}
    <h4 class="mt-4 fw-bold" style="color: #581da4ff">Dosen yang Saya Input</h4>
    <div class="card p-3 border-0" 
         style="background-color: #31065f; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.5);">
        
        <div class="table-responsive">
            <table class="table table-dark table-striped table-borderless mb-0">
                <thead>
                    <tr style="background-color: #4a2b85;">
                        <th style="color: white;">NAMA DOSEN</th>
                        <th style="color: white;">NIDN</th>
                        <th style="color: white;">MATA KULIAH</th>
                        <th style="color: white;">AKUN LOGIN</th>
                        <th style="color: white;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dosenRekap as $dosen)
                        <tr style="background-color: #31065f;">
                            <td>{{ $dosen->nama_dosen }}</td>
                            <td>{{ $dosen->nidn }}</td>
                            
                            {{-- Mata Kuliah Diampu yang Diinput Sendiri --}}
                            <td>
                                @php
                                    // Memastikan hanya Matkul yang diampu dan diinput oleh Tendik ini yang ditampilkan di rekap
                                    $matkulDiampu = $dosen->mataKuliahs->where('user_id', Auth::id())->pluck('nama_matkul')->implode(', ');
                                @endphp
                                {{ $matkulDiampu ?: '—' }} 
                            </td>

                            <td>{{ $dosen->user->name ?? 'Administrator' }}</td>

                            {{-- KOREKSI: KOLOM AKSI HANYA TOMBOL LIHAT (Sesuai batasan Tendik) --}}
                            <td class="d-flex justify-content-start">
                                <a href="{{ route('tendik.dosen.show', $dosen) }}" 
                                   class="btn btn-sm text-white" 
                                   style="background-color: #3B82F6;">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr style="background-color: #31065f;">
                            <td colspan="5" class="text-center text-white-50 py-3">Anda belum menginput data Dosen.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <hr class="my-5 border-secondary" style="background-color: #31065f; height: 3px; opacity: 1;">

    {{-- 2. REKAP DATA MATA KULIAH YANG DIINPUT --}}
    <h4 class="mt-5 fw-bold" style="color: #581da4ff">Daftar Mata Kuliah yang Saya Input</h4>
    <div class="card p-3 border-0" 
         style="background-color: #31065f; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.5);">
        
        <div class="table-responsive">
            <table class="table table-dark table-striped table-borderless mb-0">
                <thead>
                    <tr style="background-color: #4a2b85;">
                        <th style="color: white;">KODE MK</th>
                        <th style="color: white;">NAMA MATA KULIAH</th>
                        <th style="color: white;">SKS</th>
                        <th style="color: white;">DOSEN PENGAMPU</th>
                        <th style="color: white;">AKUN LOGIN</th>
                        <th style="color: white;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($matkulRekap as $matkul)
                        <tr style="background-color: #31065f;">
                            <td>{{ $matkul->kode_matkul }}</td>
                            <td>{{ $matkul->nama_matkul }}</td>
                            <td>{{ $matkul->sks ?? 3 }}</td> 
                            
                            {{-- Dosen Pengampu --}}
                            <td>
                                @forelse ($matkul->dosens as $dosen)
                                    {{ $dosen->nama_dosen }}{{ !$loop->last ? ', ' : '' }}
                                @empty
                                    —
                                @endforelse
                            </td> 

                            <td>{{ $matkul->user->name ?? 'Administrator' }}</td>
                            
                            <td class="d-flex justify-content-start">
                                <a href="{{ route('tendik.matakuliah.show', $matkul) }}" 
                                   class="btn btn-sm text-white" 
                                   style="background-color: #3B82F6;">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr style="background-color: #31065f;">
                            <td colspan="6" class="text-center text-white-50 py-3">Belum ada data Mata Kuliah yang Anda inputkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection