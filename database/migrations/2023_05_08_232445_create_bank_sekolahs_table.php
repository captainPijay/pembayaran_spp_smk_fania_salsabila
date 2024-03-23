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
        Schema::create('bank_sekolahs', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50);
            $table->string('nama_bank', 30);
            $table->string('nama_rekening', 50);
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
        Schema::dropIfExists('bank_sekolahs');
    }
};
