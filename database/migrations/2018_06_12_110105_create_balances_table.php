<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('coin_id');
            $table->decimal('avaliable', 22, 8);
            $table->decimal('total', 22, 8);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('coin_id')->references('id')->on('coins')->onDelete('cascade');
            $table->unique(['user_id', 'coin_id']);
            //$table->primary(['user_id', 'coin_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balances');
    }
}
