<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePplPembimbingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppl_pembimbings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ppl_kelompok_id');
            $table->unsignedBigInteger('pembimbing_internal_id')->nullable();
            $table->unsignedBigInteger('pembimbing_eksternal_id')->nullable();
            $table->timestamps();

            $table->foreign('ppl_kelompok_id')->references('id')->on('ppl_kelompoks')->onDelete('cascade');
            $table->foreign('pembimbing_internal_id')->references('id')->on('ppl_pembimbing_internals')->onDelete('set null');
            // $table->foreign('pembimbing_eksternal_id')->references('id')->on('ppl_kelompoks'); //belum fix
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ppl_pembimbings');
    }
}
