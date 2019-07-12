<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreVehicleColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->smallInteger('sixth_vehicle_year')->nullable();
            $table->string('sixth_vehicle_make',100)->nullable();
            $table->string('sixth_vehicle_model',100)->nullable();
            $table->string('sixth_vehicle_trim',100)->nullable();
            $table->string('sixth_vehicle_vin',15)->nullable();
            $table->string('sixth_vehicle_owenership',15)->nullable();
            $table->string('sixth_vehicle_uses',15)->nullable();
            $table->string('sixth_vehicle_mileage',25)->nullable();
            $table->smallInteger('seventh_vehicle_year')->nullable();
            $table->string('seventh_vehicle_make',100)->nullable();
            $table->string('seventh_vehicle_model',100)->nullable();
            $table->string('seventh_vehicle_trim',100)->nullable();
            $table->string('seventh_vehicle_vin',15)->nullable();
            $table->string('seventh_vehicle_owenership',15)->nullable();
            $table->string('seventh_vehicle_uses',15)->nullable();
            $table->string('seventh_vehicle_mileage',25)->nullable();
            $table->smallInteger('eighth_vehicle_year')->nullable();
            $table->string('eighth_vehicle_make',100)->nullable();
            $table->string('eighth_vehicle_model',100)->nullable();
            $table->string('eighth_vehicle_trim',100)->nullable();
            $table->string('eighth_vehicle_vin',15)->nullable();
            $table->string('eighth_vehicle_owenership',15)->nullable();
            $table->string('eighth_vehicle_uses',15)->nullable();
            $table->string('eighth_vehicle_mileage',25)->nullable();
            $table->smallInteger('ninth_vehicle_year')->nullable();
            $table->string('ninth_vehicle_make',100)->nullable();
            $table->string('ninth_vehicle_model',100)->nullable();
            $table->string('ninth_vehicle_trim',100)->nullable();
            $table->string('ninth_vehicle_vin',15)->nullable();
            $table->string('ninth_vehicle_owenership',15)->nullable();
            $table->string('ninth_vehicle_uses',15)->nullable();
            $table->string('ninth_vehicle_mileage',25)->nullable();
            $table->smallInteger('tenth_vehicle_year')->nullable();
            $table->string('tenth_vehicle_make',100)->nullable();
            $table->string('tenth_vehicle_model',100)->nullable();
            $table->string('tenth_vehicle_trim',100)->nullable();
            $table->string('tenth_vehicle_vin',15)->nullable();
            $table->string('tenth_vehicle_owenership',15)->nullable();
            $table->string('tenth_vehicle_uses',15)->nullable();
            $table->string('tenth_vehicle_mileage',25)->nullable();

            //changing size of Int to Sm Int
            $table->string('first_name',50)->change();
            $table->string('last_name',50)->change();
            $table->string('street')->change();
            $table->string('city',25)->change();
            $table->string('state',15)->change();
            $table->string('zip',8)->change();
            $table->string('phone',20)->change();
            $table->string('email',50)->change();
            $table->boolean('married')->default(0)->change();
            $table->boolean('children')->default(0)->change();
            $table->string('homeowner',10)->change();
            $table->boolean('bundled')->default(0)->change();
            $table->string('first_driver_first_name',50)->change();
            $table->string('first_driver_last_name',50)->change();
            $table->date('first_driver_dob')->change();
            $table->string('first_driver_gender',10)->change();
            $table->string('first_driver_dl',15)->change();
            $table->string('first_driver_state',15)->change();
            $table->string('second_driver_first_name',50)->nullable()->change();
            $table->string('second_driver_last_name',50)->nullable()->change();
            $table->date('second_driver_dob')->nullable()->change();
            $table->string('second_driver_gender',10)->nullable()->change();
            $table->string('second_driver_dl',15)->nullable()->change();
            $table->string('second_driver_state',15)->nullable()->change();
            $table->string('third_driver_first_name',50)->nullable()->change();
            $table->string('third_driver_last_name',50)->nullable()->change();
            $table->date('third_driver_dob')->nullable()->change();
            $table->string('third_driver_gender',10)->nullable()->change();
            $table->string('third_driver_dl',15)->nullable()->change();
            $table->string('third_driver_state',15)->nullable()->change();
            $table->string('fourth_driver_first_name',50)->nullable()->change();
            $table->string('fourth_driver_last_name',50)->nullable()->change();
            $table->date('fourth_driver_dob')->nullable()->change();
            $table->string('fourth_driver_gender',10)->nullable()->change();
            $table->string('fourth_driver_dl',15)->nullable()->change();
            $table->string('fourth_driver_state',15)->nullable()->change();
            $table->string('fifth_driver_first_name',50)->nullable()->change();
            $table->string('fifth_driver_last_name',50)->nullable()->change();
            $table->date('fifth_driver_dob')->nullable()->change();
            $table->string('fifth_driver_gender',10)->nullable()->change();
            $table->string('fifth_driver_dl',15)->nullable()->change();
            $table->string('fifth_driver_state',15)->nullable()->change();
            $table->smallInteger('first_vehicle_year')->change();
            $table->string('first_vehicle_make',100)->change();
            $table->string('first_vehicle_model',100)->change();
            $table->string('first_vehicle_trim',100)->change();
            $table->string('first_vehicle_vin',15)->change();
            $table->string('first_vehicle_owenership',15)->change();
            $table->string('first_vehicle_uses',15)->change();
            $table->string('first_vehicle_mileage',25)->change();
            $table->smallInteger('second_vehicle_year')->nullable()->change();
            $table->string('second_vehicle_make',100)->nullable()->change();
            $table->string('second_vehicle_model',100)->nullable()->change();
            $table->string('second_vehicle_trim',100)->nullable()->change();
            $table->string('second_vehicle_vin',15)->nullable()->change();
            $table->string('second_vehicle_owenership',15)->nullable()->change();
            $table->string('second_vehicle_uses',15)->nullable()->change();
            $table->string('second_vehicle_mileage',25)->nullable()->change();
            $table->smallInteger('third_vehicle_year')->nullable()->change();
            $table->string('third_vehicle_make',100)->nullable()->change();
            $table->string('third_vehicle_model',100)->nullable()->change();
            $table->string('third_vehicle_trim',100)->nullable()->change();
            $table->string('third_vehicle_vin',15)->nullable()->change();
            $table->string('third_vehicle_owenership',15)->nullable()->change();
            $table->string('third_vehicle_uses',15)->nullable()->change();
            $table->string('third_vehicle_mileage',25)->nullable()->change();
            $table->smallInteger('fourth_vehicle_year')->nullable()->change();
            $table->string('fourth_vehicle_make',100)->nullable()->change();
            $table->string('fourth_vehicle_model',100)->nullable()->change();
            $table->string('fourth_vehicle_trim',100)->nullable()->change();
            $table->string('fourth_vehicle_vin',15)->nullable()->change();
            $table->string('fourth_vehicle_owenership',15)->nullable()->change();
            $table->string('fourth_vehicle_uses',15)->nullable()->change();
            $table->string('fourth_vehicle_mileage',25)->nullable()->change();
            $table->smallInteger('fifth_vehicle_year')->nullable()->change();
            $table->string('fifth_vehicle_make',100)->nullable()->change();
            $table->string('fifth_vehicle_model',100)->nullable()->change();
            $table->string('fifth_vehicle_trim',100)->nullable()->change();
            $table->string('fifth_vehicle_vin',15)->nullable()->change();
            $table->string('fifth_vehicle_owenership',15)->nullable()->change();
            $table->string('fifth_vehicle_uses',15)->nullable()->change();
            $table->string('fifth_vehicle_mileage',25)->nullable()->change();
            $table->string('liability',10)->nullable()->change();
            $table->string('body_injury',25)->nullable()->change();
            $table->string('deduct',25)->nullable()->change();
            $table->string('medical',25)->nullable()->change();
            $table->boolean('towing')->default(0)->change();
            $table->boolean('uninsured')->default(0)->change();
            $table->boolean('rental')->default(0)->change();
            $table->boolean('previous_insurance')->default(0)->change();
            $table->string('current_insurance',50)->nullable()->change();
            $table->string('duration',25)->nullable()->change();
            $table->boolean('at_fault')->default(0)->change();
            $table->boolean('tickets')->default(0)->change();
            $table->boolean('dui')->default(0)->change();
            $table->string('quality_provides',100)->nullable()->change();
            $table->boolean('agent_in_person')->default(0)->change();
            $table->string('referrer',100)->nullable()->change();
            $table->string('referrer_name',100)->nullable()->change();
            $table->string('ip_address',10)->change();
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
