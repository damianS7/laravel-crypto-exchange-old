<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->unsignedInteger('coin_id');
            $table->unsignedInteger('user_id');
            $table->decimal('amount', 22, 8);
            $table->string('address');
            $table->string('tx');
            $table->timestamp('date');
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'error'])->default('pending');
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('coin_id')->references('id')->on('coins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdrawals');
    }
}
