{{-- resources/views/admin/tendik/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Tendik')

@section('content')
    <h1 class="display-4 fw-bold mb-4" style="color: #581da4ff;">Menu Data Tendik</h1>

    <div class="card p-5 border-0" style="background-color: #31065f; border-radius: 15px;">
        <h4 class="text-white mb-4">Edit Tendik</h4>
        <form method="POST" action="{{ route('admin.tendik.update', $tendik) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="id" class="form-label text-white">ID</label>
                <input type="text" class="form-control form-control-custom" value="{{ $tendik->id }}" disabled>
            </div>
            
            <div class="mb-4">
                <label for="name" class="form-label text-white">Nama</label>
                <input type="text" name="name" id="name" class="form-control form-control-custom" value="{{ old('name', $tendik->name) }}" required>
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
            {{-- Jabatan dihapus --}}

            <div class="mb-4">
                <label for="email" class="form-label text-white">Username (Email)</label>
                <input type="email" name="email" id="email" class="form-control form-control-custom" value="{{ old('email', $tendik->email) }}" required>
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
            <div class="mb-4">
                <label for="password" class="form-label text-white">Password</label>
                <input type="password" name="password" id="password" class="form-control form-control-custom" placeholder="Kosongkan jika tidak ingin diubah">
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label text-white">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-custom">
            </div>
            
            <button type="submit" class="btn btn-success me-2" style="background-color: #198754; border-color: #198754;">Perbarui</button>
            <a href="{{ route('admin.tendik.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection