<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'user_id' => '',
                'username' => '',
                'shop_id' => 16333181,
                'access_token' => '76fd62c2c980ecd90b4af0baaf8fee',
                'access_secret' => 'd5cf360a96'
            ]
        ];
        DB::table('users')->truncate();
        DB::table('users')->insert($data);
    }
}
