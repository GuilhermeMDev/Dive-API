<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration

{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_dive_intervals', function (Blueprint $table) {

            $table->id();
            $table->string('groupLetter');
            $table->integer('minTime');
            $table->integer('maxTime');
            $table->string('repetLetter');
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
        Schema::dropIfExists('data_dive_interval');

    }
};
