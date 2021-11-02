<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserplansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userplans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->integer('captcha')->default(0);
            $table->integer('menual_req')->default(0);
            $table->integer('monthly_req')->default(0);
            $table->integer('daily_req')->default(0);
            $table->integer('mail_activity')->default(0);
            $table->double('storage_limit')->default(0.0);
            $table->integer('fraud_check')->default(0); 
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
        Schema::dropIfExists('userplans');
    }
}
