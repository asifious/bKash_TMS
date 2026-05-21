<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('application_settings', function (Blueprint $table) {
            $table->id();
            $table->string('setting_key')->unique();
            $table->longText('setting_value')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('application_settings');
    }
}
