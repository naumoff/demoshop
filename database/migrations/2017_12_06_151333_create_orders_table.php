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
        $orderStatus = [];
        foreach (config('lists.order_status') AS $key=>$item){
            $orderStatus[] = $key;
        }
        $invoiceStatus = [];
        foreach (config('lists.invoice_status') AS $key=>$item){
            $invoiceStatus[] = $key;
        }
        Schema::create('orders', function (Blueprint $table) use ($orderStatus, $invoiceStatus) {
            $table->increments('id');
            $table->integer('present_id')->unsigned()->index();
            $table->integer('payment_card_id')->unsigned()->index();
            $table->string('invoice_number');
            $table->string('order_number');
            $table->string('delivery_track_number');
            $table->integer('user_id')->unsigned()->index();
            $table->string('user_first_name');
            $table->string('user_last_name');
            $table->string('user_email');
            $table->string('user_phone');
            $table->string('user_country');
            $table->string('user_city');
            $table->string('user_street');
            $table->string('user_building_number');
            $table->string('user_apartment_number');
            $table->string('user_post_index');
            $table->integer('order_weight');
            $table->float('order_delivery_cost');
            $table->float('order_goods_cost');
            $table->float('order_total_invoice_amount');
            $table->enum('order_status',$orderStatus);
            $table->enum('invoice_status',$invoiceStatus);
            $table->timestamps();
            $table->foreign('present_id')->references('id')->on('presents');
            $table->foreign('payment_card_id')->references('id')->on('payment_cards');
            $table->foreign('user_id')->references('id')->on('users');
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
