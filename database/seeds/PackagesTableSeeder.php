<?php

use Illuminate\Database\Seeder;

class PackagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Package::class,200)->create()->each(function($u){
            $u->packageProducts()->save(factory(\App\PackageProduct::class)->make());
        });
    }
}
