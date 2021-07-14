<?php


namespace App\Services;

use App\Models\Companias;
use Illuminate\Support\Facades\Auth;

class GetCompany
{
    public function get(){
        $user = Auth::user();
        $userCompany = $user->id_compania;
        $company = Companias::where('companias.id', '=', $userCompany)->get();
        $company = $company[0]['descripcion'];
        return $company;
    }
}
