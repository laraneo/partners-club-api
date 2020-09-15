<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',255)->nullable();
            $table->string('last_name',255)->nullable();
            $table->string('rif_ci',255)->nullable();
            $table->string('passport',255)->nullable();
            $table->string('card_number',255)->nullable();
            $table->date('expiration_date')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('representante', 255)->nullable();
            $table->string('picture', 255)->nullable();
            $table->string('id_card_picture', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('telephone1', 255)->nullable();
            $table->string('telephone2', 255)->nullable();
            $table->string('phone_mobile1', 255)->nullable();
            $table->string('phone_mobile2', 255)->nullable();
            $table->string('primary_email', 255)->nullable();
            $table->string('secondary_email', 255)->nullable();
            $table->string('fax', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('postal_code', 100)->nullable();
            $table->bigInteger('isPartner')->nullable();
            $table->bigInteger('type_person')->nullable();
            $table->bigInteger('company_person_id')->nullable();
            $table->bigInteger('status_person_id')->nullable();
            $table->bigInteger('marital_statuses_id')->nullable();
            $table->bigInteger('gender_id')->nullable();
            $table->bigInteger('countries_id')->nullable();
            $table->string('user', 255)->nullable();
            $table->string('date', 255)->nullable();
            $table->string('status', 255)->nullable();
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
        Schema::dropIfExists('people');
    }
}
