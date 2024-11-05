<?php

namespace Controllers;

use Model\Servicio;

class APIController{
    // Retornar todos los servicios
    public static function index() {
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    // Guardar citas
    public static function guardarCita(){
        $respuesta = ['mi respuesta'=>'TODO OK CANADA'];
        echo json_encode($respuesta);
    }





}