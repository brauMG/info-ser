<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $fillable = ['id_compania','descripcion','criterio','id_estado','id_area','id_fase','id_enfoque','id_trabajo','id_indicador','objetivo','fecha_creacion','activo'];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'Proyectos';
    public $timestamps = false;
}
