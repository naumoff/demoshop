<?php

use Illuminate\Database\Seeder;

class PackagesTableSeeder extends Seeder
{
    private $packageQtyLimit = 45;
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->generatePackages($this->packageQtyLimit);
    }
    
    #region SERVICE METHODS
    private function generatePackages($limit)
    {
        for($a = 0; $a <$limit; $a++){
            $packageId = factory(\App\Package::class)->create()->id;
            
            factory(\App\PackageProduct::class)->create([
                'package_id'=>$packageId,
            ]);
            
            factory(\App\PackageProduct::class)->create([
                'package_id'=>$packageId,
            ]);
        }
    }
    #endregion
}
