<?php

namespace Controllers;

use MVC\Router;
use Model\Servicio;

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

        $servicio = new Servicio;
        $alertas = [];
        
        if($_SERVER['REQUEST_METHOD']=== 'POST'){
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if(empty($alertas)){
                $servicio->guardar();
            }
        }

        $router->render('servicios/crear', [
            'servicio' => $servicio,
            'alertas' => $alertas
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