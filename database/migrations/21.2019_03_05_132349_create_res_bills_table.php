<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('res_bills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bill_no')->nullable();
            $table->double('qty');
            $table->double('price');
            $table->double('discount')->nullable();
            $table->string('state')->default('open');
            $table->integer('approved_by')->nullable();
            $table->string('remark')->nullable();
            $table->string('payment')->nullable();
            $table->integer('menu_item_id');
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
        Schema::dropIfExists('res_bills');
    }
}
