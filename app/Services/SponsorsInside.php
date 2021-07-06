<?php


namespace App\Services;


use App\Sponsors;

class SponsorsInside
{
    public function get(){
        $user = auth()->user();
        $userCompany = $user->Clave_Compania;

        $sponsors = Sponsors::select('sponsors.*')
            ->join('sponsors_companies', 'sponsors_companies.sponsorId', '=', 'sponsors.sponsorId')
            ->where('sponsors_companies.companyId', $userCompany)
            ->get();

        return $sponsors;
    }
}
