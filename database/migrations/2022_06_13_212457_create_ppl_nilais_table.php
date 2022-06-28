<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePplNilaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppl_nilais', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ppl_kelompok_anggota_id');
            $table->double('nilai');
            $table->enum('sumber_nilai', ['internal', 'eksternal']);
            $table->timestamps();
            $table->foreign('ppl_kelompok_anggota_id')->references('id')->on('ppl_kelompok_anggotas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ppl_nilais');
    }
}
