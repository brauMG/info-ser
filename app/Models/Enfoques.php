<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enfoques extends Model
{
    protected $fillable = ['id_enfoque','descripcion','fecha_creacion','activo','id_compania'];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'Enfoques';
    public $timestamps = false;
}
