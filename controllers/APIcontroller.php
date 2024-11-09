<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController{
    // Retornar todos los servicios
    public static function index() {
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    // Guardar citas
    public static function guardarCita(){ //$_POST
        $cita = new Cita($_POST);
        $respCita = $cita->guardar();
        $citaId = $respCita['id'];
        $servicios = explode(",", $_POST['servicios']);
        foreach ($servicios as $servicio)   {
            $args = [
                'citaId' => $citaId,
                'servicioId' => $servicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }        
        echo json_encode($respCita);
    }
}