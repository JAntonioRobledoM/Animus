<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animus - Panel Principal</title>
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
            
            <div class="flex items-center">
                <span class="mr-6 text-sm opacity-80">Usuario: {{ auth()->user()->name }}</span>
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
        <h1 class="text-3xl font-semibold mb-8 text-abstergo-blue border-b border-abstergo-blue/30 pb-2">
            Panel de Control del Animus
        </h1>
        
        <!-- Sistema de recuerdos -->
        <section class="mb-10">
            <h2 class="text-xl font-semibold mb-4">Recuerdos Disponibles</h2>
            
            @if($recuerdos->isEmpty())
                <p class="bg-abstergo-blue/10 border border-abstergo-blue/30 rounded p-4">
                    No hay recuerdos genéticos disponibles. Contacte al supervisor de Abstergo para cargar secuencias genéticas.
                </p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($recuerdos as $recuerdo)
                        <div class="bg-black/50 border border-abstergo-blue/40 rounded overflow-hidden hover:shadow-md hover:shadow-abstergo-blue/20 transition-all">
                            @if($recuerdo->img)
                                <img src="{{ asset($recuerdo->img) }}" alt="{{ $recuerdo->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-r from-abstergo-dark to-abstergo-gray flex items-center justify-center">
                                    <span class="text-abstergo-blue opacity-50 text-xl">Sin imagen</span>
                                </div>
                            @endif
                            
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-1">{{ $recuerdo->title }}</h3>
                                @if($recuerdo->subtitle)
                                    <p class="text-sm text-gray-400 mb-3">{{ $recuerdo->subtitle }}</p>
                                @endif
                                
                                <div class="flex justify-between items-center mt-4">
                                    <span class="text-xs opacity-70">Posición: {{ $recuerdo->position }}</span>
                                    <a href="{{ $recuerdo->path ?? '#' }}" class="bg-abstergo-blue px-4 py-2 text-sm rounded hover:bg-abstergo-light-blue transition-colors">
                                        Sincronizar
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </main>
    
    <!-- Pie de página -->
    <footer class="bg-black/80 border-t border-abstergo-blue py-4 px-6 text-center text-sm opacity-70 mt-auto">
        <p>ABSTERGO INDUSTRIES &copy; {{ date('Y') }} - ANIMUS OS v4.27</p>
        <p class="mt-1">SISTEMA DE RECUPERACIÓN DE MEMORIAS GENÉTICAS</p>
    </footer>
</body>
</html>