{{-- resources/views/tendik/data/dosen/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Data Dosen')

@section('content')
    <h1 class="display-4 fw-bold mb-4" style="color: #581da4ff;">Menu Data Dosen</h1>

    <div class="card p-5 border-0" style="background-color: #31065f; border-radius: 15px;">
        <h4 class="text-white mb-4">Tambah Dosen</h4>
        <form method="POST" action="{{ route('tendik.dosen.store') }}">
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
            {{-- Blok yang dihapus adalah:
            <div class="mb-4">
                <label for="mata_kuliahs" class="form-label text-white">Mata Kuliah Diampu</label>
                <select name="mata_kuliahs[]" id="mata_kuliahs" class="form-select form-control-custom" multiple>
                    @foreach ($mataKuliahs as $matkul)
                        <option value="{{ $matkul->id }}" {{ in_array($matkul->id, old('mata_kuliahs', [])) ? 'selected' : '' }}>
                            {{ $matkul->nama_matkul }}
                        </option>
                    @endforeach
                </select>
                @error('mata_kuliahs') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            --}}

            {{-- Kolom Tendik Input tidak perlu di-select, karena otomatis dari Auth::id() di Controller --}}
            <div class="mb-4">
                <label class="form-label text-white">Tendik Input</label>
                {{-- Hanya menampilkan nama tendik yang sedang login --}}
                <input type="text" class="form-control form-control-custom" value="{{ Auth::user()->name }}" disabled>
            </div>

            <button type="submit" class="btn btn-success me-2">Simpan</button>
            <a href="{{ route('tendik.dosen.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection