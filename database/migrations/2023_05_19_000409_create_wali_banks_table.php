<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wali_banks', function (Blueprint $table) {
            $table->id();
            $table->string('wali_id', 50)->comment('wali_id adalah primary key di user id');
            $table->string('kode', 50);
            $table->string('nama_bank', 30);
            $table->string('nama_rekening', 30);
            $table->string('nomor_rekening', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wali_banks');
    }
};
