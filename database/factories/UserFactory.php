<?php

use Faker\Generator as Faker;
use Faker\Factory as newFaker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    static $password;
    
    $firstName = $faker->firstName;
    $lastName = $faker->lastName;
    $name = $firstName.' '.$lastName;
    
    $userStatus = [];
    foreach (config('lists.user_status') AS $key=>$array){
        $userStatus[] = $array['en'];
    }
    
    $customerRoleId = \DB::table('roles')
        ->where('role','=',config('roles.customer.en'))
        ->get(['id'])
        ->toArray()[0]->id;
    
    return [
        'role_id'=>$customerRoleId,
        'name' => $name,
        'first_name'=>$firstName,
        'last_name'=>$lastName,
        'email' => $faker->unique()->safeEmail,
        'mobile_phone'=> $faker->e164PhoneNumber,
        'country'=> 'Russian Federation',
        'status'=> $userStatus[rand(0,count($userStatus)-1)],
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'created_at'=>\Carbon\Carbon::now(),
        'updated_at'=>\Carbon\Carbon::now()
    ];
});

$factory->define(\App\Group::class, function(Faker $faker){
    $categories = \App\Category::all()->toArray();
    return [
        'category_id'=>$categories[rand(0,count($categories)-1)]['id'],
        'group'=>'group-'.$faker->word,
        'active'=>rand(0,1),
        'created_at'=>\Carbon\Carbon::now(),
        'updated_at'=>\Carbon\Carbon::now()
    ];
});

$factory->define(\App\Product::class, function(Faker $faker){
    $groups = \App\Group::all()->toArray();
    
    $productName = $faker->word();
    $productNameRu = 'RU-prod-'.$productName;
    $productNameDe = 'DE-prod-'.$productName;
    
    $exchRate = 69.5;
    $eurPrice = $faker->randomFloat($nbMaxDecimals = 8, $min = 1, $max = 150);
    $ruPrice = $eurPrice * $exchRate;
    
    $discountChance = rand(0,1);
    if($discountChance){
        $year = rand(2016,2019);
        $month = rand(1,12);
        $day = rand(1,28);
        $startDate = \Carbon\Carbon::create($year,$month,$day,0,0,0)
            ->format('Y-m-d H:i:s');
        $endDate = \Carbon\Carbon::create($year,$month,$day,0,0,0)
            ->addDays(rand(1,90))
            ->format('Y-m-d H:i:s');
        $discount = rand(5, 9)/10;
    }else{
        $startDate = null;
        $endDate = null;
    }

    return [
        'group_id'=>$groups[rand(0,count($groups)-1)]['id'],
        'product_ru'=>$productNameRu,
        'product_de'=>$productNameDe,
        'description'=>$faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'price_eur'=>$eurPrice,
        'price_rub_auto'=>$ruPrice,
        'price_rub_manual'=>0,
        'price_with_discount'=>($discountChance)?$ruPrice*$discount:0,
        'discount_start'=>$startDate,
        'discount_end'=>$endDate,
        'discount_active'=>rand(0,$discountChance),
        'weight_gr'=>rand(500,40000),
        'active'=>rand(0,1),
        'created_at'=>\Carbon\Carbon::now(),
        'updated_at'=>\Carbon\Carbon::now()
    ];
});

$factory->define(\App\ColorProduct::class, function(Faker $faker){
    $colors = \App\Color::all()->toArray();
    $products = \App\Product::all()->toArray();
    
    $pathToFiles = Storage::disk('products')->files('/');
    $url = Storage::disk('products')->url($pathToFiles[rand(0,count($pathToFiles)-1)]);
    
    return [
        'color_id'=>$colors[rand(0,count($colors)-1)]['id'],
        'product_id'=>$products[rand(0,count($products)-1)]['id'],
        'url'=>$url
    ];
});
