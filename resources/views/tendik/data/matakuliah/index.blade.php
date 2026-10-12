{{-- resources/views/tendik/data/matakuliah/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Menu Data Mata Kuliah')

@section('content')
    <h1 class="display-4 fw-bold mb-4" style="color: #581da4ff;">Menu Data Mata Kuliah</h1>

    {{-- Header dengan Tombol Tambah Mata Kuliah --}}
    <div class="d-flex justify-content-end align-items-center mb-3">
        <a href="{{ route('tendik.matakuliah.create') }}" class="btn btn-success me-2 fw-bold" s
        tyle="background-color: #198754; border-color: #198754;">
            <i class="fa fa-plus me-2"></i> Tambah Mata Kuliah
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif

    <div class="card p-3 border-0 mt-4" 
         style="background-color: #31065f; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.5);">
        <div class="table-responsive">
            <table class="table table-dark table-striped table-borderless mb-0">
                <thead>
                    <tr style="background-color: #4a2b85;">
                        <th style="color: white;">KODE MK</th>
                        <th style="color: white;">NAMA MATKUL</th>
                        <th style="color: white;">SKS</th>
                        <th style="color: white;">DOSEN PENGAMPU</th>
                        <th style="color: white;">TENDIK INPUT</th> 
                        <th style="color: white;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($matkuls as $matkul)
                        <tr style="background-color: #31065f;">
                            <td>{{ $matkul->kode_matkul }}</td>
                            <td>{{ $matkul->nama_matkul }}</td>
                            <td>{{ $matkul->sks ?? 3 }}</td> 
                            
                            <td>
                                @forelse ($matkul->dosens as $dosen)
                                    {{ $dosen->nama_dosen }}{{ !$loop->last ? ', ' : '' }}
                                @empty
                                    —
                                @endforelse
                            </td>
                            
                            {{-- TENDIK INPUT --}}
                            <td>
                                {{ $matkul->user->name ?? 'Administrator' }}<br>
                                <small class="text-white-50">{{ $matkul->created_at->format('d/m/Y') }}</small>
                            </td>
                            
                            {{-- KOREKSI: KOLOM AKSI HANYA TOMBOL LIHAT --}}
                            <td style="min-width: 100px;">
                                <a href="{{ route('tendik.matakuliah.show', $matkul) }}" 
                                   class="btn btn-sm text-white" 
                                   style="background-color: #3B82F6;">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        {{-- Colspan tetap 6 (Kode MK, Nama Matkul, SKS, Dosen, Tendik, Aksi) --}}
                        <tr><td colspan="6" class="text-center text-white-50">Belum ada data Mata Kuliah yang Anda inputkan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection