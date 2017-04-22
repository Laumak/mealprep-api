<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDayMealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_meal', function (Blueprint $table) {
            $table->string('type');

            $table->unsignedInteger('day_id');
            $table->foreign('day_id')
                  ->references('id')->on('days');

            $table->unsignedInteger('meal_id');
            $table->foreign('meal_id')
                  ->references('id')->on('meals');

            $table->primary([ 'type', 'day_id' ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('day_meal');
    }
}
