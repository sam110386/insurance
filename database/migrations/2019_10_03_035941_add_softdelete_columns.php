<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftdeleteColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->softDeletes(); 
        });
        Schema::table('notes', function (Blueprint $table) {
            $table->softDeletes(); 
        });
        Schema::table('leads', function (Blueprint $table) {
            $table->softDeletes(); 
        });
        Schema::table('vehicles', function (Blueprint $table) {
            $table->softDeletes(); 
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
