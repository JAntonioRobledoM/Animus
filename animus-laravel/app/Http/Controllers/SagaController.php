<?php

namespace App\Http\Controllers;

use App\Models\Saga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SagaController extends Controller
{
    /**
     * Mostrar todas las sagas del usuario.
     */
    public function index()
    {
        $sagas = Auth::user()->sagas()->orderBy('posicion')->get();
        return view('sagas.index', compact('sagas'));
    }

    /**
     * Mostrar formulario para crear nueva saga.
     */
    public function create()
    {
        return view('sagas.create');
    }

    /**
     * Guardar nueva saga.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'color' => 'nullable|string|max:7',
        ]);

        $saga = new Saga();
        $saga->user_id = Auth::id();
        $saga->nombre = $validated['nombre'];
        $saga->descripcion = $validated['descripcion'] ?? null;
        $saga->color = $validated['color'] ?? '#00a8ff';
        $saga->posicion = Auth::user()->sagas()->count();
        $saga->save();

        return redirect('/sagas')->with('success', 'Saga creada exitosamente');
    }

    /**
     * Mostrar formulario para editar saga.
     */
    public function edit(Saga $saga)
    {
        $this->authorize('update', $saga);
        return view('sagas.edit', compact('saga'));
    }

    /**
     * Actualizar saga.
     */
    public function update(Request $request, Saga $saga)
    {
        $this->authorize('update', $saga);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'color' => 'nullable|string|max:7',
        ]);

        $saga->update($validated);

        return redirect('/sagas')->with('success', 'Saga actualizada exitosamente');
    }

    /**
     * Eliminar saga.
     */
    public function destroy(Saga $saga)
    {
        $this->authorize('delete', $saga);
        $saga->delete();

        return redirect('/sagas')->with('success', 'Saga eliminada exitosamente');
    }
}
