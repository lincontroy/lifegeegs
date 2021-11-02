<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencygetwaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencygetways', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usergetway_id');
            $table->unsignedBigInteger('currency_id');
            $table->double('rate')->nullable();
            $table->double('fee')->nullable();

            $table->foreign('usergetway_id')
            ->references('id')->on('usergetways')
            ->onDelete('cascade'); 
            $table->foreign('currency_id')
            ->references('id')->on('currencies')
            ->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencygetways');
    }
}
