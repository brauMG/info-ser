<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TrabajosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trabajos')->insert([
            'id' => '1',
            'descripcion' => 'Operaciones',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('trabajos')->insert([
            'id' => '2',
            'descripcion' => 'Administrativo',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('trabajos')->insert([
            'id' => '3',
            'descripcion' => 'Proyectos',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('trabajos')->insert([
            'id' => '4',
            'descripcion' => 'Iniciativas',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
    }
}
