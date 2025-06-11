<?php
// database/migrations/xxxx_xx_xx_create_pembayaran_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id')->constrained('pemesanan')->onDelete('cascade');
            $table->enum('metode_pembayaran', ['upload_transfer', 'whatsapp_confirm']);
            $table->string('bukti_transfer')->nullable();
            $table->decimal('jumlah_bayar', 12, 2);
            $table->date('tanggal_bayar');
            $table->enum('status_bayar', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->string('verified_by')->nullable();
            $table->timestamps();
            
            $table->index(['pemesanan_id', 'status_bayar']);
            $table->index('metode_pembayaran');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
};