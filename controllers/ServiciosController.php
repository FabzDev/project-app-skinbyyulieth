<?php

namespace Controllers;

use MVC\Router;
use Model\Servicio;

class ServiciosController
{
    public static function index(Router $router)
    {
        isAdmin();
        $nombre = $_SESSION['nombreCompleto'];

        $servicios = Servicio::all();
        // debuguear($servicios);
        $router->render('servicios/index', [
            'servicios' => $servicios,
            'nombre' => $nombre,
        ]);
    }

    public static function crear(Router $router)
    {
        isAdmin();

        $nombre = $_SESSION['nombreCompleto'];

        $servicio = new Servicio;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $servicio->guardar();
            }

            header('Location: /servicios');
        }

        $router->render('servicios/crear', [
            'servicio' => $servicio,
            'alertas' => $alertas,
            'nombre' => $nombre
        ]);
    }

    public static function actualizar(Router $router)
    {
        isAdmin();
        $nombre = $_SESSION['nombreCompleto'];

        $servicio = new Servicio;
        $alertas = [];

        $id = $_GET['id'];
        if (!is_numeric($id)) return;
        $servicio = Servicio::find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/actualizar', [
            'servicio' => $servicio,
            'alertas' => $alertas,
            'nombre' => $nombre
        ]);
    }

    public static function eliminar(Router $router)
    {
        isAdmin();

        $id = $_POST['id'];
        $servicio = Servicio::find($id);
        $servicio->eliminar();

        header('Location: /servicios');
        
    }
}
