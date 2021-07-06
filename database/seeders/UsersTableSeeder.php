<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([
            'id_compania' => '1',
            'iniciales' => 'EG',
            'nombres' => 'Enrique Gamez',
            'email' => 'veyriko@gmail.com',
            'id_area' => null,
            'id_puesto' => null,
            'id_rol' => 1,
            'password' => Hash::make('asdasdasd'),
            'ultima_sesion' => null,
            'activo' => '1',
            'envio_de_correo' => false,
            'email_verified_at' => now(),
            'fecha_creacion' => now(),
            'created_at' => now(),
            'remember_token' => Str::random(10)
        ]);
        DB::table('usuarios')->insert([
            'id_compania' => '1',
            'iniciales' => 'AS',
            'nombres' => 'Arturo Solis',
            'email' => 'arturo@gmail.com',
            'id_area' => null,
            'id_puesto' => null,
            'id_rol' => 2,
            'password' => Hash::make('asdasdasd'),
            'ultima_sesion' => null,
            'activo' => '1',
            'envio_de_correo' => false,
            'email_verified_at' => now(),
            'fecha_creacion' => now(),
            'created_at' => now(),
            'remember_token' => Str::random(10)
        ]);
        DB::table('usuarios')->insert([
            'id_compania' => '1',
            'iniciales' => 'RG',
            'nombres' => 'Ruben Garcia',
            'email' => 'ruben@gmail.com',
            'id_area' => null,
            'id_puesto' => null,
            'id_rol' => 3,
            'password' => Hash::make('asdasdasd'),
            'ultima_sesion' => null,
            'activo' => '1',
            'envio_de_correo' => false,
            'email_verified_at' => now(),
            'fecha_creacion' => now(),
            'created_at' => now(),
            'remember_token' => Str::random(10)
        ]);
        DB::table('usuarios')->insert([
            'id_compania' => '1',
            'iniciales' => 'SS',
            'nombres' => 'Saul Salas',
            'email' => 'saul@gmail.com',
            'id_area' => null,
            'id_puesto' => null,
            'id_rol' => 4,
            'password' => Hash::make('asdasdasd'),
            'ultima_sesion' => null,
            'activo' => '1',
            'envio_de_correo' => false,
            'email_verified_at' => now(),
            'fecha_creacion' => now(),
            'created_at' => now(),
            'remember_token' => Str::random(10)
        ]);
        DB::table('usuarios')->insert([
            'id_compania' => '1',
            'iniciales' => 'BM',
            'nombres' => 'Braulio Martinez',
            'email' => 'braulio@gmail.com',
            'id_area' => null,
            'id_puesto' => null,
            'id_rol' => 5,
            'password' => Hash::make('asdasdasd'),
            'ultima_sesion' => null,
            'activo' => '1',
            'envio_de_correo' => false,
            'email_verified_at' => now(),
            'fecha_creacion' => now(),
            'created_at' => now(),
            'remember_token' => Str::random(10)
        ]);
        DB::table('usuarios')->insert([
            'id_compania' => '1',
            'iniciales' => 'AV',
            'nombres' => 'Alan Vazquez',
            'email' => 'alan@gmail.com',
            'id_area' => null,
            'id_puesto' => null,
            'id_rol' => 6,
            'password' => Hash::make('asdasdasd'),
            'ultima_sesion' => null,
            'activo' => '1',
            'envio_de_correo' => false,
            'email_verified_at' => now(),
            'fecha_creacion' => now(),
            'created_at' => now(),
            'remember_token' => Str::random(10)
        ]);
        DB::table('usuarios')->insert([
            'id_compania' => '1',
            'iniciales' => 'RM',
            'nombres' => 'Roberto Muñoz',
            'email' => 'roberto@gmail.com',
            'id_area' => null,
            'id_puesto' => null,
            'id_rol' => 7,
            'password' => Hash::make('asdasdasd'),
            'ultima_sesion' => null,
            'activo' => '1',
            'envio_de_correo' => false,
            'email_verified_at' => now(),
            'fecha_creacion' => now(),
            'created_at' => now(),
            'remember_token' => Str::random(10)
        ]);
    }
}
