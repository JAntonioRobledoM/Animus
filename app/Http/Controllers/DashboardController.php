<?php
// Ruta: app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recuerdo;

use Illuminate\Routing\Controller as BaseController;

class DashboardController extends BaseController
{
    /**
     * Constructor con middleware de autenticación
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Muestra el dashboard principal del Animus
     */
    public function index()
    {
        $recuerdos = Recuerdo::orderBy('position', 'asc')->get();
        
        return view('dashboard', [
            'recuerdos' => $recuerdos
        ]);
    }
}