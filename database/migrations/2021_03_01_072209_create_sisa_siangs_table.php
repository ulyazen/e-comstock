<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSisaSiangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sisa_siangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pasien')->constrained('pasiens');
            $table->tinyInteger('makanan_pokok');
            $table->tinyInteger('lauk_hewani');
            $table->tinyInteger('lauk_nabati');
            $table->tinyInteger('sayur');
            $table->tinyInteger('buah');
            $table->tinyInteger('minum');
            $table->tinyInteger('snack');
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
        Schema::dropIfExists('sisa_siangs');
    }
}
