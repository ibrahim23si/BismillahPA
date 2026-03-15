<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timbangan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_urut'); // dari kolom A di excel
            $table->string('hari');
            $table->date('tanggal');
            $table->string('nomor_tiket');
            $table->string('nopol');
            $table->string('transporter');
            $table->string('nama_customer');
            $table->string('nama_barang');
            $table->decimal('gross', 10, 2);
            $table->decimal('tara', 10, 2);
            $table->decimal('netto', 10, 2); // gross - tara
            $table->boolean('status_jual')->default(false); // 1=jual, 0=lainnya
            $table->string('keterangan_lain')->nullable();
            $table->decimal('harga_satuan', 15, 2)->nullable();
            $table->decimal('total_harga', 15, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            $table->index('tanggal');
            $table->index('nopol');
            $table->index('nomor_tiket')->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timbangan');
    }
};