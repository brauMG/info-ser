<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class companias extends Model
{
    protected $fillable = ['descripcion','fecha_creacion','activo','dominio'];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'companias';
    public $timestamps = false;
}
