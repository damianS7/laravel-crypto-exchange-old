<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pairs', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->unsignedInteger('coin_id');
            //$table->unsignedInteger('coin_id2');
            $table->unsignedInteger('market_id');
            $table->boolean('tradeable')->default(false);

            $table->foreign('coin_id')->references('id')->on('coins')->onDelete('cascade');
            $table->foreign('market_id')->references('id')->on('markets')->onDelete('cascade');
            //$table->foreign('coin_id2')->references('coin_id')->on('markets')->onDelete('cascade');
            $table->unique(array('coin_id', 'market_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pairs');
    }
}
