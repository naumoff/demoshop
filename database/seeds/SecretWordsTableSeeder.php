<?php

use Illuminate\Database\Seeder;

class SecretWordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('secret_words')->insert([
            'secret_word'=>'secret1',
            'status'=> 'active',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
        ]);

        \DB::table('secret_words')->insert([
            'secret_word'=>'secret1',
            'status'=> 'active',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
        ]);

        \DB::table('secret_words')->insert([
            'secret_word'=>'wrong1',
            'status'=> 'cancelled',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
        ]);

        \DB::table('secret_words')->insert([
            'secret_word'=>'wrong2',
            'status'=> 'cancelled',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
        ]);
    }
}
