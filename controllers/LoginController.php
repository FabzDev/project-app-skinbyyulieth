<?php

namespace Controllers;

use MVC\Router;

class LoginController {
    public static function login(Router $inst1Router){
        $inst1Router->render('auth/login', [

        ]);
    }

    public static function logout(){
        echo "Desde Logout";
    }

    public static function olvide(Router $inst2Router){
        $inst2Router->render('auth/olvide-password', [

        ]);
    }

    public static function recuperar(){
        echo "Desde Recuperar";
    }

    public static function crear(Router $inst3Router){
        $inst3Router->render('auth/crear-cuenta', [
            
        ]);
    }

}