<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['estado','fecha_creacion','activo','id_compania'];
    protected $guarded = ['id'];
    protected $table = 'estado';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
