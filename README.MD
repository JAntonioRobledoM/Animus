# 🎮 Animus Game Launcher

<div align="center">

![Animus Logo](https://e1.pngegg.com/pngimages/377/428/png-clipart-animus-logo-black-logo.png)

**Un launcher de juegos inspirado en el universo de Assassin's Creed**

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Electron](https://img.shields.io/badge/Electron-191970?style=for-the-badge&logo=Electron&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)

</div>

## 📋 Descripción

Animus Launcher es una aplicación de escritorio que simula la interfaz del Animus de la saga Assassin's Creed, funcionando como un launcher personalizado para organizar y ejecutar tus juegos favoritos. La aplicación combina la potencia del framework Laravel con la versatilidad de Electron para crear una experiencia inmersiva única.

### ⚠️ Aviso Legal

**Este proyecto es completamente sin fines de lucro y ha sido desarrollado únicamente con propósitos de entretenimiento y aprendizaje. No tiene ninguna afiliación, patrocinio o respaldo de Ubisoft Entertainment. Todos los derechos de la franquicia Assassin's Creed pertenecen a Ubisoft.**

## ✨ Características

- 🎨 **Interfaz Temática**: Diseño inspirado en el Animus con elementos visuales de la saga
- 🚀 **Launcher de Juegos**: Organiza y ejecuta tus juegos desde una interfaz única
- 📊 **Gestión de Biblioteca**: Añade, categoriza y gestiona tu colección de juegos
- ⚡ **Rendimiento Optimizado**: Aplicación ligera y responsive

## 🛠️ Tecnologías Utilizadas

### Backend
- **Laravel 12** - Framework PHP para la lógica del servidor
- **SQLite** - Base de datos ligera para almacenar información de juegos
- **Artisan** - CLI de Laravel para comandos personalizados

### Frontend & Desktop
- **Electron** - Framework para aplicaciones de escritorio multiplataforma
- **HTML5/CSS3** - Estructura y estilos responsivos
- **JavaScript ES6+** - Lógica del cliente y interacciones
- **Bootstrap 5** - Framework CSS para diseño responsive

## 📦 Instalación

### Prerrequisitos

- Node.js (v16 o superior)
- npm o yarn
- PHP 8.1 o superior
- Composer

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/JAntonioRobledoM/Animus.git
cd animus-laravel
```

2. **Instalar dependencias de Laravel**
```bash
composer install
```

3. **Configurar el entorno**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurar la base de datos**
```bash
php artisan migrate
php artisan db:seed
```

5. **Instalar dependencias de Electron**
```bash
cd ..
cd animus-electron
npm install
```

6. **Construir la aplicación**
```bash
npm run build
```

7. **Ejecutar la aplicación**
```bash
npm run electron
```

## 🚀 Uso

### Primera Ejecución

1. Al abrir la aplicación, serás recibido por la secuencia de inicialización del Animus
2. Configura tu perfil de usuario y preferencias
3. Añade tus juegos a la biblioteca y ajusta la ruta del acceso directo
4. Inicialos desde la interfaz

### Añadir Juegos

- **Añadir Manualmente**: Pulsa el botoón de añadir recuerdo e introduce sus datos

## 🎮 Características del Animus

### Interfaz de Usuario
- **Secuencia de Inicialización**: Animación de arranque al estilo Animus
- **Navegación Holográfica**: Menús y elementos con efectos visuales futuristas
- **Perfiles de Memoria**: Organización de juegos como "memorias genéticas"
- **Sincronización**: Efectos de "sincronización" al cargar juegos

¡Las contribuciones son bienvenidas! Si quieres mejorar el proyecto:

1. Fork el repositorio
2. Crea una rama para tu feature (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -m 'Añadir nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Abre un Pull Request

### Guías de Contribución

- Sigue las convenciones de código del proyecto
- Añade tests para nuevas funcionalidades
- Respeta el tema y la estética del Animus

## 🙏 Reconocimientos

- **Ubisoft** - Por crear el increíble universo de Assassin's Creed que inspiró este proyecto
- **Comunidad Laravel** - Por el excelente framework y documentación
- **Equipo de Electron** - Por hacer posible las aplicaciones de escritorio con tecnologías web
- **Comunidad Open Source** - Por todas las librerías y herramientas utilizadas

## 📞 Contacto

Si tienes preguntas, sugerencias o quieres reportar un bug:

- 📧 Email: jantoniorobledomoreno@gmail.com

---

<div align="center">

**"Nada es verdad, todo esta permitido"**

*Desarrollado con ❤️ por un fan de Assassin's Creed*

</div>