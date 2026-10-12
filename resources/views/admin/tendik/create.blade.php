{{-- resources/views/admin/tendik/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Tendik')

@section('content')
    <h1 class="display-4 fw-bold mb-4" style="color: #581da4ff;">Menu Data Tendik</h1>

    <div class="card p-5 border-0" style="background-color: #31065f; border-radius: 15px;">
        <h4 class="text-white mb-4">Tambah Tendik</h4>
        <form method="POST" action="{{ route('admin.tendik.store') }}">
            @csrf
            
            <div class="mb-4">
                <label for="id" class="form-label text-white">ID</label>
                <input type="text" class="form-control form-control-custom" disabled placeholder="Akan dibuat otomatis">
            </div>
            
            <div class="mb-4">
                <label for="name" class="form-label text-white">Nama</label>
                <input type="text" name="name" id="name" class="form-control form-control-custom" value="{{ old('name') }}" required>
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
            {{-- Jabatan dihapus --}}

            <div class="mb-4">
                <label for="email" class="form-label text-white">Username (Email)</label>
                <input type="email" name="email" id="email" class="form-control form-control-custom" placeholder="contoh@universitasabc.ac.id" value="{{ old('email') }}" required>
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
            <div class="mb-4">
                <label for="password" class="form-label text-white">Password</label>
                <input type="password" name="password" id="password" class="form-control form-control-custom" required>
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label text-white">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-custom" required>
            </div>
            
            <button type="submit" class="btn btn-success me-2" style="background-color: #198754; border-color: #198754;">Simpan</button>
            <a href="{{ route('admin.tendik.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection