<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tiket');
            $table->text('deskripsi');
            $table->unsignedBigInteger('harga');
            $table->unsignedInteger('stok');
            $table->dateTime('tanggal_konser');
            $table->string('lokasi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};