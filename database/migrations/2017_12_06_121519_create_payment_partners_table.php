<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_partners', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sequence')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique()->index();
            $table->float('total_limit_eur',8,2)
                ->default(5000.00)
                ->comment('total limit for payment partner in EUR');
            $table->float('total_cards_limit_eur',8,2)
                ->default(0)
                ->comment('total cards limits amount in EUR');
            $table->float('total_invoiced_eur')
                ->default(0)
                ->invoice('total invoiced amount for payment partner in EUR');
            $table->boolean('current')
                ->comment('1 - if partner is used now for invoicing');
            $table->boolean('active')
                ->default(0)
                ->comment('1 - if partner is not blocked');
            $table->timestamps();
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
        Schema::dropIfExists('payment_partners');
    }
}
