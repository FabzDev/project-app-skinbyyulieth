<?php

namespace Controllers;

use MVC\Router;

class CitasController
{
    public static function index(Router $router) {
        session_start();
        
        $router->render('auth/citas', [
            'nombre' => $_SESSION['nombreCompleto'],
        ]);
    }
}
