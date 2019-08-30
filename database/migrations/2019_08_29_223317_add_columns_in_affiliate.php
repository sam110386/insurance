<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInAffiliate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('affiliate', function (Blueprint $table) {
            $table->string('phone');
            $table->string('email');
            $table->string('campaign');
            $table->float('payout_amount',8,2);
            $table->string('postback_url');
            $table->boolean('s1')->default(0);
            $table->boolean('s2')->default(0);
            $table->boolean('s3')->default(0);
            $table->boolean('s4')->default(0);
            $table->boolean('s5')->default(0);
            $table->string('s1_value')->nullable();
            $table->string('s2_value')->nullable();
            $table->string('s3_value')->nullable();
            $table->string('s4_value')->nullable();
            $table->string('s5_value')->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('affiliate', function (Blueprint $table) {
            //
        });
    }
}
