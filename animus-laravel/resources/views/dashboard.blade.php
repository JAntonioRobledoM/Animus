<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animus - Panel Principal</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'abstergo-blue': '#0082CA',
                        'abstergo-light-blue': '#00a8ff',
                        'abstergo-dark': '#0a0a0a',
                        'abstergo-gray': '#1a1a1a',
                        'abstergo-accent': '#00d4ff',
                        'abstergo-gold': '#ffd700',
                    },
                    fontFamily: {
                        'rajdhani': ['Rajdhani', 'sans-serif'],
                        'orbitron': ['Orbitron', 'monospace'],
                    },
                    animation: {
                        'pulse-blue': 'pulse-blue 2s ease-in-out infinite',
                        'glow': 'glow 2s ease-in-out infinite alternate',
                        'scan': 'scan 3s ease-in-out infinite',
                        'matrix': 'matrix 20s linear infinite',
                        'spin-slow': 'spin 2s linear infinite',
                    },
                    keyframes: {
                        'pulse-blue': {
                            '0%, 100%': { boxShadow: '0 0 5px #0082CA' },
                            '50%': { boxShadow: '0 0 20px #0082CA, 0 0 30px #0082CA' },
                        },
                        'glow': {
                            'from': { textShadow: '0 0 10px #0082CA' },
                            'to': { textShadow: '0 0 20px #0082CA, 0 0 30px #00a8ff' },
                        },
                        'scan': {
                            '0%': { transform: 'translateX(-100%)' },
                            '100%': { transform: 'translateX(100vw)' },
                        },
                        'matrix': {
                            '0%': { transform: 'translateY(-100%)' },
                            '100%': { transform: 'translateY(100vh)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background: radial-gradient(ellipse at center, #0a0a0a 0%, #000000 100%);
            position: relative;
            overflow-x: hidden;
        }
        .matrix-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.1;
            pointer-events: none;
        }
        .matrix-rain {
            position: absolute;
            color: #0082CA;
            font-family: 'Orbitron', monospace;
            font-size: 14px;
            animation: matrix 20s linear infinite;
            opacity: 0.3;
        }
        .hologram-border {
            position: relative;
            border: 1px solid transparent;
            background: linear-gradient(45deg, #0082CA, #00a8ff, #0082CA) border-box;
            border-radius: 8px;
        }
        .hologram-border::before {
            content: '';
            position: absolute;
            inset: 0;
            padding: 1px;
            background: linear-gradient(45deg, #0082CA, transparent, #00a8ff);
            border-radius: inherit;
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask-composite: exclude;
        }
        .scan-line {
            position: absolute;
            top: 0;
            left: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(to bottom, transparent, #0082CA, transparent);
            animation: scan 3s ease-in-out infinite;
            opacity: 0.8;
        }
        .card-glow {
            box-shadow: 0 4px 15px rgba(0, 130, 202, 0.1);
            transition: all 0.3s ease;
        }
        .card-glow:hover {
            box-shadow: 0 8px 30px rgba(0, 130, 202, 0.3);
            transform: translateY(-5px);
        }
        .text-hologram {
            background: linear-gradient(45deg, #0082CA, #00a8ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .btn-hologram {
            background: linear-gradient(45deg, rgba(0, 130, 202, 0.2), rgba(0, 168, 255, 0.2));
            border: 1px solid #0082CA;
            position: relative;
            overflow: hidden;
        }
        .btn-hologram::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        .btn-hologram:hover::before {
            left: 100%;
        }
        .progress-glow {
            box-shadow: 0 0 10px #0082CA, inset 0 0 10px #0082CA;
        }
        .btn-hologram:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>
<body class="bg-abstergo-dark font-rajdhani text-white flex flex-col min-h-screen relative">
    <!-- Fondo Matrix -->
    <div class="matrix-bg">
        <div class="matrix-rain" style="left: 5%; animation-delay: 0s;">01010101</div>
        <div class="matrix-rain" style="left: 15%; animation-delay: 2s;">11001100</div>
        <div class="matrix-rain" style="left: 25%; animation-delay: 4s;">10101010</div>
        <div class="matrix-rain" style="left: 35%; animation-delay: 1s;">01110111</div>
        <div class="matrix-rain" style="left: 45%; animation-delay: 3s;">00110011</div>
        <div class="matrix-rain" style="left: 55%; animation-delay: 5s;">11110000</div>
        <div class="matrix-rain" style="left: 65%; animation-delay: 1.5s;">10011001</div>
        <div class="matrix-rain" style="left: 75%; animation-delay: 2.5s;">01010101</div>
        <div class="matrix-rain" style="left: 85%; animation-delay: 4.5s;">11001100</div>
        <div class="matrix-rain" style="left: 95%; animation-delay: 0.5s;">10101010</div>
    </div>

    <!-- Línea de escaneo -->
    <div class="scan-line"></div>

    <!-- Barra de navegación superior -->
    <nav class="bg-black/90 border-b-2 border-abstergo-blue shadow-lg shadow-abstergo-blue/20 py-4 px-6 relative">
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-abstergo-blue/5 to-transparent"></div>
        <div class="flex justify-between items-center relative z-10">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-abstergo-blue to-abstergo-light-blue rounded-full flex items-center justify-center mr-4 animate-pulse-blue">
                    <div class="w-6 h-6 bg-white rounded-full opacity-80"></div>
                </div>
                <span class="text-3xl font-orbitron font-bold text-hologram animate-glow tracking-widest">ANIMUS OS</span>
                <div class="ml-4 text-xs text-abstergo-accent font-orbitron">v1.0</div>
            </div>
            
            <div class="flex items-center space-x-6">
                <a href="{{ route('dashboard') }}" class="text-abstergo-accent border-b-2 border-abstergo-accent px-3 py-1 font-medium tracking-wide">
                    DASHBOARD
                </a>
                <a href="{{ route('recuerdos.index') }}" class="text-white hover:text-abstergo-accent transition-all duration-300 px-3 py-1 hover:bg-abstergo-accent/10 rounded">
                    GESTIONAR RECUERDOS
                </a>
                
                <div class="flex items-center space-x-4 ml-8">
                    <div class="text-sm text-abstergo-accent font-orbitron">USUARIO:</div>
                    <div class="text-white font-medium">{{ auth()->user()->name }}</div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-hologram text-white px-4 py-2 rounded-md transition-all duration-300 hover:bg-abstergo-blue/30 font-medium">
                            CERRAR SESIÓN
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Contenido principal -->
    <main class="container mx-auto px-6 py-8 flex-grow relative z-10">
        <div class="flex justify-between items-center mb-12">
            <div>
                <h1 class="text-4xl font-orbitron font-bold text-hologram mb-2 animate-glow">
                    PANEL DE CONTROL DEL ANIMUS
                </h1>
                <div class="w-full h-1 bg-gradient-to-r from-abstergo-blue via-abstergo-accent to-transparent rounded-full"></div>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Botón para ordenar por campo -->
                <button id="sort-field-toggle" class="btn-hologram text-white px-6 py-3 rounded-lg transition-all duration-300 flex items-center space-x-3 hover:scale-105 font-medium shadow-lg">
                    <div class="w-6 h-6 bg-gradient-to-br from-abstergo-blue to-abstergo-accent rounded-full flex items-center justify-center">
                        <svg id="sort-field-icon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                        </svg>
                        <svg id="sort-field-loading" class="h-4 w-4 animate-spin-slow hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                    </div>
                    <span id="sort-field-text">ORDENAR POR {{ in_array(request()->query('sort', 'position'), ['position', 'year']) ? (request()->query('sort', 'position') == 'position' ? 'POSICIÓN' : 'AÑO') : 'POSICIÓN' }}</span>
                </button>
                <!-- Botón para ordenar dirección -->
                <button id="sort-direction-toggle" class="btn-hologram text-white px-6 py-3 rounded-lg transition-all duration-300 flex items-center space-x-3 hover:scale-105 font-medium shadow-lg">
                    <div class="w-6 h-6 bg-gradient-to-br from-abstergo-blue to-abstergo-accent rounded-full flex items-center justify-center">
                        <svg id="sort-direction-icon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ request()->query('direction', 'asc') == 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                        </svg>
                        <svg id="sort-direction-loading" class="h-4 w-4 animate-spin-slow hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                    </div>
                    <span id="sort-direction-text">ORDEN {{ request()->query('direction', 'asc') == 'asc' ? 'ASCENDENTE' : 'DESCENDENTE' }}</span>
                </button>
                <!-- Botón para añadir nuevo recuerdo -->
                <a href="{{ route('recuerdos.create') }}" class="btn-hologram text-white px-6 py-3 rounded-lg transition-all duration-300 flex items-center space-x-3 hover:scale-105 font-medium shadow-lg">
                    <div class="w-6 h-6 bg-gradient-to-br from-abstergo-blue to-abstergo-accent rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span>AÑADIR NUEVO RECUERDO</span>
                </a>
            </div>
        </div>
        
        <!-- Notificaciones -->
        @if(session('success'))
            <div class="bg-gradient-to-r from-green-500/20 to-green-600/20 border-l-4 border-green-400 p-6 mb-8 rounded-r-lg shadow-lg">
                <div class="flex items-center">
                    <div class="w-6 h-6 bg-green-400 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-black" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <span class="text-green-300 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        
        <!-- Sistema de recuerdos -->
        <section class="mb-10">
            <h2 class="text-2xl font-orbitron font-semibold mb-8 text-abstergo-accent">RECUERDOS DISPONIBLES</h2>
            
            @if($recuerdos->isEmpty())
                <div class="hologram-border bg-gradient-to-br from-abstergo-blue/10 to-abstergo-accent/10 rounded-xl p-12 text-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-abstergo-blue/5 to-transparent animate-pulse"></div>
                    <div class="relative z-10">
                        <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-abstergo-blue to-abstergo-accent rounded-full flex items-center justify-center animate-pulse-blue">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <p class="mb-8 text-xl font-medium text-white">No hay recuerdos genéticos disponibles</p>
                        <p class="mb-8 text-abstergo-accent">¿Deseas añadir tu primer recuerdo?</p>
                        <a href="{{ route('recuerdos.create') }}" class="inline-block btn-hologram px-8 py-4 text-white rounded-lg hover:scale-105 transition-all duration-300 font-medium text-lg shadow-lg">
                            AÑADIR PRIMER RECUERDO
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($recuerdos as $recuerdo)
                        <div class="card-glow bg-gradient-to-br from-black/80 to-abstergo-gray/50 hologram-border rounded-xl overflow-hidden hover:shadow-2xl transition-all duration-500 relative group">
                            <div class="absolute inset-0 bg-gradient-to-br from-abstergo-blue/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            @if($recuerdo->img)
                                <div class="relative overflow-hidden">
                                    <img src="{{ asset($recuerdo->img) }}" alt="{{ $recuerdo->title }}" class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                                </div>
                            @else
                                <div class="w-full h-56 bg-gradient-to-br from-abstergo-dark via-abstergo-gray to-abstergo-dark flex items-center justify-center relative overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-abstergo-blue/10 to-transparent animate-pulse"></div>
                                    <div class="text-center relative z-10">
                                        <svg class="w-16 h-16 text-abstergo-blue/50 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-abstergo-blue/50 text-lg font-orbitron">SIN IMAGEN</span>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="p-6 relative z-10">
                                <h3 class="text-xl font-orbitron font-semibold mb-2 text-white group-hover:text-abstergo-accent transition-colors duration-300">{{ $recuerdo->title }}</h3>
                                @if($recuerdo->subtitle)
                                    <p class="text-sm text-gray-400 mb-2 font-rajdhani">{{ $recuerdo->subtitle }}</p>
                                @endif
                                @if($recuerdo->year !== null)
                                    <p class="text-sm text-abstergo-accent mb-2 font-rajdhani">
                                        Año: {{ abs($recuerdo->year) }} {{ $recuerdo->year >= 0 ? 'd.C.' : 'a.C.' }}
                                    </p>
                                @endif
                                <p class="text-sm text-abstergo-accent mb-4 font-rajdhani">
                                    Posición: {{ $recuerdo->position }}
                                </p>
                                
                                <div class="flex justify-between items-center mt-6">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('recuerdos.show', $recuerdo) }}" class="bg-abstergo-blue/30 hover:bg-abstergo-blue/50 text-white px-3 py-2 rounded-md text-xs transition-all duration-300 font-medium border border-abstergo-blue/50">
                                            VER
                                        </a>
                                        <a href="{{ route('recuerdos.edit', $recuerdo) }}" class="bg-abstergo-gold/30 hover:bg-abstergo-gold/50 text-white px-3 py-2 rounded-md text-xs transition-all duration-300 font-medium border border-abstergo-gold/50">
                                            EDITAR
                                        </a>
                                    </div>
                                    <a href="#" class="btn-hologram px-4 py-2 text-sm rounded-md transition-all duration-300 flex items-center space-x-2 launch-game hover:scale-105 font-medium shadow-md" data-path="{{ $recuerdo->path }}">
                                        <div class="w-4 h-4 bg-gradient-to-br from-abstergo-blue to-abstergo-accent rounded-full flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            </svg>
                                        </div>
                                        <span>SINCRONIZAR</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Enlace a gestión completa de recuerdos -->
                <div class="mt-12 text-center">
                    <a href="{{ route('recuerdos.index') }}" class="inline-block btn-hologram px-8 py-4 rounded-lg transition-all duration-300 hover:scale-105 font-medium text-lg shadow-lg">
                        GESTIÓN AVANZADA DE RECUERDOS
                    </a>
                </div>
            @endif
        </section>
    </main>
    
    <!-- Pie de página -->
    <footer class="bg-black/90 border-t-2 border-abstergo-blue py-6 px-6 text-center relative mt-auto">
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-abstergo-blue/5 to-transparent"></div>
        <div class="relative z-10">
            <p class="text-abstergo-accent font-orbitron font-medium tracking-widest">ABSTERGO INDUSTRIES &copy; {{ date('Y') }} - ANIMUS OS v1.0</p>
            <p class="mt-2 text-sm text-gray-400 font-rajdhani">SISTEMA DE RECUPERACIÓN DE MEMORIAS GENÉTICAS</p>
            <div class="mt-3 w-32 h-0.5 bg-gradient-to-r from-transparent via-abstergo-blue to-transparent mx-auto"></div>
        </div>
    </footer>

    <!-- Modal de sincronización mejorado -->
    <div id="sync-modal" class="fixed inset-0 bg-black/95 flex flex-col items-center justify-center z-50 hidden backdrop-blur-sm">
        <div class="text-center relative">
            <!-- Anillo exterior giratorio -->
            <div class="w-64 h-64 border-4 border-transparent border-t-abstergo-blue border-r-abstergo-accent rounded-full animate-spin absolute inset-0"></div>
            <div class="w-48 h-48 border-2 border-transparent border-b-abstergo-blue border-l-abstergo-accent rounded-full animate-spin absolute inset-8" style="animation-direction: reverse; animation-duration: 3s;"></div>
            
            <!-- Contenido central -->
            <div class="relative z-10 pt-20">
                <div class="text-abstergo-accent text-2xl mb-8 font-orbitron font-bold tracking-widest animate-glow">INICIANDO SINCRONIZACIÓN</div>
                
                <!-- Barra de progreso holográfica -->
                <div class="w-80 h-4 bg-black/50 rounded-full overflow-hidden border border-abstergo-blue/50 mb-6">
                    <div id="progress-bar" class="h-full bg-gradient-to-r from-abstergo-blue to-abstergo-accent progress-glow rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
                
                <div id="loading-text" class="text-white font-rajdhani text-lg">Preparando secuencia genética...</div>
                
                <!-- Elementos decorativos -->
                <div class="mt-8 flex justify-center space-x-4">
                    <div class="w-2 h-2 bg-abstergo-blue rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-abstergo-accent rounded-full animate-bounce" style="animation-delay: 0.1s;"></div>
                    <div class="w-2 h-2 bg-abstergo-blue rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Función para detectar si estamos en Electron
        function isElectron() {
            return window.electron && window.electron.getVersion;
        }

        // Función para lanzar juegos
        async function launchGame(path) {
            if (!path) {
                console.error('Ruta de juego no válida');
                return;
            }
            
            console.log('Intentando lanzar juego:', path);
            
            // Mostrar modal de sincronización
            const syncModal = document.getElementById('sync-modal');
            const progressBar = document.getElementById('progress-bar');
            const loadingText = document.getElementById('loading-text');
            
            syncModal.classList.remove('hidden');
            
            // Simular progreso
            let progress = 0;
            const interval = setInterval(() => {
                progress += 5;
                progressBar.style.width = `${progress}%`;
                
                if (progress === 30) {
                    loadingText.textContent = 'Analizando datos de ADN...';
                } else if (progress === 60) {
                    loadingText.textContent = 'Inicializando entorno virtual...';
                } else if (progress === 90) {
                    loadingText.textContent = 'Abriendo aplicación externa...';
                }
                
                if (progress >= 100) {
                    clearInterval(interval);
                    
                    // Intento abrir la aplicación 
                    setTimeout(async () => {
                        try {
                            // Verificar si estamos en Electron
                            if (isElectron()) {
                                // Usar la API de Electron
                                console.log('Usando API de Electron para lanzar:', path);
                                await window.electron.launchGame(path);
                            } else {
                                // Fallback para navegador web (abrirá error de seguridad)
                                console.log('Usando navegador para intentar abrir:', path);
                                window.location.href = path;
                            }
                        } catch (error) {
                            console.error("Error al intentar abrir el juego:", error);
                            loadingText.textContent = "Error al abrir el juego. Verifica la ruta.";
                            progressBar.style.background = "linear-gradient(to right, #ff3333, #ff6666)";
                            
                            // Mantener el modal visible por 3 segundos más en caso de error
                            setTimeout(() => {
                                syncModal.classList.add('hidden');
                                progressBar.style.width = '0%';
                                progressBar.style.background = "linear-gradient(to right, #0082CA, #00a8ff)";
                                loadingText.textContent = 'Preparando secuencia genética...';
                            }, 3000);
                            return;
                        }
                        
                        // Ocultamos el modal después de iniciar la app
                        setTimeout(() => {
                            syncModal.classList.add('hidden');
                            progressBar.style.width = '0%';
                            loadingText.textContent = 'Preparando secuencia genética...';
                        }, 1000);
                    }, 500);
                }
            }, 50);
        }

        // Configurar todos los botones de sincronización y los botones de ordenar
        document.addEventListener('DOMContentLoaded', function() {
            // Seleccionar todos los botones de sincronización
            const syncButtons = document.querySelectorAll('.launch-game');
            
            syncButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Obtener la ruta del juego del atributo data-path
                    const gamePath = this.dataset.path;
                    
                    if (gamePath) {
                        launchGame(gamePath);
                    } else {
                        console.warn('Ruta de juego no válida o no encontrada');
                    }
                    
                    return false;
                });
            });
            
            // Configurar el botón de ordenar por campo
            const sortFieldButton = document.getElementById('sort-field-toggle');
            const sortFieldIcon = document.getElementById('sort-field-icon');
            const sortFieldLoading = document.getElementById('sort-field-loading');
            const sortFieldText = document.getElementById('sort-field-text');
            
            sortFieldButton.addEventListener('click', function() {
                // Mostrar estado de carga
                sortFieldButton.disabled = true;
                sortFieldIcon.classList.add('hidden');
                sortFieldLoading.classList.remove('hidden');
                sortFieldText.textContent = 'CARGANDO...';
                
                const currentSort = '{{ in_array(request()->query("sort", "position"), ["position", "year"]) ? request()->query("sort", "position") : "position" }}';
                const currentDirection = '{{ in_array(request()->query("direction", "asc"), ["asc", "desc"]) ? request()->query("direction", "asc") : "asc" }}';
                const newSort = currentSort === 'position' ? 'year' : 'position';
                console.log(`Cambiando campo de orden a: ${newSort}, dirección: ${currentDirection}`);
                
                // Redirigir con los parámetros de orden
                window.location.href = `{{ route('dashboard') }}?sort=${newSort}&direction=${currentDirection}`;
            });
            
            // Configurar el botón de ordenar por dirección
            const sortDirectionButton = document.getElementById('sort-direction-toggle');
            const sortDirectionIcon = document.getElementById('sort-direction-icon');
            const sortDirectionLoading = document.getElementById('sort-direction-loading');
            const sortDirectionText = document.getElementById('sort-direction-text');
            
            sortDirectionButton.addEventListener('click', function() {
                // Mostrar estado de carga
                sortDirectionButton.disabled = true;
                sortDirectionIcon.classList.add('hidden');
                sortDirectionLoading.classList.remove('hidden');
                sortDirectionText.textContent = 'CARGANDO...';
                
                const currentSort = '{{ in_array(request()->query("sort", "position"), ["position", "year"]) ? request()->query("sort", "position") : "position" }}';
                const currentDirection = '{{ in_array(request()->query("direction", "asc"), ["asc", "desc"]) ? request()->query("direction", "asc") : "asc" }}';
                const newDirection = currentDirection === 'asc' ? 'desc' : 'asc';
                console.log(`Cambiando dirección de orden a: ${newDirection}, campo: ${currentSort}`);
                
                // Redirigir con los parámetros de orden
                window.location.href = `{{ route('dashboard') }}?sort=${currentSort}&direction=${newDirection}`;
            });
            
            // Restaurar estado de los botones después de cargar la página
            sortFieldButton.disabled = false;
            sortFieldIcon.classList.remove('hidden');
            sortFieldLoading.classList.add('hidden');
            sortDirectionButton.disabled = false;
            sortDirectionIcon.classList.remove('hidden');
            sortDirectionLoading.classList.add('hidden');
            
            // Mensaje de depuración para confirmar funcionamiento
            if (isElectron()) {
                console.log('Electron detectado, versión:', window.electron.getVersion());
            } else {
                console.log('Electron no detectado, ejecutando en navegador normal');
            }
        });
    </script>
</body>
</html>