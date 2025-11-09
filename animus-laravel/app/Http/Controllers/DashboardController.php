<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Recuerdo;
use App\Models\Saga;
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
        // Obtener parámetros de ordenación y filtro
        $sort = $request->query('sort', 'position');
        $direction = $request->query('direction', 'asc');
        $sagaId = $request->query('saga_id', null);
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
        $query = Auth::user()->recuerdos();

        // Filtrar por saga si se proporciona
        if ($sagaId) {
            $query = $query->where('saga_id', $sagaId);
        }

        $recuerdos = $query->orderBy($sort, $direction)->get();

        // Obtener todas las sagas del usuario
        $sagas = Auth::user()->sagas()->orderBy('posicion')->get();

        return view('dashboard', [
            'recuerdos' => $recuerdos,
            'sagas' => $sagas,
            'sagaId' => $sagaId
        ]);
    }
}