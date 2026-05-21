<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountNumbersTable extends Migration
{
    public function up()
    {
        Schema::create('account_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('account_number')->unique();
            $table->string('account_name')->nullable();
            $table->string('type')->nullable();
            $table->boolean('status')->default(1);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('account_numbers');
    }
}
