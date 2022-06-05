<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterTahunAjarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_tahun_ajars', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->enum('semester',['Ganjil','Genap']);
            $table->string('sebutan',100);
            $table->string('kode',100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_tahun_ajars');
    }
}
