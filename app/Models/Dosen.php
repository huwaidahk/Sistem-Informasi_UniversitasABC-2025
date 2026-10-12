<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $fillable = ['nama_dosen', 'nidn', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // KOREKSI: Pastikan nama tabel pivot dan kunci asing dieksplisitkan
    public function mataKuliahs()
    {
        // Parameter 1: Nama Model yang dituju
        // Parameter 2: Nama tabel pivot
        // Parameter 3: Kunci FK dari model ini di tabel pivot
        // Parameter 4: Kunci FK dari model lain di tabel pivot
        return $this->belongsToMany(MataKuliah::class, 'dosen_mata_kuliah', 'dosen_id', 'mata_kuliah_id');
    }
}