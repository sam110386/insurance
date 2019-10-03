<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LeadAssignmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_assignments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lead_id');
            $table->integer('group_id')->nullable();
            $table->integer('associate_id')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('lead_assignments');
    }
}
