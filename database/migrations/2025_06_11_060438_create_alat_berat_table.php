<?php
// database/migrations/xxxx_xx_xx_create_alat_berat_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('alat_berat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori_alat')->onDelete('cascade');
            $table->string('nama_alat', 150);
            $table->string('merk', 100);
            $table->string('model', 100)->nullable();
            $table->decimal('harga_per_hari', 12, 2);
            $table->string('foto_utama')->nullable();
            $table->text('spesifikasi')->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['tersedia', 'disewa', 'maintenance'])->default('tersedia');
            $table->timestamps();
            
            $table->index(['kategori_id', 'status']);
            $table->index('nama_alat');
        });
    }

    public function down()
    {
        Schema::dropIfExists('alat_berat');
    }
};