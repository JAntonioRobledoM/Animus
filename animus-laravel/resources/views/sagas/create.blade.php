<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animus - Crear Saga</title>
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
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background: radial-gradient(ellipse at center, #0a0a0a 0%, #000000 100%);
        }
        .hologram-border {
            position: relative;
            border: 1px solid transparent;
            background: linear-gradient(45deg, #0082CA, #00a8ff, #0082CA) border-box;
            border-radius: 8px;
        }
        .btn-hologram {
            background: linear-gradient(45deg, rgba(0, 130, 202, 0.2), rgba(0, 168, 255, 0.2));
            border: 1px solid #0082CA;
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
                <a href="{{ route('sagas.index') }}" class="text-abstergo-accent border-b-2 border-abstergo-accent px-3 py-1 font-medium tracking-wide">
                    SAGAS
                </a>
                <a href="{{ route('recuerdos.index') }}" class="text-white hover:text-abstergo-accent transition-all duration-300 px-3 py-1 hover:bg-abstergo-accent/10 rounded">
                    GESTIONAR RECUERDOS
                </a>
                <a href="{{ route('map.index') }}" class="text-white hover:text-abstergo-accent transition-all duration-300 px-3 py-1 hover:bg-abstergo-accent/10 rounded">
                    MAPA DE RECUERDOS
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

    <main class="container mx-auto px-6 py-8 flex-grow">
        <div class="flex items-center mb-12">
            <a href="{{ route('sagas.index') }}" class="text-abstergo-accent hover:text-abstergo-light-blue mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-4xl font-orbitron font-bold text-hologram mb-2 animate-glow">CREAR NUEVA SAGA</h1>
                <div class="w-full h-1 bg-gradient-to-r from-abstergo-blue via-abstergo-accent to-transparent rounded-full"></div>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-red-500/20 border-l-4 border-red-400 p-6 mb-8 rounded-r-lg">
                <div class="text-red-300 font-medium mb-2">Se encontraron errores:</div>
                <ul class="list-disc ml-6 text-red-300 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="hologram-border bg-gradient-to-br from-black/80 to-abstergo-gray/50 rounded-xl p-8 max-w-2xl">
            <form action="{{ route('sagas.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="nombre" class="block text-abstergo-accent mb-2 font-orbitron">NOMBRE DE LA SAGA</label>
                    <input type="text" name="nombre" id="nombre" class="w-full bg-abstergo-dark/70 border border-abstergo-blue/40 rounded py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-abstergo-blue/50" value="{{ old('nombre') }}" required>
                    <p class="text-xs text-gray-400 mt-1">Nombre único para identificar la saga (ej: Assassin's Creed)</p>
                </div>

                <div class="mb-6">
                    <label for="descripcion" class="block text-abstergo-accent mb-2 font-orbitron">DESCRIPCIÓN (OPCIONAL)</label>
                    <textarea name="descripcion" id="descripcion" rows="4" class="w-full bg-abstergo-dark/70 border border-abstergo-blue/40 rounded py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-abstergo-blue/50">{{ old('descripcion') }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">Descripción breve de la saga</p>
                </div>

                <div class="mb-6">
                    <label for="color" class="block text-abstergo-accent mb-2 font-orbitron">COLOR (OPCIONAL)</label>
                    <div class="flex items-center gap-4">
                        <input type="color" name="color" id="color" class="h-10 w-20 bg-abstergo-dark/70 border border-abstergo-blue/40 rounded cursor-pointer" value="{{ old('color', '#00a8ff') }}">
                        <input type="text" class="flex-1 bg-abstergo-dark/70 border border-abstergo-blue/40 rounded py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-abstergo-blue/50" id="colorText" value="{{ old('color', '#00a8ff') }}" readonly>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Color para identificar la saga visualmente</p>
                </div>

                <div class="flex justify-end gap-4 mt-8">
                    <a href="{{ route('sagas.index') }}" class="btn-hologram text-white px-6 py-3 rounded-md font-medium">
                        CANCELAR
                    </a>
                    <button type="submit" class="btn-hologram text-white px-6 py-3 rounded-md font-medium hover:bg-abstergo-blue/50 transition-all">
                        CREAR SAGA
                    </button>
                </div>
            </form>
        </div>
    </main>

    <footer class="bg-black/90 border-t-2 border-abstergo-blue py-6 px-6 text-center mt-auto">
        <p class="text-abstergo-accent font-orbitron">ABSTERGO INDUSTRIES © {{ date('Y') }}</p>
    </footer>

    <script>
        document.getElementById('color').addEventListener('change', function() {
            document.getElementById('colorText').value = this.value;
            document.getElementById('colorText').style.borderColor = this.value;
        });
    </script>
</body>
</html>
