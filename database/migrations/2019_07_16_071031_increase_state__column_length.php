<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IncreaseStateColumnLength extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('first_driver_state',30)->change(); 
            $table->string('second_driver_state',30)->nullable()->change();
            $table->string('third_driver_state',30)->nullable()->change();
            $table->string('fourth_driver_state',30)->nullable()->change();
            $table->string('fifth_driver_state',30)->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            //
        });
    }
}
