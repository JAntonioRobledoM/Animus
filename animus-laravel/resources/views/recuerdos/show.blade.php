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
    <div class="scan-line"></div>
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
        <div class="hologram-border bg-gradient-to-br from-black/80 to-abstergo-gray/50 rounded-xl overflow-hidden card-glow">
            <div class="grid grid-cols-1 md:grid-cols-2">
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
                <div class="p-6 relative z-10">
                    <h2 class="text-2xl font-orbitron font-semibold text-white mb-2 group-hover:text-abstergo-accent transition-colors duration-300">{{ $recuerdo->title }}</h2>
                    @if($recuerdo->subtitle)
                        <p class="text-gray-400 mb-4 font-rajdhani">{{ $recuerdo->subtitle }}</p>
                    @endif
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-abstergo-accent text-sm font-orbitron">AÑO</p>
                            <p class="text-white">{{ $recuerdo->year ?? 'No especificado' }}</p>
                        </div>
                        <div>
                            <p class="text-abstergo-accent text-sm font-orbitron">POSICIÓN</p>
                            <p class="text-white">{{ $recuerdo->position }}</p>
                        </div>
                        @if($recuerdo->lugar)
                        <div>
                            <p class="text-abstergo-accent text-sm font-orbitron">LUGAR</p>
                            <p class="text-white flex items-center">
                                <svg class="w-4 h-4 mr-1 text-abstergo-accent" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $recuerdo->lugar }}
                            </p>
                        </div>
                        @endif
                        <div class="{{ $recuerdo->lugar ? '' : 'col-span-2' }}">
                            <p class="text-abstergo-accent text-sm font-orbitron">RUTA DEL EJECUTABLE</p>
                            <p class="text-white text-xs break-all">{{ $recuerdo->path ?? 'No especificado' }}</p>
                        </div>
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('recuerdos.edit', $recuerdo) }}" class="btn-hologram text-white px-6 py-3 rounded-md transition-all duration-300 hover:bg-abstergo-gold/50 font-medium">
                            EDITAR
                        </a>
                        <form action="{{ route('recuerdos.destroy', $recuerdo) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este recuerdo?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-hologram text-white px-6 py-3 rounded-md transition-all duration-300 hover:bg-red-800/50 font-medium">
                                ELIMINAR
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
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