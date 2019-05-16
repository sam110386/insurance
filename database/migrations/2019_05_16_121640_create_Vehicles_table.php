<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('year');
            $table->string('make');
            $table->string('model');
            $table->string('trim_1')->comment('New Trim')->nullable();
            $table->string('trim_2')->comment('Old Trim')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Vehicles');
    }
}
