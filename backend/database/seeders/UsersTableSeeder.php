<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'name' => 'Super Admin',
            'slug' => 'super_admin',
            'role_id' => '1',
            'email' => 'sadmin@sadmin.com',
            'password' => bcrypt('123'),
            'text_password' => '123',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Admin',
            'slug' => 'admin',
            'role_id' => '2',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123'),
            'text_password' => '123',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Store',
            'slug' => 'store',
            'role_id' => '3',
            'email' => 'store@store.com',
            'password' => bcrypt('123'),
            'text_password' => '123',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Cutting',
            'slug' => 'cutting',
            'role_id' => '4',
            'email' => 'cutting@cutting.com',
            'password' => bcrypt('123'),
            'text_password' => '123',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Sewing',
            'slug' => 'sewing',
            'role_id' => '5',
            'email' => 'sewing@sewing.com',
            'password' => bcrypt('123'),
            'text_password' => '123',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Washing',
            'slug' => 'washing',
            'role_id' => '6',
            'email' => 'washing@washing.com',
            'password' => bcrypt('123'),
            'text_password' => '123',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Finishing',
            'slug' => 'finishing',
            'role_id' => '7',
            'email' => 'finishing@finishing.com',
            'password' => bcrypt('123'),
            'text_password' => '123',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
