<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class IndicadorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('indicadores')->insert([
            'id' => '1',
            'descripcion' => 'Dinero',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('indicadores')->insert([
            'id' => '2',
            'descripcion' => 'Tiempo',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('indicadores')->insert([
            'id' => '3',
            'descripcion' => 'Unidades Producidas',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('indicadores')->insert([
            'id' => '4',
            'descripcion' => 'Calidad',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('indicadores')->insert([
            'id' => '5',
            'descripcion' => 'Nivel de Servicio',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('indicadores')->insert([
            'id' => '6',
            'descripcion' => 'Porcentaje',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
    }
}
