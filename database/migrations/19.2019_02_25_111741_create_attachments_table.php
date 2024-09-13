<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('attachments', function (Blueprint $table) {
        $table->increments('id');
        $table->string('attachment');
        $table->string('type');
        $table->string('remark')->nullable();
        $table->integer('user_id')->unsigned()->nullable();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
        $table->integer('shop_id')->unsigned()->nullable();
        $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
        $table->integer('reservation_id')->unsigned()->nullable();
        $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('cascade');
        $table->integer('reservation_payment_id')->unsigned()->nullable();
        $table->foreign('reservation_payment_id')->references('id')->on('reservation_payments')->onDelete('cascade');
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
        Schema::dropIfExists('attachments');
    }
}
