<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->unsignedInteger('coin_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('wallet_id');
            $table->decimal('amount', 22, 8);
            $table->string('tx');
            $table->timestamp('date')->useCurrent();
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'error'])->default('pending');

            $table->foreign('coin_id')->references('id')->on('coins')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposits');
    }
}
