<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animus - Gestión de Recuerdos</title>
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
        <div class="flex justify-between items-center mb-12">
            <div>
                <h1 class="text-4xl font-orbitron font-bold text-hologram mb-2 animate-glow">
                    GESTIÓN DE RECUERDOS GENÉTICOS
                </h1>
                <div class="w-full h-1 bg-gradient-to-r from-abstergo-blue via-abstergo-accent to-transparent rounded-full"></div>
            </div>
            
            <a href="{{ route('recuerdos.create') }}" class="btn-hologram text-white px-6 py-3 rounded-lg transition-all duration-300 flex items-center space-x-3 hover:scale-105 font-medium shadow-lg">
                <div class="w-6 h-6 bg-gradient-to-br from-abstergo-blue to-abstergo-accent rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <span>AÑADIR NUEVO RECUERDO</span>
            </a>
        </div>
        
        <!-- Mensajes de notificación -->
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
        
        <!-- Tabla de recuerdos -->
        <div class="hologram-border bg-gradient-to-br from-black/80 to-abstergo-gray/50 rounded-xl overflow-hidden card-glow">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-abstergo-blue/20 to-abstergo-accent/20 border-b border-abstergo-blue/40">
                    <tr>
                        <th class="py-4 px-6 text-left font-orbitron text-abstergo-accent">IMAGEN</th>
                        <th class="py-4 px-6 text-left font-orbitron text-abstergo-accent">TÍTULO</th>
                        <th class="py-4 px-6 text-left font-orbitron text-abstergo-accent">SUBTÍTULO</th>
                        <th class="py-4 px-6 text-left font-orbitron text-abstergo-accent">POSICIÓN</th>
                        <th class="py-4 px-6 text-center font-orbitron text-abstergo-accent">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recuerdos as $recuerdo)
                        <tr class="border-b border-abstergo-gray/30 hover:bg-abstergo-blue/10 transition-all duration-300 group">
                            <td class="py-4 px-6">
                                @if($recuerdo->img)
                                    <img src="{{ asset($recuerdo->img) }}" alt="{{ $recuerdo->title }}" class="w-16 h-16 object-cover rounded group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-16 h-16 bg-gradient-to-br from-abstergo-dark via-abstergo-gray to-abstergo-dark rounded flex items-center justify-center relative overflow-hidden">
                                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-abstergo-blue/10 to-transparent animate-pulse"></div>
                                        <span class="text-abstergo-blue/50 text-xs font-orbitron relative z-10">SIN IMAGEN</span>
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-6 font-medium text-white group-hover:text-abstergo-accent transition-colors duration-300">{{ $recuerdo->title }}</td>
                            <td class="py-4 px-6 text-gray-400">{{ $recuerdo->subtitle ?? '—' }}</td>
                            <td class="py-4 px-6 text-gray-400">{{ $recuerdo->position }}</td>
                            <td class="py-4 px-6 flex justify-center space-x-3">
                                <a href="{{ route('recuerdos.show', $recuerdo) }}" class="btn-hologram text-white px-4 py-2 rounded-md text-sm transition-all duration-300 font-medium hover:bg-abstergo-blue/50">
                                    VER
                                </a>
                                <a href="{{ route('recuerdos.edit', $recuerdo) }}" class="btn-hologram text-white px-4 py-2 rounded-md text-sm transition-all duration-300 font-medium hover:bg-abstergo-gold/50">
                                    EDITAR
                                </a>
                                <form action="{{ route('recuerdos.destroy', $recuerdo) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este recuerdo?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-hologram text-white px-4 py-2 rounded-md text-sm transition-all duration-300 font-medium hover:bg-red-800/50">
                                        ELIMINAR
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div class="hologram-border bg-gradient-to-br from-abstergo-blue/10 to-abstergo-accent/10 rounded-xl p-12 relative overflow-hidden card-glow">
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
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
</body>
</html>