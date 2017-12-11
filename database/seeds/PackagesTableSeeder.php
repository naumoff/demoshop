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
            
            $product1 = factory(\App\PackageProduct::class)->create([
                'package_id'=>$packageId,
            ]);
            
            $product2 = factory(\App\PackageProduct::class)->create([
                'package_id'=>$packageId,
            ]);
            
            $totalWeightWeight = $product1->weight_gr + $product2->weight_gr;
            
            $package = \App\Package::find($packageId);
            $package->weight_gr = $totalWeightWeight;
            $package->save();
        }
    }
    #endregion
}
