<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->integer("loans_package_id");
            $table->bigInteger("loan");
            $table->date("duration");
            $table->integer("frequency");
            $table->double("interest_rate");
            $table->integer("fee");
            $table->tinyInteger("status");
            $table->integer("payment_period");
            $table->double("total");
            $table->double("remain");
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
        Schema::dropIfExists('loans');
    }
}
