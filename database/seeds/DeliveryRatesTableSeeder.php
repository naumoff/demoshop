<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryRatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('delivery_rates')->insert([
            [
                'min_weight'=>1,
                'max_weight'=>499,
                'delivery_cost'=>200,
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now()
            ],
            [
                'min_weight'=>500,
                'max_weight'=>999,
                'delivery_cost'=>400,
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now()
            ],
            [
                'min_weight'=>1000,
                'max_weight'=>1999,
                'delivery_cost'=>800,
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now()
            ],
            [
                'min_weight'=>2000,
                'max_weight'=>4999,
                'delivery_cost'=>1600,
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now()
            ],
            [
                'min_weight'=>5000,
                'max_weight'=>6999,
                'delivery_cost'=>3200,
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now()
            ],
            [
                'min_weight'=>7000,
                'max_weight'=>11999,
                'delivery_cost'=>6200,
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now()
            ],
        ]);
    }
}
