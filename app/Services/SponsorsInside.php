<?php


namespace App\Services;


use App\Models\Sponsors;

class SponsorsInside
{
    public function get(){
        $user = auth()->user();
        $userCompany = $user->id_compania;

        $sponsors = Sponsors::select('patrocinadores.*')
            ->join('patrocinadores_companias', 'patrocinadores_companias.id_patrocinador', '=', 'patrocinadores.id')
            ->where('patrocinadores_companias.id_compania', $userCompany)
            ->get();

        return $sponsors;
    }
}
