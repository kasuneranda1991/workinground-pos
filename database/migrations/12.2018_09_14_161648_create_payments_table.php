<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('customer_name');
            $table->string('type')->nullable();
            $table->string('state')->nullable();
            $table->string('pay_for')->nullable();
            $table->string('amount');
            $table->string('other')->nullable();
            $table->string('monthly_rate')->nullable();
            $table->string('voucher')->nullable();
            $table->string('contact')->nullable();
            $table->string('remark')->nullable();
            $table->integer('aproved_by')->nullable();
            $table->string('change')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->integer('shop_id')->unsigned()->nullable();
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
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
        Schema::dropIfExists('payments');
    }
}
