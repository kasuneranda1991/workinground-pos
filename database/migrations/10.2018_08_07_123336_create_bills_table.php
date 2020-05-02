<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->integer('job_id')->unsigned()->nullable();
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('set null');
            $table->integer('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->integer('delete_product_id')->unsigned()->nullable();
            $table->foreign('delete_product_id')->references('id')->on('delete_products')->onDelete('set null');
            $table->integer('shop_id')->unsigned()->nullable();
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
            $table->double('qty',15,2);
            $table->double('selling_price',15,2);
            $table->double('total_price',19 ,2);
            $table->string('serial_no')->nullable();
            $table->integer('batch_no')->nullable();
            $table->string('cash_credit')->default('cash');
            $table->string('discount')->nullable();
            $table->string('discount_amount')->nullable();
            $table->string('size')->nullable();
            $table->date('expire_date')->nullable();
            $table->string('state')->default('not-settled');
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('bills');
    }
}
