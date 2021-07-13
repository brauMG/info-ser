<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
    protected $fillable = ['id_companias','descripcion','fecha_creacion','activo'];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'areas';
    public $timestamps = false;
}
