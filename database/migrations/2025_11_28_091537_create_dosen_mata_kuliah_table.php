<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pastikan nama tabel adalah 'dosen_mata_kuliah' (sesuai Model Anda)
        Schema::create('dosen_mata_kuliah', function (Blueprint $table) { 
            $table->id();
            // Foreign Key ke tabel 'dosens'
            $table->foreignId('dosen_id')->constrained('dosens')->onDelete('cascade');
            // Foreign Key ke tabel 'mata_kuliahs'
            $table->foreignId('mata_kuliah_id')->constrained('mata_kuliahs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosen_mata_kuliah');
    }
};