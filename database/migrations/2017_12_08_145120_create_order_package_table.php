<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderPackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_package', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned()->index();
            $table->integer('package_id')->unsigned()->index();
            $table->integer('qty');
            $table->float('cost');
            $table->integer('weight');
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('package_id')->references('id')->on('packages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_package');
    }
}
