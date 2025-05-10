<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animus - {{ $recuerdo->title }}</title>
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
                <a href="{{ route('recuerdos.index') }}" class="text-white hover:text-abstergo-blue transition-colors">
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
        <div class="flex items-center mb-8">
            <a href="{{ route('recuerdos.index') }}" class="text-abstergo-blue hover:text-abstergo-light-blue mr-4">
                &larr; Volver a la lista
            </a>
            <h1 class="text-3xl font-semibold text-abstergo-blue">
                Detalles del Recuerdo
            </h1>
        </div>
        
        <!-- Tarjeta de detalles -->
        <div class="bg-black/50 border border-abstergo-blue/40 rounded-lg overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <!-- Imagen del recuerdo -->
                <div class="h-80 bg-abstergo-dark flex items-center justify-center p-4">
                    @if($recuerdo->img)
                        <img src="{{ asset($recuerdo->img) }}" alt="{{ $recuerdo->title }}" class="max-h-full max-w-full object-contain">
                    @else
                        <div class="w-full h-full bg-gradient-to-r from-abstergo-dark to-abstergo-gray flex items-center justify-center">
                            <span class="text-abstergo-blue opacity-50 text-xl">Sin imagen</span>
                        </div>
                    @endif
                </div>
                
                <!-- Información del recuerdo -->
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-abstergo-blue mb-2">{{ $recuerdo->title }}</h2>
                    
                    @if($recuerdo->subtitle)
                        <p class="text-gray-300 mb-4">{{ $recuerdo->subtitle }}</p>
                    @endif
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-abstergo-light-blue text-sm">Posición</p>
                            <p>{{ $recuerdo->position }}</p>
                        </div>
                        <div>
                            <p class="text-abstergo-light-blue text-sm">Ruta</p>
                            <p class="break-all">{{ $recuerdo->path }}</p>
                        </div>
                        <div>
                            <p class="text-abstergo-light-blue text-sm">Creado</p>
                            <p>{{ $recuerdo->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-abstergo-light-blue text-sm">Actualizado</p>
                            <p>{{ $recuerdo->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <!-- Acciones -->
                    <div class="flex justify-between space-x-3 border-t border-abstergo-blue/30 pt-4 mt-4">
                        <a href="{{ $recuerdo->path }}" class="flex-1 bg-abstergo-blue hover:bg-abstergo-light-blue text-white py-2 px-4 rounded text-center transition-colors">
                            Sincronizar Recuerdo
                        </a>
                        <a href="{{ route('recuerdos.edit', $recuerdo->id) }}" class="flex-1 bg-yellow-600/50 hover:bg-yellow-600/60 text-white py-2 px-4 rounded text-center transition-colors">
                            Editar
                        </a>
                        <form action="{{ route('recuerdos.destroy', $recuerdo->id) }}" method="POST" class="flex-1" onsubmit="return confirm('¿Estás seguro de eliminar este recuerdo? Esta acción no se puede deshacer.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-800/50 hover:bg-red-800/60 text-white py-2 px-4 rounded transition-colors">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Pie de página (siempre al fondo) -->
    <footer class="bg-black/80 border-t border-abstergo-blue py-4 px-6 text-center text-sm opacity-70 mt-auto">
        <p>ABSTERGO INDUSTRIES &copy; {{ date('Y') }} - ANIMUS OS v4.27</p>
        <p class="mt-1">SISTEMA DE RECUPERACIÓN DE MEMORIAS GENÉTICAS</p>
    </footer>
</body>
</html>