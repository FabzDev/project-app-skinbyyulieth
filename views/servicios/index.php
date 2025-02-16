<?php
include_once __DIR__ . "/../templates/barra.php"
?>

<h1 class="nombre-pagina">Administrador de Servicios</h1>
<p class="descripcion-pagina">Información de servicios</p>

<ul class="servicios">
    <?php
    foreach ($servicios as $servicio) {
    ?>
        <li>
            <p>Nombre: <span><?php echo $servicio->nombre; ?></span></p>
            <p>Precio: <span>$<?php echo number_format($servicio->precio, 0, '', '.'); ?></span></p>
            
            <div class="acciones">
                <a class="boton" href="/servicios/actualizar?id=<?php echo $servicio->id; ?>">Actualizar</a>
                <form action="/servicios/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $servicio->id; ?>">
                    <input type="submit" class="boton-eliminar" value="Eliminar">
                </form>
            </div>
        </li>
    <?php
    }
    ?>
</ul>