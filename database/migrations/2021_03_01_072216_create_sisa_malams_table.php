<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSisaMalamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sisa_malams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pasien')->constrained('pasiens');
            $table->tinyInteger('makanan_pokok')->nullable();;
            $table->tinyInteger('lauk_hewani')->nullable();;
            $table->tinyInteger('lauk_nabati')->nullable();;
            $table->tinyInteger('sayur')->nullable();;
            $table->tinyInteger('buah')->nullable();;
            $table->tinyInteger('snack')->nullable();;
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
        Schema::dropIfExists('sisa_malams');
    }
}
