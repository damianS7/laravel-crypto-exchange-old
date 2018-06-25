<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coins', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('symbol')->unique();
            $table->string('name')->unique();
            $table->decimal('min_deposit', 22, 8);
            $table->decimal('min_withdrawal', 22, 8);
            $table->decimal('fee_withdrawal', 22, 8);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coins');
    }
}
