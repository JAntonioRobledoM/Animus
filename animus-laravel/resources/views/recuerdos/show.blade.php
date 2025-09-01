<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animus - {{ $recuerdo->title }}</title>
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
                <a href="{{ route('dashboard') }}" class="text-white hover:text-abstergo-accent transition-all duration-300 px-3 py-1 hover:bg-abstergo-accent/10 rounded">
                    DASHBOARD
                </a>
                <a href="{{ route('recuerdos.index') }}" class="text-abstergo-accent border-b-2 border-abstergo-accent px-3 py-1 font-medium tracking-wide">
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
        <div class="flex items-center mb-12">
            <a href="{{ route('recuerdos.index') }}" class="text-abstergo-accent hover:text-abstergo-light-blue mr-4 transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-4xl font-orbitron font-bold text-hologram mb-2 animate-glow">
                    DETALLES DEL RECUERDO
                </h1>
                <div class="w-full h-1 bg-gradient-to-r from-abstergo-blue via-abstergo-accent to-transparent rounded-full"></div>
            </div>
        </div>
        
        <!-- Tarjeta de detalles -->
        <div class="hologram-border bg-gradient-to-br from-black/80 to-abstergo-gray/50 rounded-xl overflow-hidden card-glow">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <!-- Imagen del recuerdo -->
                <div class="h-80 bg-gradient-to-br from-abstergo-dark via-abstergo-gray to-abstergo-dark flex items-center justify-center p-4 relative overflow-hidden">
                    @if($recuerdo->img)
                        <img src="{{ asset($recuerdo->img) }}" alt="{{ $recuerdo->title }}" class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-abstergo-dark via-abstergo-gray to-abstergo-dark flex items-center justify-center relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-abstergo-blue/10 to-transparent animate-pulse"></div>
                            <span class="text-abstergo-blue/50 text-xl font-orbitron relative z-10">SIN IMAGEN</span>
                        </div>
                    @endif
                </div>
                
                <!-- Información del recuerdo -->
                <div class="p-6 relative z-10">
                    <h2 class="text-2xl font-orbitron font-semibold text-white mb-2 group-hover:text-abstergo-accent transition-colors duration-300">{{ $recuerdo->title }}</h2>
                    
                    @if($recuerdo->subtitle)
                        <p class="text-gray-400 mb-4 font-rajdhani">{{ $recuerdo->subtitle }}</p>
                    @endif
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-abstergo-accent text-sm font-orbitron">POSICIÓN</p>
                            <p class="text-white">{{ $recuerdo->position }}</p>
                        </div>
                        <div>
                            <p class="text-abstergo-accent text-sm font-orbitron">RUTA</p>
                            <p class="break-all text-white">{{ $recuerdo->path }}</p>
                        </div>
                        <div>
                            <p class="text-abstergo-accent text-sm font-orbitron">CREADO</p>
                            <p class="text-white">{{ $recuerdo->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-abstergo-accent text-sm font-orbitron">ACTUALIZADO</p>
                            <p class="text-white">{{ $recuerdo->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <!-- Acciones -->
                    <div class="flex justify-between space-x-3 border-t border-abstergo-blue/30 pt-4 mt-4">
                        <a href="#" class="flex-1 btn-hologram px-4 py-2 rounded-md transition-all duration-300 flex items-center justify-center space-x-2 launch-game hover:scale-105 font-medium shadow-md" data-path="{{ $recuerdo->path }}">
                            <div class="w-4 h-4 bg-gradient-to-br from-abstergo-blue to-abstergo-accent rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                </svg>
                            </div>
                            <span>SINCRONIZAR</span>
                        </a>
                        <a href="{{ route('recuerdos.edit', $recuerdo->id) }}" class="flex-1 btn-hologram text-white px-4 py-2 rounded-md transition-all duration-300 font-medium hover:bg-abstergo-gold/50">
                            EDITAR
                        </a>
                        <form action="{{ route('recuerdos.destroy', $recuerdo->id) }}" method="POST" class="flex-1" onsubmit="return confirm('¿Estás seguro de eliminar este recuerdo? Esta acción no se puede deshacer.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full btn-hologram text-white px-4 py-2 rounded-md transition-all duration-300 font-medium hover:bg-red-800/50">
                                ELIMINAR
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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

        // Configurar el botón de sincronización cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            // Seleccionar el botón de sincronización
            const syncButton = document.querySelector('.launch-game');
            
            if (syncButton) {
                syncButton.addEventListener('click', function(e) {
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
            }
            
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