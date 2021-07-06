<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'id' => '1',
            'rol' => 'Super Administrador',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('roles')->insert([
            'id' => '2',
            'rol' => 'Administrador',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('roles')->insert([
            'id' => '3',
            'rol' => 'Usuario',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('roles')->insert([
            'id' => '4',
            'rol' => 'PMO',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('roles')->insert([
            'id' => '5',
            'rol' => 'Presidente',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('roles')->insert([
            'id' => '6',
            'rol' => 'Director',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('roles')->insert([
            'id' => '7',
            'rol' => 'Gerente',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
    }
}
