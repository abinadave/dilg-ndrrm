<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->string('facility_category')->nullable();
            $table->string('facility_description')->nullable();
            $table->string('location')->nullable();
            $table->integer('total_facility')->nullable();
            $table->string('person_responsible')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('landline_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facilities');
    }
}
