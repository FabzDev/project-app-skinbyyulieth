<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController
{
    public static function index(Router $router) {
        // debuguear($_SESSION);

        isAdmin();
        $fechaSel = $_GET['fecha'] ?? date('Y-m-d');
        $fechaValidar = explode('-', $fechaSel);

        if(!checkdate($fechaValidar[1],$fechaValidar[2],$fechaValidar[0])){
            header('Location: /404');
        };

        $consulta = "SELECT citas.id, citas.hora, CONCAT(usuarios.nombre,' ',usuarios.apellido) as cliente, usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio";
        $consulta .= " FROM citas";
        $consulta .= " LEFT OUTER JOIN usuarios";
        $consulta .= " ON citas.usuarioId=usuarios.id";
        $consulta .= " LEFT OUTER JOIN citas_servicios";
        $consulta .= " ON citas.id=citas_servicios.citasId";
        $consulta .= " LEFT OUTER JOIN servicios";
        
        // $consulta .= ' ON citas_servicios.serviciosId=servicios.id;';
        $consulta .= " ON citas_servicios.serviciosId=servicios.id";
        $consulta .= " WHERE fecha='".$fechaSel."';";

        // debuguear($consulta);

        $resultado = AdminCita::SQL($consulta);
        
        $router->render('admin/index', [
            'nombre' => $_SESSION['nombreCompleto'],
            'citas' => $resultado,
            'fechaActual' => $fechaSel
        ]);
    }
}