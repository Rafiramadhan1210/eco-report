<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tindak_lanjut', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporan')->cascadeOnDelete();
            $table->foreignId('pengurus_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status_baru', ['Diproses', 'Selesai', 'Ditolak']);
            $table->text('catatan');
            $table->string('foto_bukti')->nullable();
            $table->timestamp('tanggal_tindak')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tindak_lanjut');
    }
};
