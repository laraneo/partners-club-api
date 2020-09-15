<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('person_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->integer('status')->nullable();
            $table->bigInteger('people_id')->nullable();
            $table->bigInteger('activity_id')->nullable();
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
        Schema::dropIfExists('people_activities');
    }
}
