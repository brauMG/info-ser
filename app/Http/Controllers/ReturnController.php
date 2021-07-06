<?php


namespace App\Http\Controllers;


use App\Compania;
use Illuminate\Support\Facades\Auth;

class ReturnController extends Controller
{
    public function __invoke()
    {
        if (Auth::user()) {
            $rol = Auth::user()->Clave_Rol;
            if ($rol == 1) {
                return redirect('/Admin/Compania');
            } elseif ($rol == 2) {
                return redirect('/Admin/Areas');
            } elseif ($rol == 3) {
                return redirect('/Admin/Proyectos');
            } elseif ($rol == 4) {
                return redirect('/Admin/Proyectos');
            }
        } else {
            return redirect('/login');
        }
    }
}
