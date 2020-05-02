<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role')->default('user');
            $table->integer('shop_id')->unsigned()->nullable();
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
            $table->string('username');
            $table->string('password');
            $table->string('profile_pic')->default('user.png');
            $table->string('account_state')->default('pending');
            $table->string('block_state')->default('Unblock');
            $table->string('user_printer')->default('POS Printer');
            $table->string('contact_no');
            $table->boolean('confirmed')->default(1);
            $table->string('print_type')->default('pos');
            $table->string('login_state')->default('offline');
            $table->integer('verification_code')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
