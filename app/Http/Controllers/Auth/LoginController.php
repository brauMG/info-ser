<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use DateTime;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'email';
    }

    protected function authenticated(Request $request, $user)
    {
        $now = new DateTime();
        $user->ultima_sesion = $now;
        $user->save();

        if ($user->id_rol == 1) {
            return redirect('/compania');
        }
        elseif ($user->id_rol == 2) {
            return redirect('/areas');
        }
        elseif ($user->id_rol == 3) {
            return redirect('/proyectos');
        }
        elseif ($user->id_rol == 4) {
            return redirect('/proyectos');
        }
        elseif ($user->id_rol == 5) {
            return redirect('/proyectos');
        }
        elseif ($user->id_rol == 6) {
            return redirect('/proyectos');
        }
        elseif ($user->id_rol == 7) {
            return redirect('/proyectos');
        }
        else {
            return redirect('/login');
        }
    }
}
