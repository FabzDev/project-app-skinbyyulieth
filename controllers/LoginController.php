<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;

class LoginController
{
    public static function login(Router $inst1Router)
    {
        $inst1Router->render('auth/login', []);
    }

    public static function logout()
    {
        echo "Desde Logout";
    }

    public static function olvide(Router $inst2Router)
    {
        $inst2Router->render('auth/olvide-password', []);
    }

    public static function recuperar()
    {
        echo "Desde Recuperar";
    }

    public static function crear(Router $inst3Router){
        $usuario = new Usuario;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
        }


        $inst3Router->render('auth/crear-cuenta', [
            'user' => $usuario
        ]);
    }
}
