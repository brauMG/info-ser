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
     * @return \Illuminate\View\View
     */
    public function index()
    {

    }

    public function selectCompany(Request $request)
    {
        $companias = Companias::all();
        $userCompany = Auth::user()->id;
        return view('Shared.SelectCompany', compact('companias', 'userCompany'));
    }
}
