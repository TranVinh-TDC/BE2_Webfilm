<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCastFilmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cast_film', function (Blueprint $table) {
            $table->id();
            $table->integer('film_id');
            $table->integer('cast_id');
            $table->timestamps();
            $table->foreign('film_id')
                ->references('id')
                ->on('films')
                ->onDelete('cascade');
            $table->foreign('cast_id')
                ->references('id')
                ->on('casts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cast_film');
    }
}
