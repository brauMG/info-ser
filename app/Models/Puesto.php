<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    protected $fillable = ['id_companias','descripcion','fecha_creacion','activo'];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'puestos';
    public $timestamps = false;
}
