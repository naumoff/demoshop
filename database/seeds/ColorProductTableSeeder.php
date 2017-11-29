<?php

use Illuminate\Database\Seeder;

class ColorProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\ColorProduct::class, 400)->create();
    }
}
