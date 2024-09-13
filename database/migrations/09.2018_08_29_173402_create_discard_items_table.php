<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscardItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discard_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reason')->default('Delete By User');
            $table->string('state')->default('Delete');
            $table->string('count_Type')->nullable();
            $table->double('quantity',5,2);
            $table->integer('approved_user')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('delete_product_id')->unsigned()->nullable();
            $table->foreign('delete_product_id')->references('id')->on('delete_products')->onDelete('set null');
            $table->integer('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->integer('shop_id')->unsigned()->nullable();
            $table->integer('batch_no')->nullable();
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
        Schema::dropIfExists('discard_items');
    }
}
