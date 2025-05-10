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
    public function index()
    {
        // Obtener solo los recuerdos del usuario autenticado
        $recuerdos = Auth::user()->recuerdos()->orderBy('position', 'asc')->get();
        
        return view('dashboard', [
            'recuerdos' => $recuerdos
        ]);
    }
}