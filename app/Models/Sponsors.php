<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsors extends Model
{
    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $table = 'patrocinadores';

    protected $fillable = [
        'nombre', 'description', 'enlace', 'imagen', 'mostrar'
    ];

    public function companies()
    {
        return $this->belongsToMany(Sponsors::class, 'patrocinadores_companias', 'id_patrocinador','id_compania');
    }
}
