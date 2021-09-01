<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $fillable = ['id_compania','id_proyecto','decision','descricion','id_usuario','id_fase','id_etapa', 'fecha_vencimiento', 'hora_vencimiento', 'estado', 'fecha_revision', 'hora_revision', 'fecha_creacion', 'evidence_url'];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'actividades';
    public $timestamps = false;
}
