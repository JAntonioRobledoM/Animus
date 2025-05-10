<?php
// Ruta: app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Muestra la vista de login.
     */
    public function showLoginForm()
    {
        // Si el usuario ya está autenticado, redirigir al dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
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
        
        return redirect('/');
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