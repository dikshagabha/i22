<?php

use Illuminate\Database\Seeder;

class StoreUserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([

            'first_name' => 'test',
            'last_name'=>'test',
            'username'=>'test',
            'email' => 'test@yopmail.com',
            'password' => bcrypt('test@123'),
            'role'=>1
        ]);

    }
}
