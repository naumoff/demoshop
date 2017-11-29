<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colors', function (Blueprint $table) {
            $table->increments('id');
            $table->text('color');
            $table->text('color_code');
            $table->timestamps();
        });
        
        DB::table('colors')->insert([
            [
                'color'=>'undefined',
                'color_code'=>'xxx',
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ],
            [
                'color'=>'красный',
                'color_code'=>'f44e42',
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ],
            [
                'color'=>'желтый',
                'color_code'=>'f4df41',
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ],
            [
                'color'=>'зеленый',
                'color_code'=>'4ff441',
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ],
            [
                'color'=>'синий',
                'color_code'=>'4641f4',
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ],
            [
                'color'=>'фиолетовый',
                'color_code'=>'4641f4',
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ],
            [
                'color'=>'коричневый',
                'color_code'=>'f48b41',
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ],
            [
                'color'=>'черный',
                'color_code'=>'1c1918',
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ],
            [
                'color'=>'оранжевый',
                'color_code'=>'ef6d02',
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ],
            [
                'color'=>'белый',
                'color_code'=>'f7f7f7',
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colors');
    }
}
