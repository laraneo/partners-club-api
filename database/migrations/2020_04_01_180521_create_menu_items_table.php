<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *CREATE TABLE [dbo].[menuitems](
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 150);
            $table->string('slug', 150)->unique();
            $table->string('description', 255)->nullable();
            $table->string('route', 255)->nullable();
            $table->string('icon', 255)->nullable();
            $table->unsignedInteger('parent')->default(0);
            $table->smallInteger('order')->default(0);
            $table->boolean('enabled')->default(1);
            $table->bigInteger('menu_id')->nullable();
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
        Schema::dropIfExists('menu_items');
    }
}
