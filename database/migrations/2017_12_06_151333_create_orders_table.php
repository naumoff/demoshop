<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('present_id')->unsigned()->index();
            $table->integer('payment_card_id')->unsigned()->index();
            $table->string('invoice_number');
            $table->integer('user_id')->unsigned()->index();
            $table->string('user_first_name');
            $table->string('user_last_name');
            $table->string('user_email');
            $table->string('user_mobile_phone');
            $table->string('user_country');
            $table->string('user_city');
            $table->string('user_street');
            $table->string('user_building_number');
            $table->string('user_apartment_number');
            $table->string('user_post_index');
            $table->string('order_weight');
            $table->string('order_delivery_cost');
            $table->string('order_goods_cost');
            $table->string('order_invoice_amount');
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
        Schema::dropIfExists('orders');
    }
}
