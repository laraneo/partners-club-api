<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShareMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_movements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description',255)->nullable();
            $table->bigInteger('currency_rate_id')->nullable();
            $table->string('rate', 255)->nullable();
            $table->bigInteger('currency_sale_price_id')->nullable();
            $table->string('number_sale_price', 255)->nullable();
            $table->bigInteger('currencie_id')->nullable();
            $table->bigInteger('number_procesed')->nullable();
            $table->bigInteger('share_id')->nullable();
            $table->bigInteger('transaction_type_id')->nullable();
            $table->bigInteger('people_id')->nullable();
            $table->bigInteger('id_titular_persona')->nullable();
            $table->date('created')->nullable();
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
        Schema::dropIfExists('share_movements');
    }
}
