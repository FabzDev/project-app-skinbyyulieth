<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
    public static function login(Router $inst1Router){
        if($_SERVER['REQUEST_METHOD'] =='POST'){
            $auth = new Usuario;
            $alertas=[];
            $auth->sincronizar($_POST);
            if(!$auth->email){
                $alertas['error'][]='Ingresa tu Email para iniciar sesión';
            }
            if(!$auth->password){
                $alertas['error'][]='Ingresa tu Password para iniciar sesión';
            }
        }

        $inst1Router->render('auth/login', [
            'alerts' => $alertas,
            'auth' => $auth
        ]);
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

    public static function crear(Router $inst3Router)
    {
        $usuario = new Usuario;
        $alertas = [];
        //Al enviar metodo post
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            //Validar campos formulario
            $alertas = $usuario->validarNuevaCuenta();
            if (empty($alertas)) {
                if ($usuario->existeUsuario()) {
                    $alertas = Usuario::getAlertas();
                } else {
                    //Hashear password
                    $usuario->hashPassword();

                    //Generar token
                    $usuario->createToken();

                    //Enviar email confirmation
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarConfirmacion();

                    // Crear usuario en DB
                    $resultadoSQL = $usuario->guardar();
                    if ($resultadoSQL) {
                        header('Location: /mensaje');
                    }
                }
            }
        }

        $inst3Router->render('auth/crear-cuenta', [
            'user' => $usuario,
            'alerts' => $alertas
        ]);
    }

    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje', []);
    }

    public static function confirmar(Router $router)
    {
        $alertas = [];
        $token = trim(s($_GET['token']));
        $user = new Usuario;
        $user = Usuario::where('token', $token);
        if (trim($user->token) == $token) {
            Usuario::setAlerta('exito', 'Tu cuenta ha sido activada');
            $user->token = null;
            $user->confirmado = '1';
            $user->guardar();
        } else {
            Usuario::setAlerta('error', 'Token invalido');
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta', [
            'alerts' => $alertas
        ]);
    }
}
