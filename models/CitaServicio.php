<?php

namespace Model;

class CitaServicio extends ActiveRecord
{
    //Base de datos
    protected static $tabla = 'citas_servicios';
    protected static $columnasDB = ['id', 'citasId', 'serviciosId'];

    public $id;
    public $citasId;
    public $serviciosId;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->citasId = $args['citaId'] ?? '';
        $this->serviciosId = $args['servicioId'] ?? '';
    }

}
?>