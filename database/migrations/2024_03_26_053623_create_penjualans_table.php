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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('tanggal');
            $table->integer('qty');
            $table->unsignedBigInteger('setoran');
            $table->unsignedBigInteger('keuntungan');
            $table->unsignedBigInteger('insentif');
            $table->unsignedBigInteger('pemasukan');
            $table->enum('status', ['0', '1', '2', '3'])->default('0');
            $table->enum('insentif_status', ['0', '1', '2', '3'])->default('0');
            $table->dateTime('status_time')->nullable();
            $table->dateTime('insentif_time')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
