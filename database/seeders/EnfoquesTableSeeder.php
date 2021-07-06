<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class EnfoquesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('enfoques')->insert([
            'id' => '1',
            'descripcion' => 'Calidad',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('enfoques')->insert([
            'id' => '2',
            'descripcion' => 'Gente',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('enfoques')->insert([
            'id' => '3',
            'descripcion' => 'Costo',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('enfoques')->insert([
            'id' => '4',
            'descripcion' => 'Servicio',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
        DB::table('enfoques')->insert([
            'id' => '5',
            'descripcion' => 'Crecimiento',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
    }
}
