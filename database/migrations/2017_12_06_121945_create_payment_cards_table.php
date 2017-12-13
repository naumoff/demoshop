<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_cards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('holder_id')->unsigned()->index();
            $table->string('bank');
            $table->string('card_number')->unique();
            $table->float('card_limit_eur',8,2)
                ->default('600.00');
            $table->float('card_invoiced_eur',8,2)
                ->default(0);
            $table->boolean('current')
                ->comment('1 - if current card is used now for invoicing');
            $table->boolean('active')
                ->default(0)
                ->comment('1 - if current card is not blocked');
            $table->timestamps();
            $table->foreign('holder_id')
                ->references('id')
                ->on('payment_partners')
                ->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_cards');
    }
}
