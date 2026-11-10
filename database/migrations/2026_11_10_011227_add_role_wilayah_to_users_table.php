<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['warga', 'pengurus', 'admin'])->default('warga')->after('password');
            $table->string('no_hp')->nullable()->after('role');
            $table->foreignId('wilayah_id')->nullable()->after('no_hp')
                ->constrained('wilayah')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('wilayah_id');
            $table->dropColumn(['role', 'no_hp']);
        });
    }
};