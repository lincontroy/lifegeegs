<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->default(2);
            $table->string('currency')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->double('amount');
            $table->integer('is_fallback')->default(0);
            $table->integer('is_test')->default(1);
            $table->string('ip')->nullable();
            $table->integer('captcha_status')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')
            ->references('id')->on('users')
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
        Schema::dropIfExists('requests');
    }
}
