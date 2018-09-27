<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_authors', function (Blueprint $table) {
            $table->unsignedInteger('book_id');
            $table->unsignedInteger('author_id');
            $table->primary(['book_id', 'author_id']);
            $table->foreign('book_id')->references('id')->on('books')->onDelete('CASCADE');
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_authors');
    }
}
