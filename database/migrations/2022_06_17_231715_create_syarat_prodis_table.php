<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyaratProdisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syarat_prodis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ppl_id');
            $table->string('prodi_id');
            $table->integer('sks')->default(0);
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
        Schema::dropIfExists('syarat_prodis');
    }
}
