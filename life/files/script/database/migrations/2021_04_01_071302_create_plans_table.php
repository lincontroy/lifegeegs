<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('price');
            $table->integer('duration');
            $table->integer('captcha')->default(0);
            $table->integer('menual_req')->default(0);
            $table->integer('monthly_req')->default(0);
            $table->integer('daily_req')->default(0);
            $table->integer('mail_activity')->default(0);
            $table->double('storage_limit')->default(0.0);
            $table->integer('fraud_check')->default(0);
            $table->integer('is_featured')->default(0);
            $table->integer('is_auto')->default(0);
            $table->integer('is_trial')->default(0);
            $table->integer('is_default')->default(0);
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('plans');
    }
}
