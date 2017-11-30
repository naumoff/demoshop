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
                'color'=>'Без цвета',
                'color_code'=>'xxx',
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ],
            [
                'color'=>'белый',
                'color_code'=>'white',
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ],
            [
                'color'=>'желтый',
                'color_code'=>'yellow',
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ],
            [
                'color'=>'красный',
                'color_code'=>'red',
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ],
            [
                'color'=>'оранжевый',
                'color_code'=>'orangered',
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ],
            [
                'color'=>'зеленый',
                'color_code'=>'green',
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ],
            [
                'color'=>'синий',
                'color_code'=>'blue',
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ],
            [
                'color'=>'фиолетовый',
                'color_code'=>'darkslateblue',
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ],
            [
                'color'=>'коричневый',
                'color_code'=>'saddlebrown',
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now(),
            ],
            [
                'color'=>'черный',
                'color_code'=>'black',
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
