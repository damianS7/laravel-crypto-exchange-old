<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// We need a cron script for this table
// The script will run every 24h
// The script will switch price_last to price_yesterday and volume24h will be volume24h-volumeyesterday
class CreateMarketStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_stats', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->unsignedInteger('market_id')->unique();
            $table->decimal('price_yesterday', 15, 8);
            $table->decimal('price', 15, 8);
            $table->decimal('volume_yesterday', 22, 8);
            $table->decimal('volume24h', 22, 8);
            $table->foreign('market_id')->references('id')->on('markets')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('market_stats');
    }
}
