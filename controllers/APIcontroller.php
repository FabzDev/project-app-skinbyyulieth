<?php

namespace Controllers;

use Model\Citas;
use Model\Servicio;

class APIController{
    // Retornar todos los servicios
    public static function index() {
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    // Guardar citas
    public static function guardarCita(){
        
        $citas = new Citas($_POST);
        $respCitas = $citas->guardar();

        echo json_encode($respCitas);
        // echo json_encode();
    }





}