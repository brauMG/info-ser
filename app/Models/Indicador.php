<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indicador extends Model
{
    protected $fillable = ['descripcion','fecha_descripcion','activo','id_compania'];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'indicadores';
    public $timestamps = false;
}
