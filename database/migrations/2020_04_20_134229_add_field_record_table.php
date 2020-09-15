<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('records', function(Blueprint $table) {
            $table->bigInteger('user_id')->nullable();
        });
        Schema::table('records', function(Blueprint $table) {
            $table->bigInteger('userupdate_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('records', function(Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('records', function(Blueprint $table) {
            $table->dropColumn('userupdate_id');
        });
    }
}
