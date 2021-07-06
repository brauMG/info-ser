<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $fillable = ['rol','fecha_creacion','activo'];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table = 'Roles';
    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
