<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animus - Abstergo Industries</title>
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
    <style type="text/tailwindcss">
        @layer utilities {
            .bg-abstergo-gradient {
                background: linear-gradient(135deg, #121212 0%, #1a1a1a 100%);
            }
            .text-shadow-blue {
                text-shadow: 0 0 5px #0082CA;
            }
            .animate-scan-line {
                animation: scan-line 3s linear infinite;
            }
            .animate-flicker {
                animation: flicker 5s linear infinite;
            }
            .animate-data-flow {
                animation: data-flow 3s linear infinite;
            }
            .animate-dna-rotate {
                animation: dna-rotate 15s linear infinite;
            }
            
            @keyframes scan-line {
                0% { left: -100%; }
                100% { left: 100%; }
            }
            @keyframes flicker {
                0%, 19.999%, 22%, 62.999%, 64%, 64.999%, 70%, 100% { opacity: 0.99; }
                20%, 21.999%, 63%, 63.999%, 65%, 69.999% { opacity: 0.4; }
            }
            @keyframes data-flow {
                0% { transform: translateX(-100%); }
                100% { transform: translateX(100%); }
            }
            @keyframes dna-rotate {
                0% { transform: translateY(-300px) rotateZ(0deg); }
                100% { transform: translateY(300px) rotateZ(360deg); }
            }
        }
    </style>
</head>
<body class="bg-abstergo-dark font-rajdhani text-white h-screen overflow-hidden relative">
    <!-- Elementos de fondo -->
    <div class="absolute inset-0 z-0 overflow-hidden">
        <!-- Línea de ADN -->
        <div class="absolute top-0 right-[10%] w-[2px] h-[200%] bg-gradient-to-b from-transparent via-abstergo-blue to-transparent opacity-50 animate-dna-rotate">
            <div class="absolute top-[30%] left-0 w-[100px] h-[1px] bg-abstergo-blue"></div>
            <div class="absolute top-[70%] right-0 w-[100px] h-[1px] bg-abstergo-blue"></div>
        </div>
        
        <!-- Flujo de datos -->
        <div class="absolute bottom-[5%] left-0 w-full h-[1px] bg-abstergo-blue">
            <div class="absolute w-full h-full bg-gradient-to-r from-transparent via-abstergo-blue to-transparent animate-data-flow"></div>
        </div>
        
        <!-- Terminal de texto (se llenará con JavaScript) -->
        <div id="terminal" class="absolute bottom-5 left-5 font-mono text-xs text-abstergo-light-blue opacity-70 whitespace-pre max-w-md text-shadow-blue"></div>
    </div>

    <div class="flex justify-center items-center h-screen relative z-10">
        <div class="bg-black/70 border border-abstergo-blue rounded-md p-12 w-[450px] max-w-[90%] relative shadow-lg shadow-abstergo-blue/20 overflow-hidden">
            <!-- Línea de escaneo -->
            <div class="absolute top-0 left-[-50%] w-[200%] h-[2px] bg-gradient-to-r from-transparent via-abstergo-blue to-transparent animate-scan-line"></div>
            
            <!-- Logo Abstergo -->
            <div class="text-center mb-8">
                <img src="{{ asset('images/abstergo-logo.png') }}" alt="Abstergo Industries" class="h-20 mx-auto">
            </div>
            
            <!-- Texto Animus -->
            <div class="text-center mb-8 relative">
                <h1 class="text-4xl font-semibold tracking-widest text-white">
                    ANIMUS <span class="text-xl align-super">OS</span>
                </h1>
                <div class="absolute right-5 top-1 text-sm opacity-70">v4.27</div>
            </div>
            
            <!-- Mensaje de error -->
            @if(session('error'))
                <div class="bg-red-900/20 border-l-4 border-red-600 p-4 mb-6 text-red-400">
                    {{ session('error') }}
                </div>
            @endif
            
            <!-- Formulario de login -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-6">
                    <label for="name" class="block mb-2 text-sm text-abstergo-light-blue tracking-wider">ID DE SUJETO</label>
                    <input type="text" id="name" name="name" required autofocus
                           class="w-full py-3 px-4 bg-white/10 border border-abstergo-blue rounded text-white font-rajdhani text-base transition-all focus:outline-none focus:border-abstergo-light-blue focus:shadow-md focus:shadow-abstergo-blue/30">
                </div>
                
                <div class="mb-6">
                    <label for="password" class="block mb-2 text-sm text-abstergo-light-blue tracking-wider">CÓDIGO DE ACCESO</label>
                    <input type="password" id="password" name="password" required
                           class="w-full py-3 px-4 bg-white/10 border border-abstergo-blue rounded text-white font-rajdhani text-base transition-all focus:outline-none focus:border-abstergo-light-blue focus:shadow-md focus:shadow-abstergo-blue/30">
                </div>
                
                <div class="mt-8 text-center">
                    <button type="submit" 
                            class="bg-abstergo-blue text-white border-none py-3 px-8 font-rajdhani text-base font-semibold tracking-wider cursor-pointer transition-all rounded hover:bg-abstergo-light-blue">
                        INICIAR SESIÓN
                    </button>
                </div>
            </form>
            
            <!-- Footer -->
            <div class="mt-8 text-center text-sm opacity-70">
                <p class="mb-1">ABSTERGO INDUSTRIES &copy; {{ date('Y') }}</p>
                <p class="mb-1">ANIMUS OS - TODOS LOS DERECHOS RESERVADOS</p>
                <p class="mt-3 text-red-400">ACCESO RESTRINGIDO - SOLO PERSONAL AUTORIZADO</p>
            </div>
        </div>
    </div>
    
    <script>
        // Efecto de tipeo para pantalla de login
        document.addEventListener('DOMContentLoaded', function() {
            const messages = [
                'Inicializando sistema Animus...',
                'Verificando bases de datos genéticas...',
                'Preparando interfaz de memoria...',
                'Buscando secuencias sincronizables...',
                'Sistema Animus en línea.',
                'Esperando credenciales de acceso...'
            ];
            
            const terminalElement = document.getElementById('terminal');
            
            let messageIndex = 0;
            let charIndex = 0;
            
            function typeText() {
                if (messageIndex < messages.length) {
                    const message = messages[messageIndex];
                    if (charIndex < message.length) {
                        terminalElement.textContent += message.charAt(charIndex);
                        charIndex++;
                        setTimeout(typeText, 30);
                    } else {
                        terminalElement.textContent += '\n';
                        messageIndex++;
                        charIndex = 0;
                        setTimeout(typeText, 1000);
                    }
                }
            }
            
            typeText();
        });
    </script>
</body>
</html>