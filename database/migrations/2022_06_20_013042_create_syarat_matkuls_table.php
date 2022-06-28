<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyaratMatkulsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syarat_matkuls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('syarat_prodi_id');
            $table->string('kodemk');
            $table->enum('status', ['selesai', 'penawaran']);
            $table->timestamps();

            $table->foreign('syarat_prodi_id')->references('id')->on('syarat_prodis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('syarat_matkuls');
    }
}
