<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('street');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('phone');
            $table->string('email');
            $table->boolean('married')->default(0);
            $table->boolean('children')->default(0);
            $table->string('homeowner');
            $table->boolean('bundled')->default(0);
            $table->string('first_driver_first_name');
            $table->string('first_driver_last_name');
            $table->date('first_driver_dob');
            $table->string('first_driver_gender');
            $table->string('first_driver_dl');
            $table->string('first_driver_state');
            $table->string('second_driver_first_name')->nullable();
            $table->string('second_driver_last_name')->nullable();
            $table->date('second_driver_dob')->nullable();
            $table->string('second_driver_gender')->nullable();
            $table->string('second_driver_dl')->nullable();
            $table->string('second_driver_state')->nullable();
            $table->string('third_driver_first_name')->nullable();
            $table->string('third_driver_last_name')->nullable();
            $table->date('third_driver_dob')->nullable();
            $table->string('third_driver_gender')->nullable();
            $table->string('third_driver_dl')->nullable();
            $table->string('third_driver_state')->nullable();
            $table->string('fourth_driver_first_name')->nullable();
            $table->string('fourth_driver_last_name')->nullable();
            $table->date('fourth_driver_dob')->nullable();
            $table->string('fourth_driver_gender')->nullable();
            $table->string('fourth_driver_dl')->nullable();
            $table->string('fourth_driver_state')->nullable();
            $table->string('fifth_driver_first_name')->nullable();
            $table->string('fifth_driver_last_name')->nullable();
            $table->date('fifth_driver_dob')->nullable();
            $table->string('fifth_driver_gender')->nullable();
            $table->string('fifth_driver_dl')->nullable();
            $table->string('fifth_driver_state')->nullable();
            $table->integer('first_vehicle_year');
            $table->string('first_vehicle_make');
            $table->string('first_vehicle_model');
            $table->string('first_vehicle_trim');
            $table->string('first_vehicle_vin');
            $table->string('first_vehicle_owenership');
            $table->string('first_vehicle_uses');
            $table->string('first_vehicle_mileage');
            $table->integer('second_vehicle_year')->nullable();
            $table->string('second_vehicle_make')->nullable();
            $table->string('second_vehicle_model')->nullable();
            $table->string('second_vehicle_trim')->nullable();
            $table->string('second_vehicle_vin')->nullable();
            $table->string('second_vehicle_owenership')->nullable();
            $table->string('second_vehicle_uses')->nullable();
            $table->string('second_vehicle_mileage')->nullable();
            $table->integer('third_vehicle_year')->nullable();
            $table->string('third_vehicle_make')->nullable();
            $table->string('third_vehicle_model')->nullable();
            $table->string('third_vehicle_trim')->nullable();
            $table->string('third_vehicle_vin')->nullable();
            $table->string('third_vehicle_owenership')->nullable();
            $table->string('third_vehicle_uses')->nullable();
            $table->string('third_vehicle_mileage')->nullable();
            $table->integer('fourth_vehicle_year')->nullable();
            $table->string('fourth_vehicle_make')->nullable();
            $table->string('fourth_vehicle_model')->nullable();
            $table->string('fourth_vehicle_trim')->nullable();
            $table->string('fourth_vehicle_vin')->nullable();
            $table->string('fourth_vehicle_owenership')->nullable();
            $table->string('fourth_vehicle_uses')->nullable();
            $table->string('fourth_vehicle_mileage')->nullable();
            $table->integer('fifth_vehicle_year')->nullable();
            $table->string('fifth_vehicle_make')->nullable();
            $table->string('fifth_vehicle_model')->nullable();
            $table->string('fifth_vehicle_trim')->nullable();
            $table->string('fifth_vehicle_vin')->nullable();
            $table->string('fifth_vehicle_owenership')->nullable();
            $table->string('fifth_vehicle_uses')->nullable();
            $table->string('fifth_vehicle_mileage')->nullable();
            $table->string('liability')->nullable();
            $table->string('body_injury')->nullable();
            $table->string('deduct')->nullable();
            $table->string('medical')->nullable();
            $table->boolean('towing')->default(0);
            $table->boolean('uninsured')->default(0);
            $table->boolean('rental')->default(0);
            $table->boolean('previous_insurance')->default(0);
            $table->string('current_insurance')->nullable();
            $table->string('duration')->nullable();
            $table->boolean('at_fault')->default(0);
            $table->boolean('tickets')->default(0);
            $table->boolean('dui')->default(0);
            $table->string('quality_provides')->nullable();
            $table->boolean('agent_in_person')->default(0);
            $table->string('referrer')->nullable();
            $table->string('referrer_name')->nullable();
            $table->string('ip_address');
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
        Schema::dropIfExists('leads');
    }
}
