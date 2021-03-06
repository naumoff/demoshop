<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColorProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('color_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('color_id')->index()->unsigned();
            $table->integer('product_id')->index()->unsigned();
            $table->text('url');
            $table->timestamps();
            $table->foreign('color_id')->references('id')->on('colors');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDeleted('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('color_product');
    }
}
