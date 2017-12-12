<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned()->index();
            $table->string('package_ru');
            $table->string('package_de');
            $table->float('price_eur',10,2)->nullable();
            $table->float('price_rub_auto',10,2)->nullable();
            $table->float('price_rub_manual',10,2)->nullable();
            $table->integer('weight_gr')->nullable();
            $table->dateTime('package_start_period');
            $table->dateTime('package_end_period');
            $table->boolean('active');
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
