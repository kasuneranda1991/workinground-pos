<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shop_name');
            $table->string('type')->default('Hardware');
            $table->string('owner')->nullable();
            $table->string('owner_nic')->nullable();
            $table->string('logo')->default('shop-logo.png');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('sender_id')->default('WORKINGROUN');
            $table->string('monthly_rate')->nullable();
            $table->string('payment_plan')->default('demo');
            $table->string('postal_code')->nullable();
            $table->string('BR')->nullable();
            $table->string('VAT')->nullable();
            $table->string('contact_no')->nullable();
            $table->integer('bulk_attempt')->default(0);
            $table->string('bulk_month')->nullable();
            $table->boolean('bulk')->nullable()->default('0');
            $table->boolean('notification')->nullable()->default('0');
            $table->timestamp('expire_date')->nullable();
            $table->string('state')->default('pending');
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
        Schema::dropIfExists('shops');
    }
}
