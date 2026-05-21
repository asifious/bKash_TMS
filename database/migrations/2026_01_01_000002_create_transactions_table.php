<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('transaction_type', ['cash_in','send_money','received_money']);
            $table->date('transaction_date');
            $table->string('from_account_number')->nullable();
            $table->string('to_account_number')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('transaction_id')->nullable()->unique();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
