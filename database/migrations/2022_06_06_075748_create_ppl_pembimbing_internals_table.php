<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePplPembimbingInternalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppl_pembimbing_internals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ppl_id');
            $table->string('idpeg', 100);
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
        Schema::dropIfExists('ppl_pembimbing_internals');
    }
}
