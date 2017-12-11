<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

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
#region MAIN METHODS
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
    
    extract(makeEurAndRuPrice($faker));
    
    $discountChance = rand(0,1);
    if($discountChance){
        extract(makeStartAndEndDate());
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

$factory->define(\App\Package::class,function(Faker $faker){
    
    extract(makeStartAndEndDate());
    
    extract(makeEurAndRuPrice($faker));
    
    // retrive random category id
    $categories = \App\Category::all()->toArray();
    $categoryId = $categories[rand(0,count($categories)-1)]['id'];
    
    return [
        'category_id'=>$categoryId,
        'package_name'=>'RU-pack-'.$faker->word,
        'package_price'=>$ruPrice,
        'package_start_period'=>$startDate,
        'package_end_period'=>$endDate,
        'active'=>rand(0,1),
        'created_at'=>\Carbon\Carbon::now(),
        'updated_at'=>\Carbon\Carbon::now()
    ];
});

$factory->define(\App\PackageProduct::class,function(Faker $faker){
    
    $products = \App\Product::all()->toArray();
    $productId = $products[rand(0,count($products)-1)]['id'];
    
    return [
        'product_id'=>$productId,
        'created_at'=>\Carbon\Carbon::now(),
        'updated_at'=>\Carbon\Carbon::now()
    ];
});

$factory->define(\App\Present::class,function(Faker $faker){
    $pathToFiles = Storage::disk('presents')->files('/');
    $url1 = Storage::disk('presents')->url($pathToFiles[rand(0,count($pathToFiles)-1)]);
    $url2 = Storage::disk('presents')->url($pathToFiles[rand(0,count($pathToFiles)-1)]);
    $url3 = Storage::disk('presents')->url($pathToFiles[rand(0,count($pathToFiles)-1)]);
    $urls = serialize([$url1,$url2,$url3]);
    $ranges = [
        [1000,2000],
        [2000.01,3000],
        [3000.01,4000],
        [4000.01,5000],
        [5000.01,6000],
        [6000.01,7000]
    ];
    $range = $ranges[rand(0,count($ranges)-1)];
    $present = $faker->word;
    return [
        'present_ru'=>'PRES-RU-'.$present,
        'present_de'=>'PRES-DE-'.$present,
        'description'=>'DESC-'.$faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'urls'=>$urls,
        'weight_gr'=>rand(25,1000),
        'min_order_value_rub'=> $range[0],
        'max_order_value_rub'=> $range[1],
        'active'=>rand(0,1)
    ];
});

$factory->define(\App\PaymentPartner::class, function(Faker $faker){
    return [
        'first_name'=>$faker->firstName,
        'last_name'=>$faker->lastName,
        'email'=>$faker->email,
        'total_limit_eur'=>5000,
        'current'=>0,
        'active'=>rand(0,1),
        'created_at'=>\Carbon\Carbon::now(),
        'updated_at'=>\Carbon\Carbon::now()
    ];
});

$factory->define(\App\PaymentCard::class, function(Faker $faker){
    return [
        'bank'=>$faker->company,
        'card_number'=>$faker->creditCardNumber,
        'card_limit_eur'=>600,
        'current'=>0,
        'active'=>rand(0,1),
        'created_at'=>\Carbon\Carbon::now(),
        'updated_at'=>\Carbon\Carbon::now()
    ];
});

$factory->define(\App\Order::class, function(Faker $faker){
   
    $invoiceNumber = \App\Order::getLastInvoiceNumber() + 1;
    $today = Carbon::today();
    $orderNumber = $today->year.'-'.$invoiceNumber;
    
    if(rand(0,1) == 1){ //order paid
        $deliveryTrackNumber = uniqid();
        $orderStatus = config('lists.order_status.order_sent.en');
        $invoiceStatus = config('lists.invoice_status.invoice_valid.en');
    }else{ // order not paid
        $deliveryTrackNumber = null;
        $orderStatus = config('lists.order_status.payment_expectation.en');
        $invoiceStatus = config('lists.invoice_status.invoice_valid.en');
    }
    
    $userId = getRandomUserId();
    $randomCity = getRandomCityFromRussia();
    
    $createdAt = Carbon::now()->subDays(rand(0,100));
    
    return [
        'present_id'=>null,
        'payment_card_id'=>null,
        'invoice_number'=>$invoiceNumber,
        'order_number'=>$orderNumber,
        'delivery_track_number'=>$deliveryTrackNumber,
        'user_id'=>$userId,
        'user_first_name'=>$faker->firstName,
        'user_last_name'=>$faker->lastName,
        'user_email'=>$faker->email,
        'user_phone'=>$faker->e164PhoneNumber,
        'user_country'=>'Россия',
        'user_city'=>$randomCity,
        'user_street'=>$faker->streetName,
        'user_building_number'=>$faker->buildingNumber,
        'user_apartment_number'=>rand(1,1000),
        'user_post_index'=>$faker->postcode,
        'order_weight'=>null,
        'order_delivery_cost'=>null,
        'order_goods_cost'=>null,
        'order_total_invoice_amount'=>null,
        'order_status'=> $orderStatus,
        'invoice_status'=>$invoiceStatus,
        'created_at'=>$createdAt,
        'updated_at'=>$createdAt
    ];
});

$factory->define(\App\OrderProduct::class, function(Faker $faker) {
    
    $randomProduct = getRandomProduct();
    $invoiceRowCalculator = new \App\Services\InvoiceRowCalculatorService();
    $qty = rand(1,5);
    return [
        'product_id'=>$randomProduct->id,
        'qty'=>$qty,
        'cost'=> $invoiceRowCalculator->calculateProductCostByQty($randomProduct, $qty),
        'weight'=> $invoiceRowCalculator->calculateProductWeightByQty($randomProduct, $qty)
    ];
});

$factory->define(\App\OrderPackage::class, function(Faker $faker){
    $randomPackage = getRandomPackage();
    $invoiceRowCalculator = new \App\Services\InvoiceRowCalculatorService();
    $qty = rand(1,5);
    
    return [
        'package_id'=>$randomPackage->id,
        'qty'=>$qty,
        'cost'=>$invoiceRowCalculator->calculatePackageCostByQty($randomPackage, $qty),
        'weight'=>$invoiceRowCalculator->calculatePackageWeightByQty($randomPackage, $qty)
    ];
});
#endregion

#region SERVICE METHODS
function makeStartAndEndDate()
{
    //make date
    $year = rand(2016, 2019);
    $month = rand(1, 12);
    $day = rand(1, 28);
    $startDate = \Carbon\Carbon::create($year, $month, $day, 0, 0, 0)
        ->format('Y-m-d H:i:s');
    $endDate = \Carbon\Carbon::create($year, $month, $day, 0, 0, 0)
        ->addDays(rand(1, 90))
        ->format('Y-m-d H:i:s');
    return [
        'startDate'=>$startDate,
        'endDate'=>$endDate
    ];
}

function makeEurAndRuPrice(Faker $faker)
{
    // make price
    $exchRate = 69.5;
    $eurPrice = $faker->randomFloat($nbMaxDecimals = 8, $min = 1, $max = 150);
    $ruPrice = $eurPrice * $exchRate;
    
    return [
        'eurPrice'=>$eurPrice,
        'ruPrice'=>$ruPrice
    ];
}

function getRandomUserId()
{
    $userIds = \App\User::get(['id']);
    
    $users = [];
    foreach ($userIds AS $userId) {
        $users[] = $userId->id;
    }
    return $users[rand(0,count($users)-1)];
}

function getRandomCityFromRussia()
{
    $cities = [
        'Москва',
        'Волгоград',
        'Севастополь',
        'Питер',
        'Пермь',
        'Казань'
    ];
    
    return $cities[rand(0,count($cities)-1)];
}

function getRandomProduct()
{
    $productIds = \App\Product::get(['id']);
    $products = [];
    foreach ($productIds AS $productId) {
        $products[] = $productId->id;
    }
    
    $chosenProduct =  \App\Product::find($products[rand(0,count($products)-1)]);
    return $chosenProduct;
}

function getRandomPackage()
{
    $packageIds = \App\Package::get(['id']);
    $packages = [];
    foreach ($packageIds AS $packageId) {
        $packages[] = $packageId->id;
    }
    
    $chosenPackage =  \App\Package::find($packages[rand(0,count($packages)-1)]);
    return $chosenPackage;
}
#endregion