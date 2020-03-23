<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('creator_id')->unsigned();
            $table->boolean('private')->default(false);
            $table->boolean('user_channel')->default(false);
            $table->timestamps();
        });

        Schema::create('channel_user', function (Blueprint $table) {

            $table->bigInteger('channel_id')->unsigned()->index();
            $table->foreign('channel_id')->references('id')->on('channels')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('channels');
        Schema::dropIfExists('channel_user');
    }
}
