<?php
// Ruta: app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Constructor para aplicar middleware
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout']);
    }
    
    /**
     * Muestra la vista de login.
     */
    public function showLoginForm()
    {
        return view('welcome');
    }
    
    /**
     * Maneja la solicitud de login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            return redirect()->intended(route('dashboard'));
        }
        
        return back()->with('error', 'Las credenciales proporcionadas no coinciden con nuestros registros.');
    }
    
    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
    
    /**
     * Crea un usuario (solo para pruebas/desarrollo).
     * Normalmente estaría protegido o se eliminaría en producción.
     */
    public function createUser()
    {
        $user = User::where('name', 'admin')->first();
        
        if (!$user) {
            User::create([
                'name' => 'admin',
                'password' => Hash::make('admin'),
            ]);
            
            return "Usuario creado correctamente";
        }
        
        return "El usuario ya existe";
    }
}