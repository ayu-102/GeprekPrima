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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pembeli');
            $table->integer('total_harga');
            $table->string('metode_bayar');
            $table->enum('status', ['pending', 'proses', 'lunas', 'dibatalkan'])->default('pending');
            $table->integer('uang_bayar')->default(0);
            $table->integer('kembalian')->default(0);
            $table->text('catatan')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->string('nama_pengirim')->nullable();
            $table->string('id_transaksi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
