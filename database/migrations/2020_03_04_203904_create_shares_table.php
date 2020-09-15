<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shares', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('share_number')->nullable();
            $table->integer('father_share_id')->nullable();
            $table->bigInteger('status')->nullable();
            $table->bigInteger('payment_method_id')->nullable();
            $table->bigInteger('card_people1')->nullable();
            $table->bigInteger('card_people2')->nullable();
            $table->bigInteger('card_people3')->nullable();
            $table->bigInteger('id_persona')->nullable();
            $table->bigInteger('id_titular_persona')->nullable();
            $table->bigInteger('id_factura_persona')->nullable();
            $table->bigInteger('id_fiador_persona')->nullable();
            $table->bigInteger('share_type_id')->nullable();
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
        Schema::dropIfExists('shares');
    }
}
