<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolProyecto extends Model
{
    protected $fillable = ['id_proyecto','id_fase','id_rol_rasic','id_usuario','fecha_creacion','activo'];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'roles_proyectos';
    public $timestamps = false;
}
