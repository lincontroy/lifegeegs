<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsergetwaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usergetways', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('getway_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('status')->default(1);
            $table->string('name');
            $table->string('currency_name')->nullable();
            $table->integer('phone_required')->default(0);
            $table->text('sandbox')->nullable();
            $table->text('production')->nullable();
            $table->text('data')->nullable();
            $table->double('rate')->default(1);
            $table->double('charge')->default(0);
            $table->timestamps();

            $table->foreign('getway_id')
            ->references('id')->on('getways')
            ->onDelete('cascade'); 
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
        Schema::dropIfExists('usergetways');
    }
}
