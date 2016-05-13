<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'General Operator',
            'email' => 'admin@admin.com',
            'phone' => '15417543010',
            'password' => bcrypt('admin123'),
        ]);
    }
}
