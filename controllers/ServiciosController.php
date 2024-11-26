<?php

namespace Controllers;

use MVC\Router;
use Model\Servicio;

class ServiciosController
{
    public static function index(Router $router) {
        session_start();
        isAdmin();

        $servicios = Servicio::all();
        // debuguear($servicios);
        $router->render('servicios/index', [
            'servicios' => $servicios
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
        $id = $_GET['id'];
        if(!is_numeric($id)) return;
        $servicio = Servicio::find($id);

        if($_SERVER['REQUEST_METHOD']=== 'POST'){
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if(empty($alertas)){
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        // debuguear($servicio);
        $router->render('servicios/actualizar', [
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar(Router $router) {
        session_start();
        isAdmin();
    }
}