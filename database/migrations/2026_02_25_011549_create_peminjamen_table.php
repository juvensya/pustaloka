<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('peminjamen', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('buku_id')->constrained()->onDelete('cascade');

        $table->date('tanggal_pinjam')->nullable();
        $table->date('tanggal_kembali')->nullable();
        $table->date('tanggal_dikembalikan')->nullable(); // TAMBAHAN INI

        $table->enum('status', [
            'menunggu',
            'disetujui',
            'ditolak',
            'dikembalikan',
            'terlambat'
        ])->default('menunggu');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
