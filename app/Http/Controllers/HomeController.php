<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gestion;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $gestionActiva = Gestion::where('anio', now()->year)
                                ->where('estado', true)
                                ->first();

        return view('home', compact('gestionActiva'));
    }
}
