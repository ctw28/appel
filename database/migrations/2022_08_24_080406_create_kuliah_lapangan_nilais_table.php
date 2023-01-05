<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuliahLapanganNilaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuliah_lapangan_nilais', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelompok_anggota_id');
            $table->double('nilai');
            $table->enum('sumber_nilai', ['internal', 'eksternal']);
            $table->timestamps();
            $table->foreign('kelompok_anggota_id')->references('id')->on('kuliah_lapangan_kelompok_anggotas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kuliah_lapangan_nilais');
    }
}
