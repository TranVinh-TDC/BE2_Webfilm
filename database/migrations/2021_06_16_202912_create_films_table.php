<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('original_name');
            $table->text('description');
            $table->string('status');
            $table->string('director');
            $table->text('actor');
            $table->integer('type_id');
            $table->integer('nation_id');
            $table->timestamp('published');
            $table->integer('views');
            $table->string('image');
            $table->decimal('imdb')->default(random_int(1, 9));
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('type_id')
            ->references('id')
            ->on('types')
            ->onDelete('cascade');

            $table->foreign('nation_id')
            ->references('id')
            ->on('nations')
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
        Schema::dropIfExists('films');
    }
}
