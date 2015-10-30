<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSocialOauth2AccessToken extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('social', function (Blueprint $table) {
            $table->string('oauth2_access_token', 1024)->change();
            $table->string('oauth2_refresh_token', 1024)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        /*
        Schema::table('social', function (Blueprint $table) {
            $table->string('oauth2_access_token', 255)->change();
            $table->string('oauth2_refresh_token', 255)->change();
        });
        */
    }
}
