<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePplKelompoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppl_kelompoks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ppl_lokasi_id');
            $table->string('nama_kelompok', 250);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('ppl_lokasi_id')->references('id')->on('ppl_lokasis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ppl_kelompoks');
    }
}
