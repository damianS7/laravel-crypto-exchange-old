<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_history', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('pair_id');
            $table->decimal('price', 15, 8);
            $table->decimal('amount', 22, 8);
            $table->enum('type', ['buy', 'sell']);
            $table->timestamp('date');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pair_id')->references('id')->on('pairs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_history');
    }
}
