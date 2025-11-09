<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animus - Editar Saga</title>
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
    <nav class="bg-black/90 border-b-2 border-abstergo-blue shadow-lg py-4 px-6">
        <div class="flex justify-between items-center">
            <span class="text-3xl font-orbitron font-bold text-hologram">ANIMUS OS</span>
            <div class="flex items-center space-x-6">
                <a href="{{ route('dashboard') }}" class="text-white hover:text-abstergo-accent">DASHBOARD</a>
                <a href="{{ route('sagas.index') }}" class="text-white hover:text-abstergo-accent">SAGAS</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="btn-hologram text-white px-4 py-2 rounded-md">CERRAR SESIÓN</button>
                </form>
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
                <h1 class="text-4xl font-orbitron font-bold text-hologram mb-2 animate-glow">EDITAR SAGA</h1>
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
            <form action="{{ route('sagas.update', $saga) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="nombre" class="block text-abstergo-accent mb-2 font-orbitron">NOMBRE DE LA SAGA</label>
                    <input type="text" name="nombre" id="nombre" class="w-full bg-abstergo-dark/70 border border-abstergo-blue/40 rounded py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-abstergo-blue/50" value="{{ old('nombre', $saga->nombre) }}" required>
                </div>

                <div class="mb-6">
                    <label for="descripcion" class="block text-abstergo-accent mb-2 font-orbitron">DESCRIPCIÓN (OPCIONAL)</label>
                    <textarea name="descripcion" id="descripcion" rows="4" class="w-full bg-abstergo-dark/70 border border-abstergo-blue/40 rounded py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-abstergo-blue/50">{{ old('descripcion', $saga->descripcion) }}</textarea>
                </div>

                <div class="mb-6">
                    <label for="color" class="block text-abstergo-accent mb-2 font-orbitron">COLOR</label>
                    <div class="flex items-center gap-4">
                        <input type="color" name="color" id="color" class="h-10 w-20 bg-abstergo-dark/70 border border-abstergo-blue/40 rounded cursor-pointer" value="{{ old('color', $saga->color) }}">
                        <input type="text" class="flex-1 bg-abstergo-dark/70 border border-abstergo-blue/40 rounded py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-abstergo-blue/50" id="colorText" value="{{ old('color', $saga->color) }}" readonly>
                    </div>
                </div>

                <div class="flex justify-end gap-4 mt-8">
                    <a href="{{ route('sagas.index') }}" class="btn-hologram text-white px-6 py-3 rounded-md font-medium">
                        CANCELAR
                    </a>
                    <button type="submit" class="btn-hologram text-white px-6 py-3 rounded-md font-medium hover:bg-abstergo-blue/50 transition-all">
                        ACTUALIZAR SAGA
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
