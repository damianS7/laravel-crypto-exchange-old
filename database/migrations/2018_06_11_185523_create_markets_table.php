<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('markets', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->unsignedInteger('traded_coin_id');
            $table->unsignedInteger('market_coin_id');
            $table->enum('status', ['suspended', 'resumed'])->default('suspended');
            $table->boolean('visible')->default(false);
            $table->foreign('traded_coin_id')->references('id')->on('coins')->onDelete('cascade');
            $table->foreign('market_coin_id')->references('id')->on('coins')->onDelete('cascade');
            $table->unique(array('traded_coin_id', 'market_coin_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('markets');
    }
}
