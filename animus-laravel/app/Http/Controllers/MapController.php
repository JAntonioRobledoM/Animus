<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class MapController extends Controller
{
    /**
     * Constructor con middleware de autenticación
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra el mapa mundial con los recuerdos del usuario
     */
    public function index()
    {
        // Obtener solo los recuerdos del usuario actual que tienen ubicación
        $recuerdos = Auth::user()->recuerdos()
            ->whereNotNull('latitud')
            ->whereNotNull('longitud')
            ->whereNotNull('lugar')
            ->orderBy('year', 'asc')
            ->get();

        return view('map.index', compact('recuerdos'));
    }
}
