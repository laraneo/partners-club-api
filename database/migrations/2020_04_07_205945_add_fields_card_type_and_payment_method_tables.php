<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsCardTypeAndPaymentMethodTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('card_types', function(Blueprint $table) {
            $table->string('slug')->default("");
        });
        Schema::table('payment_methods', function(Blueprint $table) {
            $table->string('slug')->default("");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('card_types', function(Blueprint $table) {
            $table->dropColumn('slug');
        });
        Schema::table('payment_methods', function(Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
