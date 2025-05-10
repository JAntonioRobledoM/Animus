<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animus - Sincronización: {{ $recuerdo->title }}</title>
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
                    animation: {
                        'glitch': 'glitch 0.5s infinite',
                        'scan': 'scan 8s linear infinite',
                        'pulse-blue': 'pulse-blue 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        glitch: {
                            '0%, 100%': { opacity: '1' },
                            '25%': { opacity: '0.8' },
                            '50%': { opacity: '0.9' },
                            '75%': { opacity: '0.7' },
                        },
                        scan: {
                            '0%': { top: '0%' },
                            '100%': { top: '100%' },
                        },
                        'pulse-blue': {
                            '0%, 100%': { 
                                opacity: '1',
                                boxShadow: '0 0 10px rgba(0, 130, 202, 0.7), 0 0 20px rgba(0, 130, 202, 0.5), 0 0 30px rgba(0, 130, 202, 0.3)' 
                            },
                            '50%': { 
                                opacity: '0.5',
                                boxShadow: '0 0 5px rgba(0, 130, 202, 0.5), 0 0 10px rgba(0, 130, 202, 0.3), 0 0 15px rgba(0, 130, 202, 0.2)' 
                            },
                        },
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .text-stroke {
                -webkit-text-stroke: 1px rgba(0, 130, 202, 0.5);
            }
            .blue-glow {
                text-shadow: 0 0 5px #0082CA, 0 0 10px #0082CA;
            }
        }
    </style>
</head>
<body class="bg-abstergo-dark font-rajdhani text-white h-screen overflow-hidden relative">
    <!-- Efectos de fondo Animus -->
    <div class="absolute inset-0 z-0 overflow-hidden opacity-20">
        <div class="absolute h-0.5 w-full bg-abstergo-blue left-0 animate-scan"></div>
        
        <div class="absolute bottom-0 right-0 opacity-30 text-xs font-mono text-abstergo-blue p-2">
            <div id="terminal"></div>
        </div>
        
        <div class="absolute top-0 left-0 w-screen h-screen grid grid-cols-12 gap-px pointer-events-none opacity-10">
            @for ($i = 0; $i < 144; $i++)
                <div class="bg-abstergo-blue/5 border border-abstergo-blue/10"></div>
            @endfor
        </div>
    </div>
    
    <!-- Contenido principal -->
    <div class="relative z-10 h-screen flex flex-col">
        <!-- Barra superior -->
        <div class="bg-black/90 border-b border-abstergo-blue p-4 flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ asset('images/abstergo-logo.png') }}" alt="Abstergo" class="h-8 mr-4">
                <span class="text-2xl font-semibold text-abstergo-blue tracking-wider">ANIMUS</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <div class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></div>
                    <span class="text-sm">SINCRONIZACIÓN ACTIVA</span>
                </div>
                <a href="{{ route('dashboard') }}" class="bg-abstergo-blue/20 hover:bg-abstergo-blue/30 text-white px-4 py-2 rounded transition-all">
                    Salir
                </a>
            </div>
        </div>
        
        <!-- Área principal del recuerdo -->
        <div class="flex-grow flex">
            <!-- Interfaz lateral -->
            <div class="w-64 bg-black/80 border-r border-abstergo-blue/40 p-4 flex flex-col">
                <div class="mb-6">
                    <h3 class="text-abstergo-blue font-semibold mb-2">DATOS DEL RECUERDO</h3>
                    <div class="text-sm space-y-2">
                        <p><span class="text-gray-400">Título:</span> {{ $recuerdo->title }}</p>
                        <p><span class="text-gray-400">Subtítulo:</span> {{ $recuerdo->subtitle ?? 'N/A' }}</p>
                    </div>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-abstergo-blue font-semibold mb-2">MÉTRICAS</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span>Sincronización</span>
                                <span id="syncValue">0%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div id="syncBar" class="bg-abstergo-blue h-2 rounded-full" style="width: 0%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span>Estabilidad</span>
                                <span id="stabilityValue">85%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span>Integridad</span>
                                <span>92%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="bg-yellow-500 h-2 rounded-full" style="width: 92%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-auto space-y-2">
                    <button class="w-full bg-abstergo-blue/20 hover:bg-abstergo-blue/40 text-white py-2 px-4 rounded text-sm transition-colors">
                        PAUSAR SINCRONIZACIÓN
                    </button>
                    <button class="w-full bg-red-800/30 hover:bg-red-800/50 text-white py-2 px-4 rounded text-sm transition-colors">
                        DESINCRONIZAR
                    </button>
                </div>
            </div>
            
            <!-- Visualización principal del recuerdo -->
            <div class="flex-grow relative bg-black flex items-center justify-center overflow-hidden">
                <!-- Imagen ampliada del recuerdo -->
                <div class="relative w-full h-full flex items-center justify-center">
                    @if($recuerdo->img)
                        <img src="{{ asset($recuerdo->img) }}" alt="{{ $recuerdo->title }}" class="max-w-full max-h-full object-contain z-10">
                        
                        <!-- Overlay de efecto Animus -->
                        <div class="absolute inset-0 bg-abstergo-blue/5 pointer-events-none"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/60 pointer-events-none"></div>
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center">
                            <div class="text-4xl text-abstergo-blue/60 mb-4 blue-glow animate-pulse-blue">
                                VISUALIZACIÓN NO DISPONIBLE
                            </div>
                            <p class="text-gray-400">No hay imagen asociada a este recuerdo</p>
                        </div>
                    @endif
                    
                    <!-- Informaciones superpuestas del Animus -->
                    <div class="absolute top-4 left-4 text-abstergo-blue/80 text-sm font-mono z-20">
                        SEC_ID: {{ str_pad(rand(1000, 9999), 8, rand(0, 9), STR_PAD_LEFT) }}<br>
                        LOC: {{ $recuerdo->title }}<br>
                        TS: {{ now()->format('d.m.Y H:i:s') }}
                    </div>
                    
                    <div class="absolute bottom-4 right-4 text-abstergo-blue/80 text-sm font-mono z-20">
                        SUJETO: {{ auth()->user()->name }}<br>
                        ESTADO: ACTIVO<br>
                        VER: 4.27.19
                    </div>
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
            
            nextMessage();
            
            // Simular progreso de sincronización
            const syncBar = document.getElementById('syncBar');
            const syncValue = document.getElementById('syncValue');
            let syncProgress = 0;
            
            function updateSync() {
                if (syncProgress < 100) {
                    // Incrementos variables para simular progreso real
                    const increment = Math.random() * 2 + 0.5;
                    syncProgress = Math.min(syncProgress + increment, 100);
                    
                    syncBar.style.width = syncProgress + '%';
                    syncValue.textContent = Math.floor(syncProgress) + '%';
                    
                    setTimeout(updateSync, 300);
                }
            }
            
            setTimeout(updateSync, 2000);
        });
    </script>
</body>
</html>