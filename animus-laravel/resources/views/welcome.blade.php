<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animus - Abstergo Industries</title>
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
                        'scan-line': 'scan-line 3s linear infinite',
                        'flicker': 'flicker 5s linear infinite',
                        'data-flow': 'data-flow 3s linear infinite',
                        'dna-rotate': 'dna-rotate 15s linear infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'rotate-slow': 'rotate-slow 20s linear infinite',
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
                        },
                        'scan-line': {
                            '0%': { left: '-100%' },
                            '100%': { left: '100%' },
                        },
                        'flicker': {
                            '0%, 19.999%, 22%, 62.999%, 64%, 64.999%, 70%, 100%': { opacity: '0.99' },
                            '20%, 21.999%, 63%, 63.999%, 65%, 69.999%': { opacity: '0.4' },
                        },
                        'data-flow': {
                            '0%': { transform: 'translateX(-100%)' },
                            '100%': { transform: 'translateX(100%)' },
                        },
                        'dna-rotate': {
                            '0%': { transform: 'translateY(-300px) rotateZ(0deg)' },
                            '100%': { transform: 'translateY(300px) rotateZ(360deg)' },
                        },
                        'float': {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        'rotate-slow': {
                            '0%': { transform: 'rotate(0deg)' },
                            '100%': { transform: 'rotate(360deg)' },
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
            overflow: hidden;
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
        
        .login-card {
            backdrop-filter: blur(10px);
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.8) 0%, rgba(26, 26, 26, 0.6) 100%);
            box-shadow: 0 8px 32px rgba(0, 130, 202, 0.3);
        }
        
        .input-glow {
            transition: all 0.3s ease;
        }
        
        .input-glow:focus {
            box-shadow: 0 0 20px rgba(0, 130, 202, 0.5);
            border-color: #00a8ff;
        }
        
        .terminal-text {
            text-shadow: 0 0 10px #0082CA;
        }
        
        .geometric-bg {
            position: absolute;
            width: 200px;
            height: 200px;
            border: 1px solid rgba(0, 130, 202, 0.2);
            border-radius: 50%;
            animation: rotate-slow 20s linear infinite;
        }
        
        .geometric-bg::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100px;
            height: 100px;
            border: 1px solid rgba(0, 168, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }
        
        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: #0082CA;
            border-radius: 50%;
            opacity: 0.7;
        }
        
        @keyframes particle-float {
            0% { transform: translateY(100vh) translateX(0px); opacity: 0; }
            10% { opacity: 0.7; }
            90% { opacity: 0.7; }
            100% { transform: translateY(-100px) translateX(50px); opacity: 0; }
        }
    </style>
