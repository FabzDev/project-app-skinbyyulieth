<?php

namespace Model;

class Usuario extends ActiveRecord {
    //Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email','password','telefono', 'admin', 'confirmado','token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __contruct($args = []){
        $this->id=$args['id'] ?? null;
        $this->nombre=$args['nombre'] ?? '';
        $this->apellido=$args['apellido'] ?? '';
        $this->password=$args('password');
        $this->email=$args('telefono');
        $this->email=$args('admins');
}

tabla'usuarios'

columnas

constructor

variables = $mivariable

