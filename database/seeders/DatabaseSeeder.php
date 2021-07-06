<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CompaniasTableSeeder::class,
            RolesRASICTableSeeder::class,
            RolesTableSeeder::class,
            TrabajosTableSeeder::class,
            UsersTableSeeder::class,
            EnfoquesTableSeeder::class
        ]);
    }
}
