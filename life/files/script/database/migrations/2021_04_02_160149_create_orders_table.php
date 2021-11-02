<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('getway_id');
            $table->unsignedBigInteger('user_id');
            $table->double('amount');
            $table->date('exp_date');
            $table->integer('payment_status');
            $table->integer('status');
            $table->string('payment_id');

            $table->foreign('plan_id')
            ->references('id')->on('plans')
            ->onDelete('cascade'); 
            
            $table->foreign('getway_id')
            ->references('id')->on('getways')
            ->onDelete('cascade'); 
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade'); 
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
        Schema::dropIfExists('orders');
    }
}
