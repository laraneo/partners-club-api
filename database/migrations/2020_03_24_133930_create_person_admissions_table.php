<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('person_admissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('comments', 255)->nullable();
            $table->integer('status')->nullable();
            $table->string('attachment1', 255)->nullable();
            $table->string('descriptionAttachment1', 255)->nullable();
            $table->string('attachment2', 255)->nullable();
            $table->string('descriptionAttachment2', 255)->nullable();
            $table->string('attachment3', 255)->nullable();
            $table->string('descriptionAttachment3', 255)->nullable();
            $table->string('attachment4', 255)->nullable();
            $table->string('descriptionAttachment4', 255)->nullable();
            $table->string('attachment5', 255)->nullable();
            $table->string('descriptionAttachment5', 255)->nullable();
            $table->integer('user_verified')->nullable();
            $table->integer('date_verified')->nullable();
            $table->bigInteger('admission_id')->nullable();
            $table->bigInteger('admission_step_id')->nullable();
            $table->bigInteger('people_id')->nullable();
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
        Schema::dropIfExists('person_admissions');
    }
}
