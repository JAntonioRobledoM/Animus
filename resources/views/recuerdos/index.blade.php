<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animus - Gestión de Recuerdos</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'abstergo-blue': '#0082CA',
                        'abstergo-light-blue': '#00a8ff',
                        'abstergo-dark': '#121212',
                        'abstergo-gray': '#333333',
                    },
                    fontFamily: {
                        'rajdhani': ['Rajdhani', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-abstergo-dark font-rajdhani text-white flex flex-col min-h-screen">
    <!-- Barra de navegación superior -->
    <nav class="bg-black/80 border-b border-abstergo-blue py-4 px-6">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ asset('images/abstergo-logo.png') }}" alt="Abstergo" class="h-8 mr-4">
                <span class="text-2xl font-semibold text-abstergo-blue tracking-wider">ANIMUS OS</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard') }}" class="text-white hover:text-abstergo-blue transition-colors">
                    Dashboard
                </a>
                <a href="{{ route('recuerdos.index') }}" class="text-abstergo-blue border-b border-abstergo-blue">
                    Gestionar Recuerdos
                </a>
                <span class="mx-4 text-sm opacity-80">Usuario: {{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-abstergo-blue/20 hover:bg-abstergo-blue/30 text-white px-4 py-2 rounded transition-all">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </nav>
    
    <!-- Contenido principal -->
    <main class="container mx-auto px-4 py-6 flex-grow">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-semibold text-abstergo-blue">
                Gestión de Recuerdos Genéticos
            </h1>
            <a href="{{ route('recuerdos.create') }}" class="bg-abstergo-blue hover:bg-abstergo-light-blue text-white px-4 py-2 rounded transition-colors">
                Añadir Nuevo Recuerdo
            </a>
        </div>
        
        <!-- Mensajes de notificación -->
        @if(session('success'))
            <div class="bg-green-900/20 border-l-4 border-green-500 p-4 mb-6 text-green-300">
                {{ session('success') }}
            </div>
        @endif
        
        <!-- Tabla de recuerdos -->
        <div class="bg-black/50 border border-abstergo-blue/40 rounded-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-abstergo-blue/20 border-b border-abstergo-blue/40">
                    <tr>
                        <th class="py-3 px-4 text-left">Imagen</th>
                        <th class="py-3 px-4 text-left">Título</th>
                        <th class="py-3 px-4 text-left">Subtítulo</th>
                        <th class="py-3 px-4 text-left">Posición</th>
                        <th class="py-3 px-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recuerdos as $recuerdo)
                        <tr class="border-b border-abstergo-gray/30 hover:bg-abstergo-blue/10 transition-colors">
                            <td class="py-3 px-4">
                                @if($recuerdo->img)
                                    <img src="{{ asset($recuerdo->img) }}" alt="{{ $recuerdo->title }}" class="w-16 h-16 object-cover rounded">
                                @else
                                    <div class="w-16 h-16 bg-abstergo-gray/30 rounded flex items-center justify-center">
                                        <span class="text-abstergo-blue/50 text-xs">Sin imagen</span>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3 px-4">{{ $recuerdo->title }}</td>
                            <td class="py-3 px-4">{{ $recuerdo->subtitle ?? '—' }}</td>
                            <td class="py-3 px-4">{{ $recuerdo->position }}</td>
                            <td class="py-3 px-4 flex justify-center space-x-2">
                                <a href="{{ route('recuerdos.show', $recuerdo) }}" class="bg-abstergo-blue/30 hover:bg-abstergo-blue/40 text-white px-3 py-1 rounded text-sm transition-colors">
                                    Ver
                                </a>
                                <a href="{{ route('recuerdos.edit', $recuerdo) }}" class="bg-yellow-600/30 hover:bg-yellow-600/40 text-white px-3 py-1 rounded text-sm transition-colors">
                                    Editar
                                </a>
                                <form action="{{ route('recuerdos.destroy', $recuerdo) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este recuerdo?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-800/30 hover:bg-red-800/40 text-white px-3 py-1 rounded text-sm transition-colors">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-400">
                                No hay recuerdos genéticos almacenados. 
                                <a href="{{ route('recuerdos.create') }}" class="text-abstergo-blue hover:underline">
                                    Añade tu primer recuerdo
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
    
    <!-- Pie de página -->
    <footer class="bg-black/80 border-t border-abstergo-blue py-4 px-6 text-center text-sm opacity-70 mt-auto">
        <p>ABSTERGO INDUSTRIES &copy; {{ date('Y') }} - ANIMUS OS v0.3</p>
        <p class="mt-1">SISTEMA DE RECUPERACIÓN DE MEMORIAS GENÉTICAS</p>
    </footer>
</body>
</html>