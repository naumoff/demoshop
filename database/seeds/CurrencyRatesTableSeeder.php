<?php

use Illuminate\Database\Seeder;

class CurrencyRatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currency_rates')->insert([
            'eur_rub'=> null,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        sleep(1);
        DB::table('currency_rates')->insert([
            'eur_rub'=> 69.4999,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        sleep(1);
        DB::table('currency_rates')->insert([
            'eur_rub'=> null,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        sleep(1);
        DB::table('currency_rates')->insert([
            'eur_rub'=> 70.4999,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
    }
}
