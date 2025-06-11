<?php
// database/migrations/xxxx_xx_xx_create_kategori_alat_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kategori_alat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori', 100);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            
            $table->index('nama_kategori');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kategori_alat');
    }
};