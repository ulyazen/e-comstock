<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSisasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sisas', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('nilai');
            $table->enum('jenis_makanan', ['Makanan Pokok', 'Lauk Hewani', 'Lauk Nabati', 'Sayur', 'Buah', 'Minum', 'Snack']);
            $table->enum('waktu', ['Pagi', 'Siang', 'Malam']);
            $table->foreignId('id_pasien')->constrained('pasiens');
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
        Schema::dropIfExists('sisas');
    }
}
