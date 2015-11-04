<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUrlFieldSocialTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('social', function (Blueprint $table) {
            $table->string('url')->nullable();
            $table->string('username')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('social', function (Blueprint $table) {
            $table->dropColumn('url');
            $table->dropColumn('username');
        });
    }
}
