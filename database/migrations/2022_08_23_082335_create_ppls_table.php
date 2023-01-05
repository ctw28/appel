<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePplsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kuliah_lapangan_id');
            $table->unsignedBigInteger('master_fakultas_id');
            $table->timestamps();

            $table->foreign('kuliah_lapangan_id')->references('id')->on('kuliah_lapangans')->onDelete('cascade');
            $table->foreign('master_fakultas_id')->references('id')->on('master_fakultas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ppls');
    }
}
