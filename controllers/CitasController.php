<?php

namespace Controllers;

use MVC\Router;

class CitasController
{
    public static function index(Router $router) {
        isAuth();
        $router->render('citas/index', [
            'nombre' => $_SESSION['nombreCompleto'],
            'idUser' => $_SESSION['id'],
        ]);
    }
}
