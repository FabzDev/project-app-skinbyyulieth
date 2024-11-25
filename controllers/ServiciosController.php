<?php

namespace Controllers;

use MVC\Router;

class ServiciosController
{
    public static function index(Router $router) {
        session_start();
        isAdmin();
        $router->render('servicios/index', [
            // 'nombre' => $_SESSION['nombreCompleto'],
        ]);
    }

    public static function crear(Router $router) {
        session_start();
        isAdmin();
        $router->render('servicios/crear', [
            // 'nombre' => $_SESSION['nombreCompleto'],
        ]);
    }

    public static function actualizar(Router $router) {
        session_start();
        isAdmin();
        $router->render('servicios/actualizar', [
            // 'nombre' => $_SESSION['nombreCompleto'],
        ]);
    }

    public static function eliminar(Router $router) {
        session_start();
        isAdmin();
    }
}