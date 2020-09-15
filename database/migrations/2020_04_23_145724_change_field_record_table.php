<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('records', function ($table) {
            $table->text('description')->change();
        });
        Schema::table('notes', function ($table) {
            $table->text('description')->change();
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
            $table->dropColumn('description');
        });
        Schema::table('notes', function(Blueprint $table) {
            $table->dropColumn('description');
        });
    }
}
