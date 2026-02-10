<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->id();
            $table->string('nama_peminjam'); // siapa peminjam
            $table->string('barang'); // barang yang dipinjam
            $table->date('tanggal_pinjam');
            $table->date('jatuh_tempo');
            $table->enum('status', ['dipinjam', 'terlambat', 'kembali'])->default('dipinjam');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
