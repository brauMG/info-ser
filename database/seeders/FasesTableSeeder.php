<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class FasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fases')->insert([
            'id' => '1',
            'descripcion' => 'Definición',
            'orden' => '1',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('fases')->insert([
            'id' => '2',
            'descripcion' => 'Medición',
            'orden' => '2',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('fases')->insert([
            'id' => '3',
            'descripcion' => 'Análisis',
            'orden' => '3',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('fases')->insert([
            'id' => '4',
            'descripcion' => 'Implementación',
            'orden' => '4',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('fases')->insert([
            'id' => '5',
            'descripcion' => 'Control',
            'orden' => '5',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('fases')->insert([
            'id' => '6',
            'descripcion' => 'Todas',
            'orden' => '6',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
    }
}
