<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_images', function (Blueprint $table) {
            $table->unsignedInteger('book_id');
            $table->unsignedInteger('image_id');
            $table->foreign('image_id')->references('id')->on('images')->onDelete('CASCADE');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_images');
    }
}
