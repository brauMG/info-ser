<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $fillable = ['id_compania','id_director','nombre','fecha_creacion','activo'];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'direcciones';
    public $timestamps = false;
}
