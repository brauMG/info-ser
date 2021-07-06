<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorsCompanies extends Model
{
    public $table  = "patrocinadores_companias";
    public $timestamps = false;
    protected $fillable = [
        'id','id_compania'
    ];
}
