<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fase extends Model
{
    protected $fillable = ['descripcion','orden','fecha_creacion','activo','id_compania'];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'fases';
    public $timestamps = false;
}
