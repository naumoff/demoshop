<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $userStatus = [];
        foreach (config('lists.user_status') AS $key=>$array){
            $userStatus[] = $array['en'];
        }
        Schema::create('users', function (Blueprint $table) use ($userStatus) {
            $table->increments('id');
            $table->integer('role_id')->unsigned()->index();
            $table->string('name');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('mobile_phone');
            $table->string('country');
            $table->enum('status',$userStatus);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('role_id')->references('id')->on('roles');
        });
        
        // adding admin to fresh installed db from .env file
        $adminRoleId = \DB::table('roles')
            ->where('role','=',config('roles.admin.en'))
            ->get(['id'])
            ->toArray()[0]->id;
        
        DB::table('users')->insert([
            'role_id'=>$adminRoleId,
            'name'=>$_ENV['ADMIN_NAME'],
            'first_name'=>$_ENV['ADMIN_FIRST_NAME'],
            'last_name'=>$_ENV['ADMIN_LAST_NAME'],
            'email'=>$_ENV['ADMIN_EMAIL'],
            'mobile_phone'=>$_ENV['ADMIN_MOBILE_PHONE'],
            'country'=> $_ENV['ADMIN_COUNTRY'],
            'status'=>config('lists.user_status.approved.en'),
            'password'=>bcrypt($_ENV['ADMIN_PASSWORD']),
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
