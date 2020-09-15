<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description',255)->nullable();
            $table->date('created')->nullable();
            $table->integer('days')->nullable();
            $table->integer('blocked')->nullable();
            $table->date('expiration_date')->nullable();
            $table->string('file1',255)->nullable();
            $table->string('file2',255)->nullable();
            $table->string('file3',255)->nullable();
            $table->string('file4',255)->nullable();
            $table->string('file5',255)->nullable();
            $table->bigInteger('people_id')->nullable();
            $table->bigInteger('record_type_id')->nullable();
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
        Schema::dropIfExists('records');
    }
}
