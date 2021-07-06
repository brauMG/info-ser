<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etapas extends Model
{
    protected $fillable = ['id_proyecto','id_fase','descripcion','fecha_vencimiento','hora_vencimiento', 'id_compania'];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'Etapas';
    public $timestamps = true;
}
