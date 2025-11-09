<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animus - Gestionar Sagas</title>
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
        .hologram-border {
            position: relative;
            border: 1px solid transparent;
            background: linear-gradient(45deg, #0082CA, #00a8ff, #0082CA) border-box;
            border-radius: 8px;
        }
        .card-glow {
            box-shadow: 0 4px 15px rgba(0, 130, 202, 0.1);
            transition: all 0.3s ease;
        }
        .card-glow:hover {
            box-shadow: 0 8px 30px rgba(0, 130, 202, 0.3);
            transform: translateY(-5px);
        }
        .btn-hologram {
            background: linear-gradient(45deg, rgba(0, 130, 202, 0.2), rgba(0, 168, 255, 0.2));
            border: 1px solid #0082CA;
            position: relative;
            overflow: hidden;
        }
        .btn-hologram:hover {
            background: linear-gradient(45deg, rgba(0, 130, 202, 0.4), rgba(0, 168, 255, 0.4));
        }
        .text-hologram {
            background: linear-gradient(45deg, #0082CA, #00a8ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-abstergo-dark font-rajdhani text-white flex flex-col min-h-screen">
    <nav class="bg-black/90 border-b-2 border-abstergo-blue shadow-lg py-4 px-6">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <span class="text-3xl font-orbitron font-bold text-hologram tracking-widest">ANIMUS OS</span>
            </div>
            <div class="flex items-center space-x-6">
                <a href="{{ route('dashboard') }}" class="text-white hover:text-abstergo-accent transition-all">DASHBOARD</a>
                <a href="{{ route('recuerdos.index') }}" class="text-white hover:text-abstergo-accent transition-all">RECUERDOS</a>
                <a href="{{ route('sagas.index') }}" class="text-abstergo-accent border-b-2 border-abstergo-accent">SAGAS</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="btn-hologram text-white px-4 py-2 rounded-md">CERRAR SESIÓN</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-6 py-8 flex-grow">
        <div class="flex items-center justify-between mb-12">
            <div>
                <h1 class="text-4xl font-orbitron font-bold text-hologram mb-2 animate-glow">GESTIONAR SAGAS</h1>
                <div class="w-full h-1 bg-gradient-to-r from-abstergo-blue via-abstergo-accent to-transparent rounded-full"></div>
            </div>
            <a href="{{ route('sagas.create') }}" class="btn-hologram text-white px-6 py-3 rounded-lg font-medium hover:scale-105 transition-all">
                + CREAR SAGA
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 border-l-4 border-green-400 p-6 mb-8 rounded-r-lg">
                <p class="text-green-300">{{ session('success') }}</p>
            </div>
        @endif

        @if($sagas->isEmpty())
            <div class="hologram-border bg-gradient-to-br from-abstergo-blue/10 to-abstergo-accent/10 rounded-xl p-12 text-center">
                <p class="text-xl font-medium text-white mb-8">No hay sagas creadas aún</p>
                <a href="{{ route('sagas.create') }}" class="btn-hologram text-white px-8 py-4 rounded-lg font-medium">
                    CREAR PRIMERA SAGA
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($sagas as $saga)
                    <div class="card-glow bg-gradient-to-br from-black/80 to-abstergo-gray/50 hologram-border rounded-xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-4 h-4 rounded-full" style="background-color: {{ $saga->color }}"></div>
                                <h3 class="text-xl font-orbitron font-bold">{{ $saga->nombre }}</h3>
                            </div>
                        </div>

                        <p class="text-gray-300 text-sm mb-4">{{ $saga->descripcion ?? 'Sin descripción' }}</p>

                        <div class="bg-black/50 rounded px-3 py-2 mb-6 text-center">
                            <p class="text-sm text-abstergo-accent">
                                <strong>{{ $saga->recuerdos()->count() }}</strong> recuerdo(s)
                            </p>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('sagas.edit', $saga) }}" class="flex-1 btn-hologram text-white px-4 py-2 rounded text-center text-sm font-medium hover:bg-abstergo-blue/30 transition-all">
                                EDITAR
                            </a>
                            <form action="{{ route('sagas.destroy', $saga) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-600/20 border border-red-600 text-red-300 px-4 py-2 rounded text-sm font-medium hover:bg-red-600/40 transition-all" onclick="return confirm('¿Estás seguro?')">
                                    ELIMINAR
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <footer class="bg-black/90 border-t-2 border-abstergo-blue py-6 px-6 text-center mt-auto">
        <p class="text-abstergo-accent font-orbitron">ABSTERGO INDUSTRIES © {{ date('Y') }}</p>
    </footer>
</body>
</html>
