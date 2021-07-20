<?php

namespace App\Http\Controllers;

use App\Models\Companias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index()
    {
        $rol = Auth::user()->id_rol;
        if ($rol == 1) {
            return redirect('/companias');
        }
        if ($rol == 2) {
            return redirect('/areas');
        }
        if ($rol == 3) {
            return redirect('/proyectos');
        }
        if ($rol == 4) {
            return redirect('/proyectos');
        }
        if ($rol == 5) {
            return redirect('/graficas/proyectos');
        }
        if ($rol == 6) {
            return redirect('/graficas/proyectos');
        }
        if ($rol == 7) {
            return redirect('/proyectos');
        }
    }
}
