{{-- resources/views/admin/tendik/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Tendik')

@section('content')
    <h1 class="display-4 fw-bold mb-4" style="color: #581da4ff;">Menu Data Tendik</h1>

    {{-- Header dengan Tombol Tambah dan Cari --}}
    <div class="d-flex justify-content-end align-items-center mb-3">
        <a href="{{ route('admin.tendik.create') }}" class="btn btn-success fw-bold" style="background-color: #198754; border-color: #198754;">
            <i class="fa fa-plus me-2"></i> Tambah Tendik
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
                        <th style="color: white;">ID</th> {{-- Menjadi Nomor Urut Baris --}}
                        <th style="color: white;">NAMA</th>
                        <th style="color: white;">EMAIL</th>
                        <th style="color: white;">PASSWORD (STATUS)</th> 
                        <th style="color: white;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tendiks as $tendik)
                        <tr style="background-color: #31065f;">
                            {{-- KOREKSI UTAMA: Menggunakan $loop->iteration untuk nomor urut --}}
                            <td>{{ $loop->iteration }}</td> 
                            
                            <td>{{ $tendik->name }}</td>
                            <td>{{ $tendik->email }}</td>
                            <td>********</td> 
                            <td class="d-flex justify-content-start">
                                <a href="{{ route('admin.tendik.edit', $tendik) }}" class="btn btn-sm text-white me-2" style="background-color: #ffc107;">Edit</a>
                                <form action="{{ route('admin.tendik.destroy', $tendik) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    {{-- Menggunakan $tendik->id untuk rute destroy meskipun kolom ID menggunakan nomor urut --}}
                                    <button type="submit" class="btn btn-sm text-white" style="background-color: #dc3545;" onclick="return confirm('Yakin menghapus akun ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-white-50">Belum ada akun Tenaga Pendidik terdaftar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection