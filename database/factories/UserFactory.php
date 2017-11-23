<?php

use Faker\Generator as Faker;

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
