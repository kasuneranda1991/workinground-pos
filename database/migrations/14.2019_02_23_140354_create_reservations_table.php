<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reservation_ref')->default(0);
            $table->string('tour_no')->nullable();
            $table->date('checkin');
            $table->date('checkout');
            $table->string('rate_code')->nullable();
            $table->string('nationality')->default('lk');
            $table->string('checkinTo')->nullable();
            $table->string('checkOutAfter')->nullable();
            $table->string('reservation_Type');
            $table->string('reservation_room_type')->nullable();
            $table->string('reservation_bed_type')->nullable();
            $table->string('roomNo')->nullable();
            $table->integer('room_count')->nullable();
            $table->integer('adult_count');
            $table->integer('child_count')->nullable();
            $table->double('night')->nullable();
            $table->double('rate');
            $table->double('discount')->nullable();
            $table->string('special_note')->nullable();
            $table->integer('approved_by')->nullable();
            $table->string('remark')->nullable();
            $table->string('state')->default('not_comfirmed');
            $table->integer('shop_id')->unsigned()->nullable();
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->integer('travelagent_id')->unsigned()->nullable();
            $table->foreign('travelagent_id')->references('id')->on('travel_agents')->onDelete('set null');
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
        Schema::dropIfExists('reservations');
    }
}
