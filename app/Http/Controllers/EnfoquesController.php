<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Companias;
use App\Models\Enfoques;
use Illuminate\Support\Facades\DB;

class EnfoquesController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function index(){
            $compania=Companias::where('id',Auth::user()->id_compania)->first();
            $enfoque= Enfoques::all();
            return view('pages.enfoques.index',['enfoque'=>$enfoque,'compania'=>$compania]);
    }
}
