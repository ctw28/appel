<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePplPendaftarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppl_pendaftars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ppl_id');
            $table->string('iddata', 100);
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
        Schema::dropIfExists('ppl_pendaftars');
    }
}
