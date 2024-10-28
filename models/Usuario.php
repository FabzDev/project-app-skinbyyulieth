<?php

namespace Model;

class Usuario extends ActiveRecord
{
    //Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    //Validación de datos para nueva cuenta
    public function validarNuevaCuenta()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'Se requiere tu nombre para crear una cuenta';
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = 'Se requiere tu apellido para crear una cuenta';
        }
        if (!$this->telefono) {
            self::$alertas['error'][] = 'Se requiere un número de telefono para crear una cuenta';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'Se requiere un E-mail para crear una cuenta';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'El password ingresado no es valido';
        }
        return self::$alertas;
    }

    //Validar email repetido
    public function existeUsuario()
    {
        $query = "SELECT * FROM " . self::$tabla . " WHERE email='" . $this->email . "' LIMIT 1;";
        $result = self::$db->query($query);
        if ($result->num_rows) {
            self::$alertas['error'][] = 'El correo ingresado ya existe';
            return true;
        } else {
            return false;
        }
    }

    //Hashear Password
    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    //Crear un token
    public function createToken(){
        $this->token = uniqid();
    }
}
