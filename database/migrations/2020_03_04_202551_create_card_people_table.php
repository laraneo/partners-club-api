<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('people_id');
            $table->string('titular',255);
            $table->string('ci',255);
            $table->string('card_number',255);
            $table->string('sec_code',255);
            $table->date('expiration_date');
            $table->bigInteger('card_type_id');
            $table->bigInteger('bank_id');
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
        Schema::dropIfExists('card_people');
    }
}
