<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animus - Editar Recuerdo</title>
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
</head>
<body class="bg-abstergo-dark font-rajdhani text-white flex flex-col min-h-screen">
    <!-- Barra de navegación superior -->
    <nav class="bg-black/80 border-b border-abstergo-blue py-4 px-6">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ asset('images/abstergo-logo.png') }}" alt="Abstergo" class="h-8 mr-4">
                <span class="text-2xl font-semibold text-abstergo-blue tracking-wider">ANIMUS OS</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard') }}" class="text-white hover:text-abstergo-blue transition-colors">
                    Dashboard
                </a>
                <a href="{{ route('recuerdos.index') }}" class="text-white hover:text-abstergo-blue transition-colors">
                    Gestionar Recuerdos
                </a>
                <span class="mx-4 text-sm opacity-80">Usuario: {{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-abstergo-blue/20 hover:bg-abstergo-blue/30 text-white px-4 py-2 rounded transition-all">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </nav>
    
    <!-- Contenido principal -->
    <main class="container mx-auto px-4 py-6 flex-grow">
        <div class="flex items-center mb-8">
            <a href="{{ route('recuerdos.index') }}" class="text-abstergo-blue hover:text-abstergo-light-blue mr-4">
                &larr; Volver
            </a>
            <h1 class="text-3xl font-semibold text-abstergo-blue">
                Editar Recuerdo: {{ $recuerdo->title }}
            </h1>
        </div>
        
        <!-- Errores de validación -->
        @if ($errors->any())
            <div class="bg-red-900/20 border-l-4 border-red-600 p-4 mb-6">
                <div class="text-red-400 font-medium mb-2">Se encontraron los siguientes errores:</div>
                <ul class="list-disc ml-6 text-red-300">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <!-- Formulario -->
        <div class="bg-black/50 border border-abstergo-blue/40 rounded-lg p-6">
            <form action="{{ route('recuerdos.update', $recuerdo->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="mb-4">
                            <label for="title" class="block text-abstergo-light-blue mb-2">Título</label>
                            <input type="text" name="title" id="title" class="w-full bg-abstergo-dark/70 border border-abstergo-blue/40 rounded py-2 px-3 text-white" value="{{ old('title', $recuerdo->title) }}" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="subtitle" class="block text-abstergo-light-blue mb-2">Subtítulo</label>
                            <input type="text" name="subtitle" id="subtitle" class="w-full bg-abstergo-dark/70 border border-abstergo-blue/40 rounded py-2 px-3 text-white" value="{{ old('subtitle', $recuerdo->subtitle) }}">
                        </div>
                        
                        <div class="mb-4">
                            <label for="position" class="block text-abstergo-light-blue mb-2">Posición</label>
                            <input type="number" name="position" id="position" class="w-full bg-abstergo-dark/70 border border-abstergo-blue/40 rounded py-2 px-3 text-white" value="{{ old('position', $recuerdo->position) }}">
                            <p class="text-xs text-gray-400 mt-1">Determina el orden de los recuerdos. Menor número = mayor prioridad.</p>
                        </div>
                        
                        <div class="mb-4">
                            <label for="path" class="block text-abstergo-light-blue mb-2">Ruta del ejecutable (.exe)</label>
                            <input type="text" name="path" id="path" class="w-full bg-abstergo-dark/70 border border-abstergo-blue/40 rounded py-2 px-3 text-white" value="{{ old('path', $recuerdo->path) }}">
                            <p class="text-xs text-gray-400 mt-1">Ruta completa al ejecutable del juego. Ejemplo: C:\Juegos\AssassinsCreed\AC.exe</p>
                        </div>
                    </div>
                    
                    <div>
                        <div class="mb-4">
                            <label for="img" class="block text-abstergo-light-blue mb-2">Imagen</label>
                            <input type="file" name="img" id="img" class="w-full bg-abstergo-dark/70 border border-abstergo-blue/40 rounded py-2 px-3 text-white" accept="image/*">
                            <p class="text-xs text-gray-400 mt-1">Deja vacío para mantener la imagen actual. Formatos aceptados: JPG, PNG, GIF. Tamaño máximo: 2MB.</p>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-abstergo-light-blue mb-2">Imagen actual</label>
                            <div class="border border-dashed border-abstergo-blue/40 rounded h-40 flex items-center justify-center" id="imagePreview">
                                @if($recuerdo->img)
                                    <img src="{{ asset($recuerdo->img) }}" alt="{{ $recuerdo->title }}" class="h-full w-auto object-contain mx-auto">
                                @else
                                    <span class="text-gray-400">No hay imagen</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-between mt-6">
                    <a href="{{ route('recuerdos.show', $recuerdo->id) }}" class="bg-abstergo-gray hover:bg-abstergo-gray/80 text-white px-6 py-3 rounded transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-abstergo-blue hover:bg-abstergo-light-blue text-white px-6 py-3 rounded transition-colors">
                        Actualizar Recuerdo
                    </button>
                </div>
            </form>
        </div>
    </main>
    
    <!-- Pie de página (siempre al fondo) -->
    <footer class="bg-black/80 border-t border-abstergo-blue py-4 px-6 text-center text-sm opacity-70 mt-auto">
        <p>ABSTERGO INDUSTRIES &copy; {{ date('Y') }} - ANIMUS OS v4.27</p>
        <p class="mt-1">SISTEMA DE RECUPERACIÓN DE MEMORIAS GENÉTICAS</p>
    </footer>
    
    <script>
        // Vista previa de imagen
        document.getElementById('img').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('h-full', 'w-auto', 'object-contain', 'mx-auto');
                    preview.appendChild(img);
                }
                
                reader.readAsDataURL(this.files[0]);
            } else {
                // Restaurar imagen original si existe
                @if($recuerdo->img)
                    preview.innerHTML = '<img src="{{ asset($recuerdo->img) }}" alt="{{ $recuerdo->title }}" class="h-full w-auto object-contain mx-auto">';
                @else
                    preview.innerHTML = '<span class="text-gray-400">No hay imagen</span>';
                @endif
            }
        });
    </script>
</body>
</html>