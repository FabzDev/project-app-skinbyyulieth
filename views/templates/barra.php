<div class="barra">
    <p>Hola, <?php echo $nombre ?? '';?></p>
    <a class="boton" href="/logout">Cerrar Sesión</a>
</div>

<!-- PHP con html -->
 <?php
    if($_SESSION['admin']){
?>  
    <div class="barra-servicios">
        <a href="/admin" class="boton">Ver Citas</a>
        <a href="/servicios" class="boton">Ver Servicios</a>
        <a href="/servicios/nuevo" class="boton">Nuevo Servicio</a>
    </div>      
<?php
    }
?>