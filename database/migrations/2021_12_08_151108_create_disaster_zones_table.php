<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisasterZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disaster_zones', function (Blueprint $table) {
            $table->id();
            $table->string('source_name');
            $table->string('source_link');
            $table->string('location_accuracy');
            $table->string('landslide_size');
            $table->string('country_name');
            $table->string('longitude');
            $table->string('latitude');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disaster_zones');
    }
}