</head>
<body class="bg-abstergo-dark font-rajdhani text-white min-h-screen relative">
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

    <!-- Elementos geométricos de fondo -->
    <div class="geometric-bg" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
    <div class="geometric-bg" style="top: 60%; right: 15%; animation-delay: 5s; animation-duration: 25s;"></div>
    <div class="geometric-bg" style="top: 10%; right: 30%; width: 150px; height: 150px; animation-delay: 10s; animation-duration: 15s;"></div>

    <!-- Línea de escaneo global -->
    <div class="scan-line"></div>

    <!-- Elementos de fondo adicionales -->
    <div class="absolute inset-0 z-0 overflow-hidden">
        <!-- Línea de ADN -->
        <div class="absolute top-0 right-[10%] w-[2px] h-[200%] bg-gradient-to-b from-transparent via-abstergo-blue to-transparent opacity-50 animate-dna-rotate">
            <div class="absolute top-[30%] left-0 w-[100px] h-[1px] bg-abstergo-blue"></div>
            <div class="absolute top-[70%] right-0 w-[100px] h-[1px] bg-abstergo-blue"></div>
        </div>
        
        <!-- Flujo de datos -->
        <div class="absolute bottom-[5%] left-0 w-full h-[1px] bg-abstergo-blue opacity-60">
            <div class="absolute w-full h-full bg-gradient-to-r from-transparent via-abstergo-blue to-transparent animate-data-flow"></div>
        </div>
        
        <!-- Línea de ADN izquierda -->
        <div class="absolute top-0 left-[15%] w-[1px] h-[200%] bg-gradient-to-b from-transparent via-abstergo-accent to-transparent opacity-30 animate-dna-rotate" style="animation-delay: 8s; animation-duration: 18s;">
            <div class="absolute top-[40%] right-0 w-[80px] h-[1px] bg-abstergo-accent"></div>
            <div class="absolute top-[80%] left-0 w-[80px] h-[1px] bg-abstergo-accent"></div>
        </div>
        
        <!-- Terminal de texto -->
        <div id="terminal" class="absolute bottom-5 left-5 font-orbitron text-xs text-abstergo-accent opacity-70 whitespace-pre max-w-md terminal-text z-10"></div>
        
        <!-- Información del sistema -->
        <div class="absolute top-5 right-5 text-right font-orbitron text-xs text-abstergo-blue opacity-70 z-10">
            <div class="mb-2">ANIMUS OS v1.0</div>
            <div class="mb-2">STATUS: <span class="text-green-400 animate-pulse">ONLINE</span></div>
            <div class="mb-2">GENETIC DATABASE: <span class="text-abstergo-accent">READY</span></div>
            <div>SYNC LEVEL: <span class="text-abstergo-gold">OPTIMAL</span></div>
        </div>
    </div>

    <!-- Contenedor principal -->
    <div class="flex justify-center items-center min-h-screen relative z-20 px-4">
        <div class="login-card hologram-border rounded-xl p-8 w-full max-w-md relative overflow-hidden animate-float">
            <!-- Línea de escaneo del card -->
            <div class="absolute top-0 left-[-50%] w-[200%] h-[2px] bg-gradient-to-r from-transparent via-abstergo-blue to-transparent animate-scan-line"></div>
            
            <!-- Logo Abstergo -->
            <div class="text-center mb-8 relative">
                <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-abstergo-blue to-abstergo-accent rounded-full flex items-center justify-center animate-pulse-blue relative">
                    <div class="w-12 h-12 bg-white rounded-full opacity-90 flex items-center justify-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-abstergo-blue to-abstergo-accent rounded-full"></div>
                    </div>
                    <!-- Anillos orbitales -->
                    <div class="absolute inset-0 border-2 border-abstergo-blue/30 rounded-full animate-ping"></div>
                    <div class="absolute inset-2 border border-abstergo-accent/20 rounded-full animate-pulse"></div>
                </div>
                <div class="text-sm text-abstergo-accent font-orbitron opacity-80 mb-2">ABSTERGO INDUSTRIES</div>
            </div>
            
            <!-- Texto Animus -->
            <div class="text-center mb-8 relative">
                <h1 class="text-4xl font-orbitron font-bold text-hologram animate-glow tracking-widest">
                    ANIMUS
                </h1>
                <div class="text-lg font-orbitron text-abstergo-accent opacity-80 mt-1">
                    OPERATING SYSTEM
                </div>
                <div class="absolute -top-2 -right-2 text-xs font-orbitron text-abstergo-gold bg-abstergo-gold/20 px-2 py-1 rounded border border-abstergo-gold/50">
                    v1.0
                </div>
                <div class="mt-4 h-0.5 bg-gradient-to-r from-transparent via-abstergo-blue to-transparent"></div>
            </div>
            
            <!-- Mensaje de estado del sistema -->
            <div class="text-center mb-6 p-3 bg-abstergo-blue/10 border border-abstergo-blue/30 rounded-lg">
                <div class="text-sm text-abstergo-accent font-orbitron">
                    <span class="animate-pulse">●</span> SISTEMA DE RECUPERACIÓN DE MEMORIAS GENÉTICAS
                </div>
            </div>
            
            <!-- Mensaje de error -->
            @if(session('error'))
                <div class="bg-gradient-to-r from-red-500/20 to-red-600/20 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg">
                    <div class="flex items-center">
                        <div class="w-6 h-6 bg-red-400 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-black" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="text-red-300 font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif
            
            <!-- Formulario de login -->
            <form method="POST" action="{{ route('login.submit') }}" class="space-y-6">
                @csrf
                <div class="relative">
                    <label for="name" class="block mb-2 text-sm text-abstergo-accent font-orbitron tracking-wider uppercase">
                        ID DE SUJETO
                    </label>
                    <div class="relative">
                        <input type="text" id="name" name="name" required autofocus
                               class="w-full py-3 px-4 bg-black/50 border border-abstergo-blue/50 rounded-lg text-white font-rajdhani text-base transition-all focus:outline-none input-glow hologram-border">
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <div class="w-2 h-2 bg-abstergo-blue rounded-full animate-pulse"></div>
                        </div>
                    </div>
                </div>
                
                <div class="relative">
                    <label for="password" class="block mb-2 text-sm text-abstergo-accent font-orbitron tracking-wider uppercase">
                        CÓDIGO DE ACCESO
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                               class="w-full py-3 px-4 bg-black/50 border border-abstergo-blue/50 rounded-lg text-white font-rajdhani text-base transition-all focus:outline-none input-glow hologram-border">
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <div class="w-2 h-2 bg-abstergo-accent rounded-full animate-pulse"></div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 text-center">
                    <button type="submit" 
                            class="w-full btn-hologram text-white py-4 px-8 font-orbitron text-base font-semibold tracking-widest cursor-pointer transition-all rounded-lg hover:scale-105 shadow-lg relative overflow-hidden">
                        <span class="relative z-10">INICIALIZAR SESION</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-abstergo-blue/20 via-abstergo-accent/20 to-abstergo-blue/20 opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
                    </button>
                </div>
            </form>
            
            <!-- Barra de progreso decorativa -->
            <div class="mt-6 w-full h-1 bg-black/50 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-abstergo-blue to-abstergo-accent rounded-full animate-pulse" style="width: 85%;"></div>
            </div>
            
            <!-- Footer -->
            <div class="mt-8 text-center text-xs font-orbitron opacity-70 space-y-2">
                <p class="text-abstergo-accent">ABSTERGO INDUSTRIES &copy; {{ date('Y') }}</p>
                <p class="text-white">ANIMUS OS - TODOS LOS DERECHOS RESERVADOS</p>
                <div class="mt-4 p-2 bg-red-500/10 border border-red-500/30 rounded text-red-400">
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>ACCESO RESTRINGIDO - SOLO PERSONAL AUTORIZADO</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Partículas flotantes -->
    <div id="particles"></div>
    
    <script>
        // Efecto de tipeo para pantalla de login
        document.addEventListener('DOMContentLoaded', function() {
            const messages = [
                'Inicializando sistema Animus...',
                'Verificando bases de datos genéticas...',
                'Cargando protocolos de sincronización...',
                'Preparando interfaz de memoria...',
                'Escaneando secuencias de ADN disponibles...',
                'Calibrando parámetros temporales...',
                'Activando filtros de recuerdos...',
                'Sistema Animus completamente operativo.',
                'Esperando credenciales de acceso autorizado...'
            ];
            
            const terminalElement = document.getElementById('terminal');
            
            let messageIndex = 0;
            let charIndex = 0;
            let currentLine = '';
            
            function typeText() {
                if (messageIndex < messages.length) {
                    const message = messages[messageIndex];
                    if (charIndex < message.length) {
                        currentLine += message.charAt(charIndex);
                        terminalElement.textContent = terminalElement.textContent.replace(/^.*$/m, currentLine);
                        charIndex++;
                        setTimeout(typeText, 30);
                    } else {
                        terminalElement.textContent += '\n';
                        currentLine = '';
                        messageIndex++;
                        charIndex = 0;
                        setTimeout(typeText, messageIndex < messages.length - 2 ? 800 : 2000);
                    }
                }
            }
            
            // Crear partículas flotantes
            function createParticles() {
                const particlesContainer = document.getElementById('particles');
                
                for (let i = 0; i < 20; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'particle';
                    particle.style.left = Math.random() * 100 + '%';
                    particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
                    particle.style.animationDelay = Math.random() * 5 + 's';
                    particle.style.animation = 'particle-float ' + particle.style.animationDuration + ' linear infinite';
                    particle.style.animationDelay = particle.style.animationDelay;
                    particlesContainer.appendChild(particle);
                }
            }
            
            typeText();
            createParticles();
            
            // Efecto de parpadeo aleatorio para elementos
            setInterval(() => {
                const glowElements = document.querySelectorAll('.animate-glow, .animate-pulse');
                glowElements.forEach(el => {
                    if (Math.random() > 0.7) {
                        el.style.opacity = '0.3';
                        setTimeout(() => {
                            el.style.opacity = '1';
                        }, 100);
                    }
                });
            }, 5000);
        });
    </script>
</body>
</html>