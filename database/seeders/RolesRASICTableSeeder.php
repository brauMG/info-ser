<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class RolesRASICTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles_rasic')->insert([
            'id' => 'R',
            'rol_rasic' => 'Responsable',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('roles_rasic')->insert([
            'id' => 'A',
            'rol_rasic' => 'Aprobador',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('roles_rasic')->insert([
            'id' => 'S',
            'rol_rasic' => 'Soporte',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('roles_rasic')->insert([
            'id' => 'I',
            'rol_rasic' => 'Informar',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('roles_rasic')->insert([
            'id' => 'C',
            'rol_rasic' => 'Consultar',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
    }
}
