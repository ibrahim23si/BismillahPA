<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jual_material', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_transaksi')->unique(); // otomatis digenerate
            $table->string('nomor_urut');
            $table->integer('hari');
            $table->date('tanggal');
            $table->string('nomor_tiket');
            $table->string('nopol');
            $table->string('transporter');
            $table->string('nama_customer');
            $table->string('nama_barang');
            $table->decimal('gross', 10, 2);
            $table->decimal('tara', 10, 2);
            $table->decimal('netto', 10, 2);
            $table->decimal('total_per_hari', 10, 2)->nullable();
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('total_harga', 15, 2);
            
            // Informasi pembayaran
            $table->enum('jenis_bayar', ['cash', 'invoice'])->default('cash');
            
            // Untuk invoice/piutang
            $table->string('nomor_bmk')->nullable();
            $table->date('tanggal_bmk')->nullable();
            $table->decimal('nominal_bmk', 15, 2)->nullable();
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->decimal('nominal_tempo', 15, 2)->nullable();
            
            // Status approval
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->text('catatan_reject')->nullable();
            
            $table->timestamps();
            
            $table->index('tanggal');
            $table->index('status');
            $table->index('nomor_tiket')->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jual_material');
    }
};