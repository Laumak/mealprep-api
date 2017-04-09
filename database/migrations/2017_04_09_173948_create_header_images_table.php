<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeaderImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('header_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string("url");
            $table->integer("meal_id")->unsigned();
            $table->timestamps();

            $table->foreign("meal_id")
                  ->references("id")->on("meals")
                  ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('header_images');
    }
}
