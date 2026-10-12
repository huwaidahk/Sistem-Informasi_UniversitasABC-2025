{{-- resources/views/tendik/data/dosen/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Menu Data Dosen')

@section('content')
    <h1 class="display-4 fw-bold mb-4" style="color: #581da4ff;">Menu Data Dosen</h1>

    {{-- Header dengan Tombol Tambah dan Cari --}}
    <div class="d-flex justify-content-end align-items-center mb-3">
        {{-- Tombol Tambah Dosen --}}
        <a href="{{ route('tendik.dosen.create') }}" class="btn btn-success fw-bold" style="background-color: #198754; border-color: #198754;">
            <i class="fa fa-plus me-2"></i> Tambah Dosen
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif

    {{-- CARD TABEL DATA --}}
    <div class="card p-3 border-0 mt-2" 
         style="background-color: #31065f; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.5);">
        <div class="table-responsive">
            <table class="table table-dark table-striped table-borderless mb-0">
                <thead>
                    <tr style="background-color: #4a2b85;">
                        <th style="color: white;">NIDN</th>
                        <th style="color: white;">NAMA</th>
                        {{-- MATA KULIAH DIHAPUS --}}
                        <th style="color: white;">TENDIK INPUT</th>
                        <th style="color: white;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dosens as $dosen)
                        <tr style="background-color: #31065f;" class="align-middle"> 
                            <td>{{ $dosen->nidn }}</td>
                            <td>{{ $dosen->nama_dosen }}</td>
                            
                            {{-- CELL MATA KULIAH DIHAPUS --}}
                            
                            <td>
                                {{ $dosen->user->name ?? 'Administrator' }}<br>
                                <small class="text-white-50">{{ $dosen->created_at->format('d/m/Y') }}</small>
                            </td>
                            
                            {{-- KOREKSI: KOLOM AKSI HANYA TOMBOL LIHAT --}}
                            <td style="min-width: 100px;">
                                <a href="{{ route('tendik.dosen.show', $dosen) }}" 
                                   class="btn btn-sm text-white" 
                                   style="background-color: #3B82F6;">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        {{-- Colspan disesuaikan menjadi 4 kolom --}}
                        <tr><td colspan="4" class="text-center text-white-50">Belum ada data Dosen di sistem.</td></tr> 
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection