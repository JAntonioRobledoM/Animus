<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

header('Content-Security-Policy: default-src \'self\' \'unsafe-inline\' \'unsafe-eval\' http://localhost:* http://127.0.0.1:* data: blob:; script-src \'self\' \'unsafe-inline\' \'unsafe-eval\' http://localhost:* http://127.0.0.1:* https://cdn.tailwindcss.com data: blob:; style-src \'self\' \'unsafe-inline\' http://localhost:* http://127.0.0.1:* https://fonts.googleapis.com https://cdn.tailwindcss.com; font-src \'self\' data: https://fonts.gstatic.com; img-src \'self\' data: http://localhost:* http://127.0.0.1:* https://*.tile.openstreetmap.org https://*.openstreetmap.org blob:;');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Requested-With');

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

    