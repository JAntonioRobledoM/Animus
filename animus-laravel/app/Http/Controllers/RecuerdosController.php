<?php

namespace App\Http\Controllers;

use App\Models\Recuerdo;
use App\Models\Saga;
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
        $sagas = Auth::user()->sagas()->orderBy('posicion')->get();
        return view('recuerdos.create', compact('sagas'));
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
            'saga_id' => 'nullable|integer|exists:sagas,id',
            'path' => 'nullable|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'lugar' => 'nullable|string|max:255',
            'necesita_app_externa' => 'nullable|boolean',
            'ruta_app_externa' => 'nullable|string|max:500',
        ]);

        $data = $request->except('img');
        $data['user_id'] = Auth::id();

        // Si no se proporciona una posición, asignar la última + 1
        if (!$request->has('position') || $request->position === null) {
            $lastPosition = Auth::user()->recuerdos()->max('position') ?? 0;
            $data['position'] = $lastPosition + 1;
        }

        // Geocodificación automática si se proporciona un lugar
        if ($request->has('lugar') && !empty($request->lugar)) {
            $coordinates = $this->geocode($request->lugar);
            if ($coordinates) {
                $data['latitud'] = $coordinates['lat'];
                $data['longitud'] = $coordinates['lon'];
            }
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

        $sagas = Auth::user()->sagas()->orderBy('posicion')->get();
        return view('recuerdos.edit', compact('recuerdo', 'sagas'));
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
            'saga_id' => 'nullable|integer|exists:sagas,id',
            'path' => 'nullable|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'lugar' => 'nullable|string|max:255',
            'necesita_app_externa' => 'nullable|boolean',
            'ruta_app_externa' => 'nullable|string|max:500',
        ]);

        $data = $request->except(['img', '_token', '_method']);

        // Geocodificación automática si se proporciona un lugar y ha cambiado
        if ($request->has('lugar') && !empty($request->lugar) && $request->lugar !== $recuerdo->lugar) {
            $coordinates = $this->geocode($request->lugar);
            if ($coordinates) {
                $data['latitud'] = $coordinates['lat'];
                $data['longitud'] = $coordinates['lon'];
            }
        }

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

    /**
     * Lanza una aplicación externa
     */
    public function lanzarAppExterna(Recuerdo $recuerdo)
    {
        // Verificar que el recuerdo pertenece al usuario actual
        $this->checkOwnership($recuerdo);

        if (!$recuerdo->necesita_app_externa || empty($recuerdo->ruta_app_externa)) {
            return response()->json([
                'success' => false,
                'message' => 'Este recuerdo no tiene una app externa configurada.'
            ], 400);
        }

        // Verificar que el archivo existe
        if (!file_exists($recuerdo->ruta_app_externa)) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró la aplicación en la ruta especificada.'
            ], 404);
        }

        try {
            $appPath = $recuerdo->ruta_app_externa;

            // Verificar extensión del archivo (permitir .url para accesos directos de Windows)
            $extension = strtolower(pathinfo($appPath, PATHINFO_EXTENSION));
            if (!in_array($extension, ['exe', 'bat', 'cmd', 'com', 'url', 'lnk'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tipo de archivo no permitido. Solo .exe, .bat, .cmd, .com, .url o .lnk'
                ], 400);
            }

            // Detectar SO
            $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

            if ($isWindows) {
                // Para Windows: usar "start" para ejecutar en background
                // Usar cmd /c para asegurar que se ejecuta correctamente
                $command = 'cmd /c start "" "' . str_replace('"', '\"', $appPath) . '"';

                // Usar proc_open para mejor manejo de procesos
                $descriptorspec = array(
                    0 => array("pipe", "r"),  // stdin
                    1 => array("pipe", "w"),  // stdout
                    2 => array("pipe", "w")   // stderr
                );

                $process = proc_open($command, $descriptorspec, $pipes);

                if (is_resource($process)) {
                    // Cerrar los pipes
                    fclose($pipes[0]);
                    fclose($pipes[1]);
                    fclose($pipes[2]);

                    // No esperamos a que termine el proceso (background)
                    proc_close($process);
                } else {
                    throw new \Exception('No se pudo crear el proceso');
                }
            } else {
                // Para Linux/Mac: usar exec en background
                $command = 'nohup ' . escapeshellarg($appPath) . ' > /dev/null 2>&1 &';
                exec($command);
            }

            return response()->json([
                'success' => true,
                'message' => 'Aplicación externa iniciada correctamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al iniciar la aplicación: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Geocodifica una dirección usando la API de Nominatim (OpenStreetMap)
     *
     * @param string $address La dirección a geocodificar (ciudad, país, región)
     * @return array|null Coordenadas ['lat' => ..., 'lon' => ...] o null si falla
     */
    private function geocode($address)
    {
        try {
            // Construir la URL para la API de Nominatim
            $url = 'https://nominatim.openstreetmap.org/search?' . http_build_query([
                'q' => $address,
                'format' => 'json',
                'limit' => 1,
                'addressdetails' => 0
            ]);

            // Configurar el contexto HTTP con un User-Agent (requerido por Nominatim)
            $context = stream_context_create([
                'http' => [
                    'header' => "User-Agent: Animus-Laravel/1.0\r\n"
                ]
            ]);

            // Realizar la petición
            $response = @file_get_contents($url, false, $context);

            if ($response === false) {
                return null;
            }

            $data = json_decode($response, true);

            // Si se encontraron resultados, devolver las coordenadas
            if (!empty($data) && isset($data[0]['lat']) && isset($data[0]['lon'])) {
                return [
                    'lat' => $data[0]['lat'],
                    'lon' => $data[0]['lon']
                ];
            }

            return null;
        } catch (\Exception $e) {
            // En caso de error, registrar y devolver null
            \Log::error('Error en geocodificación: ' . $e->getMessage());
            return null;
        }
    }
}