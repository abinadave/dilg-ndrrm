<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRescueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rescues', function (Blueprint $table) {
            $table->string('rescue_team')->nullable();
            $table->string('rescue_capability')->nullable();
            $table->string('hotline_no')->nullable();
            $table->string('team_leader')->nullable();
            $table->integer('man_power')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rescues');
    }
}
