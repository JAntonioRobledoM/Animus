<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Recuerdo;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    /**
     * Constructor con middleware de autenticación
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Muestra el dashboard principal del Animus con los recuerdos del usuario actual
     */
    public function index(Request $request)
    {
        // Obtener parámetros de ordenación
        $sort = $request->query('sort', 'position');
        $direction = $request->query('direction', 'asc');
        $validSorts = ['position', 'year'];
        $validDirections = ['asc', 'desc'];

        // Validar parámetros
        if (!in_array($sort, $validSorts)) {
            $sort = 'position';
        }
        if (!in_array($direction, $validDirections)) {
            $direction = 'asc';
        }

        // Obtener solo los recuerdos del usuario autenticado, ordenados según los parámetros
        $recuerdos = Auth::user()->recuerdos()->orderBy($sort, $direction)->get();
        
        return view('dashboard', [
            'recuerdos' => $recuerdos
        ]);
    }
}