<?php


namespace App\Services;

class Sponsors
{
    public function get(){
        $sponsors = \App\Sponsors::all()->where('show', '=', 1);
        return $sponsors;
    }
}
