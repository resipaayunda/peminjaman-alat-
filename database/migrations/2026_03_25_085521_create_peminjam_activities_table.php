<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('peminjam_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjam_id')->constrained('users')->onDelete('cascade');
            $table->string('action');
            $table->string('model')->nullable();
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('peminjam_activities');
    }
};