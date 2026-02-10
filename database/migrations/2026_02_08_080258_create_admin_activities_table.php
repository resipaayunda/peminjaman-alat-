<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id'); // siapa admin yang melakukan
            $table->string('action'); // aksi (create, update, delete, login, dsb)
            $table->string('model')->nullable(); // model / entitas terkait
            $table->text('description')->nullable(); // keterangan lebih detail
            $table->timestamps();

            // foreign key ke users
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_activities');
    }
};
