<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SecretWordsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ColorProductTableSeeder::class);
        $this->call(CurrencyRatesTableSeeder::class);
        $this->generatePackage(45);


    }
    
    #region SERVICE METHODS
    private function generatePackage($limit)
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
