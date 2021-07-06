<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_compania',
        'iniciales',
        'nombres',
        'email',
        'id_area',
        'id_puesto',
        'id_rol',
        'password',
        'ultima_sesion',
        'fecha_creacion',
        'activo',
        'envio_de_correo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $guarded = ['id'];
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public function getAuthPassword()
    {
        return $this->password;
    }
}
