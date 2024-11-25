<?php
    include_once __DIR__ . "/../templates/barra.php"
?>

<h1 class="nombre-pagina">Crear nuevo Servicio</h1>
<p class="descripcion-pagina">Ingresa la información del servicio</p>

<form action="/servicios/crear" method="POST" class="formulario">
    <?php include_once __DIR__ . "/formulario.php" ?>
    <input type="submit" class="boton" value="Guardar Servicio">
</form>
