<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // ...
    public function up(): void
    {
        Schema::create('dosens', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dosen');
            $table->string('nidn')->unique(); // Nomor Induk Dosen Nasional
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Yang menginput (Tendik)
            $table->timestamps();
        });
    }
    // ...

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};
