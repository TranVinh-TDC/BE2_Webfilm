<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkTrailersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_trailers', function (Blueprint $table) {
            $table->id();
            $table->integer('film_id');
            $table->text('name');
            $table->timestamps();

            $table->foreign('film_id')
            ->references('id')
            ->on('films')
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
        Schema::dropIfExists('link_trailers');
    }
}
