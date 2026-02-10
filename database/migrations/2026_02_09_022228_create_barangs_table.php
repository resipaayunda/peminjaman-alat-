<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Nama barang (contoh: Laptop, Proyektor)
            $table->string('kode')->unique(); // Kode barang (contoh: BRG-001)
            $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->onDelete('set null'); // Kategori barang
            $table->integer('stok')->default(0); // Jumlah stok
            $table->text('deskripsi')->nullable(); // Deskripsi barang
            $table->enum('kondisi', ['baik', 'rusak ringan', 'rusak berat'])->default('baik'); // Kondisi barang
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};