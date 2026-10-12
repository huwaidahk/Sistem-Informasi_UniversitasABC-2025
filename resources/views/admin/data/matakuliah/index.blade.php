{{-- resources/views/admin/data/matakuliah/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Menu Data Mata Kuliah')

@section('content')
    {{-- HEADER DAN TOMBOL TAMBAH --}}
    <h1 class="display-4 fw-bold mb-4" style="color: #581da4ff;">Menu Mata Kuliah</h1>

    {{-- Header dengan Tombol Tambah--}}
        <div class="d-flex justify-content-end align-items-center mb-3">
            <a href="{{ route('admin.matakuliah.create') }}" class="btn btn-success fw-bold" style="background-color: #198754; border-color: #198754;">
                <i class="fa fa-plus me-2"></i> Tambah Mata Kuliah
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
                        <tr style="background-color: #31065f;" class="align-middle">
                            <td>{{ $matkul->kode_matkul }}</td>
                            <td>{{ $matkul->nama_matkul }}</td>
                            <td>{{ $matkul->sks ?? 'N/A' }}</td> 
                            <td>
                                @forelse ($matkul->dosens as $dosen)
                                    {{ $dosen->nama_dosen }}{{ !$loop->last ? ', ' : '' }}
                                @empty
                                    —
                                @endforelse
                            </td>
                            <td>
                                {{ $matkul->user->name ?? 'Administrator' }}<br>
                                <small class="text-white-50">{{ $matkul->created_at->format('d/m/Y') }}</small>
                            </td>
                            
                            {{-- KOLOM AKSI (HORIZONTAL) --}}
                            <td>
                                <a href="{{ route('admin.matakuliah.edit', $matkul) }}" 
                                   class="btn btn-sm text-white me-2" 
                                   style="background-color: #ffc107;">Edit</a>
                                
                                <form action="{{ route('admin.matakuliah.destroy', $matkul) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm text-white" 
                                            style="background-color: #dc3545;" 
                                            onclick="return confirm('Yakin ingin menghapus mata kuliah ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-white-50">Belum ada data Mata Kuliah di sistem.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection