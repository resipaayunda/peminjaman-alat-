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
        Schema::create('petugas_activities', function (Blueprint $table) {
        $table->id();
        $table->foreignId('petugas_id')->constrained('users')->onDelete('cascade');
        $table->string('action')->nullable(); // create, update, dll
        $table->string('model')->nullable(); // modul (peminjaman, dll)
        $table->text('description')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petugas_activities');
    }
};
