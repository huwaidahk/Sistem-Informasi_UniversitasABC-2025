{{-- resources/views/admin/data/dosen/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Data Dosen')

@section('content')
    <h1 class="display-4 fw-bold mb-4" style="color: #581da4ff;">Menu Data Dosen</h1>

    <div class="card p-5 border-0" style="background-color: #31065f; border-radius: 15px;">
        <h4 class="text-white mb-4">Tambah Dosen</h4>
        <form method="POST" action="{{ route('admin.dosen.store') }}">
            @csrf
            
            <div class="mb-4">
                <label for="nidn" class="form-label text-white">NIDN</label>
                <input type="text" name="nidn" id="nidn" class="form-control form-control-custom" 
                       value="{{ old('nidn') }}" required maxlength="10">
                @error('nidn') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="nama_dosen" class="form-label text-white">Nama</label>
                <input type="text" name="nama_dosen" id="nama_dosen" class="form-control form-control-custom" 
                       value="{{ old('nama_dosen') }}" required>
                @error('nama_dosen') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            {{-- BLOK MATA KULIAH DIAMPU DIHAPUS DARI SINI --}}
            
            <div class="mb-4">
                <label for="user_id" class="form-label text-white">Tendik Input</label>
                <select name="user_id" id="user_id" class="form-select form-control-custom" required>
                    <option value="">-- Pilih Tendik yang Menginput --</option>
                    @foreach ($tendiks as $tendik)
                        <option value="{{ $tendik->id }}" {{ old('user_id') == $tendik->id ? 'selected' : '' }}>
                            {{ $tendik->name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-success me-2">Simpan</button>
            <a href="{{ route('admin.dosen.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection