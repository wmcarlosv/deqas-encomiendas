<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'=>'administrador',
            'email'=>'wmcarlosv@gmail.com',
            'password'=>bcrypt('Car2244los*')
        ]);
    }
}
