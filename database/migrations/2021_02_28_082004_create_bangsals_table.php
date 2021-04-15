<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBangsalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bangsals', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('siklus', ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11']);
            $table->date('tanggal');
            $table->timestamps();
            $table->foreignId('id_user')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bangsals');
    }
}
