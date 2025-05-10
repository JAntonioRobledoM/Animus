<?php

namespace App\Http\Controllers;

use App\Models\Recuerdo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Routing\Controller;

class RecuerdosController extends Controller
{
    /**
     * Constructor con middleware de autenticación
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra la lista de recuerdos del usuario
     */
    public function index()
    {
        $recuerdos = Auth::user()->recuerdos()->orderBy('position', 'asc')->get();
        return view('recuerdos.index', compact('recuerdos'));
    }

    /**
     * Muestra el formulario para crear un nuevo recuerdo
     */
    public function create()
    {
        return view('recuerdos.create');
    }

    /**
     * Almacena un nuevo recuerdo en la base de datos
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'position' => 'nullable|integer',
            'path' => 'nullable|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('img');
        $data['user_id'] = Auth::id();

        // Si no se proporciona una posición, asignar la última + 1
        if (!$request->has('position') || $request->position === null) {
            $lastPosition = Auth::user()->recuerdos()->max('position') ?? 0;
            $data['position'] = $lastPosition + 1;
        }

        // Manejo de la imagen (si se proporciona)
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/recuerdos'), $imageName);
            $data['img'] = 'images/recuerdos/' . $imageName;
        }

        // Usar la ruta proporcionada directamente o generar una predeterminada
        if (!$request->has('path') || empty($request->path)) {
            // Generar una ruta predeterminada solo si no se proporcionó ninguna
            $data['path'] = '/recuerdo/' . strtolower(str_replace(' ', '-', $request->title));
        }

        Recuerdo::create($data);

        return redirect()->route('recuerdos.index')
            ->with('success', 'Recuerdo creado exitosamente.');
    }

    /**
     * Muestra un recuerdo específico
     */
    public function show(Recuerdo $recuerdo)
    {
        // Verificar que el recuerdo pertenece al usuario actual
        $this->checkOwnership($recuerdo);

        return view('recuerdos.show', compact('recuerdo'));
    }

    /**
     * Muestra el formulario para editar un recuerdo
     */
    public function edit(Recuerdo $recuerdo)
    {
        // Verificar que el recuerdo pertenece al usuario actual
        $this->checkOwnership($recuerdo);

        return view('recuerdos.edit', compact('recuerdo'));
    }

    /**
     * Actualiza un recuerdo en la base de datos
     */
    public function update(Request $request, Recuerdo $recuerdo)
    {
        // Verificar que el recuerdo pertenece al usuario actual
        $this->checkOwnership($recuerdo);

        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'position' => 'nullable|integer',
            'path' => 'nullable|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['img', '_token', '_method']);

        // Manejo de la imagen (si se proporciona una nueva)
        if ($request->hasFile('img')) {
            // Eliminar la imagen anterior si existe
            if ($recuerdo->img && file_exists(public_path($recuerdo->img))) {
                unlink(public_path($recuerdo->img));
            }

            $image = $request->file('img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/recuerdos'), $imageName);
            $data['img'] = 'images/recuerdos/' . $imageName;
        }

        // Usar la ruta proporcionada directamente (ya no la generamos automáticamente)
        // Solo actualizamos la ruta si se ha proporcionado una nueva
        if (!isset($data['path']) || empty($data['path'])) {
            // Si la ruta está vacía, usamos la anterior o generamos una basada en el título
            $data['path'] = $recuerdo->path ?: '/recuerdo/' . strtolower(str_replace(' ', '-', $request->title));
        }

        $recuerdo->update($data);

        return redirect()->route('recuerdos.index')
            ->with('success', 'Recuerdo actualizado exitosamente.');
    }

    /**
     * Elimina un recuerdo de la base de datos
     */
    public function destroy(Recuerdo $recuerdo)
    {
        // Verificar que el recuerdo pertenece al usuario actual
        $this->checkOwnership($recuerdo);

        // Eliminar la imagen si existe
        if ($recuerdo->img && file_exists(public_path($recuerdo->img))) {
            unlink(public_path($recuerdo->img));
        }

        $recuerdo->delete();

        return redirect()->route('recuerdos.index')
            ->with('success', 'Recuerdo eliminado exitosamente.');
    }

    /**
     * Verifica que el recuerdo pertenece al usuario autenticado
     */
    private function checkOwnership(Recuerdo $recuerdo)
    {
        if ($recuerdo->user_id !== Auth::id()) {
            abort(403, 'No estás autorizado para acceder a este recuerdo.');
        }
    }

    /**
     * Visualiza un recuerdo en modo Animus (por slug)
     */
    public function visualizar($slug)
    {
        // Extraer el título del slug
        $title = str_replace('-', ' ', $slug);

        // Buscar el recuerdo por título y usuario actual
        $recuerdo = Auth::user()->recuerdos()
            ->where('title', 'LIKE', $title)
            ->orWhere(function ($query) use ($slug) {
                $query->where('path', 'LIKE', '%' . $slug . '%')
                    ->where('user_id', Auth::id());
            })
            ->firstOrFail();

        return view('recuerdos.visualizar', compact('recuerdo'));
    }
}