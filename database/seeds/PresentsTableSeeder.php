<?php

use Illuminate\Database\Seeder;

class PresentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Present::class, 90)->create();
    }
}
