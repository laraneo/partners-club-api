<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsReferralTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referrals', function(Blueprint $table) {
            $table->bigInteger('referral_type_id')->nullable();
            $table->dropColumn('referral_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referrals', function(Blueprint $table) {
            $table->dropColumn('referral_type_id');
        });
    }
}
