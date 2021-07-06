<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gerencia extends Model
{
    protected $fillable = ['id_compania','id_direccion','id_gerente','nombre','fecha_creacion','activo'];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'gerencias';
    public $timestamps = false;
}
