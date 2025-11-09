<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animus - Sincronización: {{ $recuerdo->title }}</title>
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
<body class="bg-abstergo-dark font-rajdhani text-white h-screen overflow-hidden relative">
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

    <!-- Contenido principal -->
    <div class="relative z-10 h-screen flex flex-col">
        <!-- Barra superior -->
        <div class="bg-black/90 border-b-2 border-abstergo-blue shadow-lg shadow-abstergo-blue/20 p-4 flex justify-between items-center relative">
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-abstergo-blue/5 to-transparent"></div>
            <div class="flex items-center relative z-10">
                <div class="w-10 h-10 bg-gradient-to-br from-abstergo-blue to-abstergo-light-blue rounded-full flex items-center justify-center mr-4 animate-pulse-blue">
                    <div class="w-6 h-6 bg-white rounded-full opacity-80"></div>
                </div>
                <span class="text-3xl font-orbitron font-bold text-hologram animate-glow tracking-widest">ANIMUS OS</span>
                <div class="ml-4 text-xs text-abstergo-accent font-orbitron">v1.0</div>
            </div>
            
            <div class="flex items-center space-x-4 relative z-10">
                <div class="flex items-center space-x-2">
                    <div class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></div>
                    <span class="text-sm text-abstergo-accent font-orbitron">SINCRONIZACIÓN ACTIVA</span>
                </div>
                <a href="{{ route('dashboard') }}" class="btn-hologram text-white px-4 py-2 rounded-md transition-all duration-300 hover:bg-abstergo-blue/30 font-medium">
                    SALIR
                </a>
            </div>
        </div>
        
        <!-- Área principal del recuerdo -->
        <div class="flex-grow flex">
            <!-- Interfaz lateral -->
            <div class="w-64 hologram-border bg-gradient-to-br from-black/80 to-abstergo-gray/50 p-4 flex flex-col card-glow">
                <div class="mb-6">
                    <h3 class="text-abstergo-accent font-orbitron font-semibold mb-2">DATOS DEL RECUERDO</h3>
                    <div class="text-sm space-y-2">
                        <p><span class="text-gray-400 font-rajdhani">Título:</span> <span class="text-white">{{ $recuerdo->title }}</span></p>
                        <p><span class="text-gray-400 font-rajdhani">Subtítulo:</span> <span class="text-white">{{ $recuerdo->subtitle ?? 'N/A' }}</span></p>
                    </div>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-abstergo-accent font-orbitron font-semibold mb-2">MÉTRICAS</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-xs mb-1 font-rajdhani">
                                <span>Sincronización</span>
                                <span id="syncValue">0%</span>
                            </div>
                            <div class="w-full max-w-[200px] mx-auto bg-black/50 rounded-full h-3 border border-abstergo-blue/50">
                                <div id="syncBar" class="h-full bg-gradient-to-r from-abstergo-blue to-abstergo-accent progress-glow rounded-full" style="width: 0%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex justify-between text-xs mb-1 font-rajdhani">
                                <span>Estabilidad</span>
                                <span id="stabilityValue">85%</span>
                            </div>
                            <div class="w-full max-w-[200px] mx-auto bg-black/50 rounded-full h-3 border border-abstergo-blue/50">
                                <div class="h-full bg-gradient-to-r from-green-500 to-green-600 progress-glow rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex justify-between text-xs mb-1 font-rajdhani">
                                <span>Integridad</span>
                                <span>92%</span>
                            </div>
                            <div class="w-full max-w-[200px] mx-auto bg-black/50 rounded-full h-3 border border-abstergo-blue/50">
                                <div class="h-full bg-gradient-to-r from-yellow-500 to-yellow-600 progress-glow rounded-full" style="width: 92%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-auto space-y-2">
                    <button class="w-full btn-hologram text-white py-2 px-4 rounded-md text-sm transition-all duration-300 hover:bg-abstergo-blue/50 font-medium">
                        PAUSAR SINCRONIZACIÓN
                    </button>
                    <button class="w-full btn-hologram text-white py-2 px-4 rounded-md text-sm transition-all duration-300 hover:bg-red-800/50 font-medium">
                        DESINCRONIZAR
                    </button>
                </div>
            </div>
            
            <!-- Visualización principal del recuerdo -->
            <div class="flex-grow relative bg-black flex items-center justify-center overflow-hidden">
                <!-- Imagen ampliada del recuerdo -->
                <div class="relative w-full h-full flex items-center justify-center">
                    @if($recuerdo->img)
                        <img src="{{ asset($recuerdo->img) }}" alt="{{ $recuerdo->title }}" class="max-w-full max-h-full object-contain z-10 group-hover:scale-105 transition-transform duration-300">
                        
                        <!-- Overlay de efecto Animus -->
                        <div class="absolute inset-0 bg-abstergo-blue/10 pointer-events-none"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/60 pointer-events-none"></div>
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-abstergo-blue/10 to-transparent animate-pulse"></div>
                            <div class="text-4xl text-hologram mb-4 animate-glow font-orbitron relative z-10">
                                VISUALIZACIÓN NO DISPONIBLE
                            </div>
                            <p class="text-gray-400 font-rajdhani relative z-10">No hay imagen asociada a este recuerdo</p>
                        </div>
                    @endif
                    
                    <!-- Informaciones superpuestas del Animus -->
                    <div class="absolute top-4 left-4 text-abstergo-accent text-sm font-orbitron z-20 animate-glow">
                        SEC_ID: {{ str_pad(rand(1000, 9999), 8, rand(0, 9), STR_PAD_LEFT) }}<br>
                        LOC: {{ $recuerdo->title }}<br>
                        TS: {{ now()->format('d.m.Y H:i:s') }}
                    </div>
                    
                    <div class="absolute bottom-4 right-4 text-abstergo-accent text-sm font-orbitron z-20 animate-glow">
                        SUJETO: {{ auth()->user()->name }}<br>
                        ESTADO: ACTIVO<br>
                        VER: 1.0
                    </div>
                </div>
                
                <!-- Terminal -->
                <div class="absolute bottom-0 right-0 bg-black/80 border-t border-l border-abstergo-blue/40 p-2 text-xs font-orbitron text-abstergo-accent max-h-40 overflow-y-auto">
                    <div id="terminal"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de sincronización -->
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
        // Simulación de terminal del Animus
        document.addEventListener('DOMContentLoaded', function() {
            const terminal = document.getElementById('terminal');
            const messages = [
                'Iniciando sincronización con secuencia genética...',
                'Analizando datos de ADN...',
                'Estabilizando memoria...',
                'Construyendo entorno virtual...',
                'Sincronización en progreso...',
                'Calculando coherencia temporal...',
                'Recuerdo estabilizado.'
            ];
            
            let index = 0;
            
            function addMessage() {
                if (index < messages.length) {
                    const p = document.createElement('p');
                    p.textContent = '> ' + messages[index];
                    p.classList.add('text-abstergo-accent', 'animate-glow');
                    terminal.appendChild(p);
                    index++;
                    
                    // Autoscroll
                    terminal.scrollTop = terminal.scrollHeight;
                }
            }
            
            // Agregar mensajes con intervalos aleatorios
            function nextMessage() {
                if (index < messages.length) {
                    const delay = Math.floor(Math.random() * 1500) + 1000;
                    setTimeout(() => {
                        addMessage();
                        nextMessage();
                    }, delay);
                }
            }
            
            // Mostrar modal de sincronización al cargar la página
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
                    loadingText.textContent = 'Sincronización en progreso...';
                }
                
                if (progress >= 100) {
                    clearInterval(interval);
                    setTimeout(() => {
                        syncModal.classList.add('hidden');
                        progressBar.style.width = '0%';
                        loadingText.textContent = 'Preparando secuencia genética...';
                        nextMessage(); // Iniciar mensajes del terminal después de cerrar el modal
                    }, 1000);
                }
            }, 50);
            
            // Simular progreso de sincronización
            const syncBar = document.getElementById('syncBar');
            const syncValue = document.getElementById('syncValue');
            let syncProgress = 0;
            
            function updateSync() {
                if (syncProgress < 100) {
                    const increment = Math.random() * 2 + 0.5;
                    syncProgress = Math.min(syncProgress + increment, 100);
                    
                    syncBar.style.width = syncProgress + '%';
                    syncValue.textContent = Math.floor(syncProgress) + '%';
                    
                    setTimeout(updateSync, 300);
                }
            }
            
            setTimeout(updateSync, 2000);

            // Lanzar app externa si está configurada
            @if($recuerdo->necesita_app_externa && $recuerdo->ruta_app_externa)
                setTimeout(() => {
                    fetch('{{ route('recuerdos.lanzar-app', $recuerdo->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Aplicación externa iniciada correctamente');
                            // Opcional: mostrar mensaje al usuario
                            const terminalMsg = document.createElement('p');
                            terminalMsg.textContent = '> Aplicación externa iniciada...';
                            terminalMsg.classList.add('text-green-500', 'animate-glow');
                            terminal.appendChild(terminalMsg);
                            terminal.scrollTop = terminal.scrollHeight;
                        } else {
                            console.error('Error al iniciar app externa:', data.message);
                            const terminalMsg = document.createElement('p');
                            terminalMsg.textContent = '> Error al iniciar aplicación externa: ' + data.message;
                            terminalMsg.classList.add('text-red-500', 'animate-glow');
                            terminal.appendChild(terminalMsg);
                            terminal.scrollTop = terminal.scrollHeight;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }, 3000); // Esperar 3 segundos después de cargar para lanzar la app
            @endif
        });
    </script>
</body>
</html>