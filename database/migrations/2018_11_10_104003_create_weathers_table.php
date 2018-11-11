<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeathersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weathers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('summary')->default(0);
            $table->string('icon')->default(0);
            $table->string('precipType')->default('N/A');
            $table->string('locationName')->default(0);
            $table->string('apiClass')->default(0);
            $table->string('location')->default(0);
            $table->string('humidity')->default('N/A');
            $table->string('windSpeed')->default('N/A');
            $table->integer('temperature')->default(0);
            $table->integer('temperatureMin')->default(0);
            $table->boolean('current')->default(0);
            $table->integer('time')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weathers');
    }
}
