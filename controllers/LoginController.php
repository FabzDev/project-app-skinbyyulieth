<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
    public static function login(Router $inst1Router)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $auth = new Usuario;
            $alertas = [];
            $auth->sincronizar($_POST);
            if (!$auth->email) {
                $alertas['error'][] = 'Ingresa tu Email para iniciar sesión';
            }
            if (!$auth->password) {
                $alertas['error'][] = 'Ingresa tu Password para iniciar sesión';
            }
            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);
                if ($usuario) {
                    if ($usuario->validarPasswordAndVerificado($auth->password)) {
                        //Autenticar el usuario
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombreCompleto'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //Redireccionamiento
                        if ($usuario->admin) {
                            $_SESSION['admin'] = true;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }

                        debuguear($_SESSION);
                    } else {
                        $alertas['error'][] = 'El password ingresado no es correcto, o tu cuenta no ha sido validada';
                    }
                } else {
                    $alertas['error'][] = 'El correo ingresado no es valido';
                }
            }
        }

        $inst1Router->render('auth/login', [
            'alerts' => $alertas,
            'auth' => $auth
        ]);
    }

    public static function logout() {}

    public static function olvide(Router $inst2Router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new usuario($_POST);
            $alertas = $auth->validarEmail();
            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);
                if ($usuario && $usuario->confirmado == true) {
                    Usuario::setAlerta('exito', 'Revisa tu E-mail');
                    $usuario->createToken();
                    $usuario->guardar();
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarInstrucciones();
                } else {
                    Usuario::setAlerta('error', 'El correo no existe o no ha sido activado');
                }
                $alertas = Usuario::getAlertas();
            }
        }

        $inst2Router->render('auth/olvide-password', [
            'alerts' => $alertas
        ]);
    }

    public static function recuperar(Router $router)
    {
        $alertas = [];
        $error = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = s($_GET['token']);
            $password = $_POST['password'];
            $usuarioDB = Usuario::where('token', $token);
            if ($usuarioDB->token == $token) {
                Usuario::setAlerta('exito', 'Password actualizado');
                $usuarioDB->password = $password;
                $usuarioDB->hashPassword();
                $usuarioDB->guardar();
            } else {
                Usuario::setAlerta('error', 'Token invalido');
            }

            $error = true;
            $alertas = Usuario::getAlertas();
            // debuguear($password);
        }

        $router->render('auth/recuperar', [
            'alerts' => $alertas,
            'error' => $error
        ]);
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
