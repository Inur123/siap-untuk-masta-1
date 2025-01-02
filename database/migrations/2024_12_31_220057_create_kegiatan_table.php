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
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();  // default adalah bigint unsigned
            $table->string('nama_kegiatan');
            $table->date('tanggal');
            $table->timestamps();
        });

        // Menetapkan engine InnoDB untuk mendukung foreign key
        DB::statement('ALTER TABLE kegiatan ENGINE = InnoDB');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan');
    }
};
