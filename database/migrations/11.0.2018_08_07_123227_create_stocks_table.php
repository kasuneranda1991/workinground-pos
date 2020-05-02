<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->integer('discard_id')->unsigned()->nullable();
            $table->foreign('discard_id')->references('id')->on('discard_items')->onDelete('cascade');
            $table->integer('bill_id')->unsigned()->nullable();
            $table->foreign('bill_id')->references('id')->on('bills')->onDelete('cascade');
            $table->integer('delete_product_id')->unsigned()->nullable();
            $table->foreign('delete_product_id')->references('id')->on('delete_products')->onDelete('set null');
            $table->integer('type_id')->unsigned()->nullable();
            $table->foreign('type_id')->references('id')->on('item_types')->onDelete('set null');
            $table->integer('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->integer('shop_id')->unsigned()->nullable();
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
            $table->string('count_type');
            $table->boolean('state')->default(1);
            $table->string('size')->nullable();
            $table->string('sub_category')->nullable();
            $table->decimal('qty',20,2);
            $table->decimal('unit_price',15,2);
            $table->timestamp('expire_date')->nullable();
            $table->string('remark')->default('Newly Added');
            // $table->string('alert')->nullable();
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
        Schema::dropIfExists('stocks');
    }
}
