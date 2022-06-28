<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePplLokasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppl_lokasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ppl_id');
            $table->string('lokasi', 250);
            $table->string('alamat', 250);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('ppl_id')->references('id')->on('ppls')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ppl_lokasis');
    }
}
