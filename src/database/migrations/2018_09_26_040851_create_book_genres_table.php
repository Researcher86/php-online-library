<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_genres', function (Blueprint $table) {
            $table->unsignedInteger('book_id');
            $table->unsignedInteger('genre_id');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('CASCADE');
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('CASCADE');
            $table->unique(['book_id', 'genre_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_genres');
    }
}
