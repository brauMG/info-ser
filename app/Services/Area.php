<?php


namespace App\Services;

use App\Areas;
use Illuminate\Support\Facades\Auth;

class Area
{
    public function get(){
        $user = auth()->user();
        $userCompany = $user->Clave_Compania;
        $areas = Areas::where('Areas.Clave_Compania','=',$userCompany)->get();
        $areasArray[''] = 'Selecciona un área';
        foreach ($areas as $area) {
            $areasArray[$area->Clave] = $area->Descripcion;
        }
        return $areasArray;
    }
}
