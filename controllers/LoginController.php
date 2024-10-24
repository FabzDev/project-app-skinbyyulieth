<?php

namespace Controllers;

use MVC\Router;

class LoginController {
    public static function login(Router $instRouter){
        $instRouter->render('auth/login');
    }

    public static function logout(){
        echo "Desde Logout";
    }

    public static function olvide(){
        echo "Desde Olvide";
    }

    public static function recuperar(){
        echo "Desde Recuperar";
    }

    public static function crear(){
        echo "Desde Crear Cuenta";
    }

}