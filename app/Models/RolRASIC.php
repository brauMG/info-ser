<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolRASIC extends Model
{
    protected $fillable = ['rol_rasic','fecha_creacion','activo'];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'RolesRASIC';
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;
}
