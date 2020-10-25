<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemImageColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_image_colors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id')->comment('商品ID');
            $table->unsignedBigInteger('item_image_id')->comment('商品画像ID');
            $table->string('color')->comment('色'); // `red`, `blue`, `green` ...
            $table->timestamps();

            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('item_image_id')->references('id')->on('item_images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_image_colors');
    }
}
