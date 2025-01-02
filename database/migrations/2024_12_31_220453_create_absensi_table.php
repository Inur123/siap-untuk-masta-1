<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();  // default adalah bigint unsigned
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->onDelete('cascade'); // Menyambungkan dengan tabel 'kegiatan'
            $table->enum('status', ['hadir', 'tidak_hadir', 'izin']);
            $table->timestamps();
        });

        // Menetapkan engine InnoDB untuk mendukung foreign key
        DB::statement('ALTER TABLE absensi ENGINE = InnoDB');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
