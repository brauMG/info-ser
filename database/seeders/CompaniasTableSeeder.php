<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CompaniasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companias')->insert([
            'id' => '1',
            'descripcion' => 'Medtronic',
            'dominio' => 'medtronic.com',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'activo' => '1'
        ]);
    }
}
