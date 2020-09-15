<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmissionStepsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('admission_steps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description',255)->nullable();
            $table->integer('order')->nullable();
            $table->integer('status')->nullable();
            $table->bigInteger('admission_phase_id')->nullable();
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
        Schema::dropIfExists('admission_steps');
    }
}
