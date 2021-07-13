<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    protected $fillable = ['descripcion','fecha_creacion','activo'];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'trabajos';
    public $timestamps = false;
}
