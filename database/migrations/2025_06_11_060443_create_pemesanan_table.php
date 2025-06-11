<?php
// database/migrations/xxxx_xx_xx_create_pemesanan_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking', 20)->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('alat_id')->constrained('alat_berat')->onDelete('cascade');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('durasi_hari');
            $table->decimal('harga_per_hari', 12, 2);
            $table->decimal('total_harga', 12, 2);
            $table->text('lokasi_penggunaan');
            $table->text('catatan')->nullable();
            $table->enum('status_pemesanan', ['pending', 'dikonfirmasi', 'berlangsung', 'selesai', 'dibatalkan'])->default('pending');
            $table->string('contact_admin', 20)->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'status_pemesanan']);
            $table->index(['alat_id', 'tanggal_mulai', 'tanggal_selesai']);
            $table->index('kode_booking');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pemesanan');
    }
};