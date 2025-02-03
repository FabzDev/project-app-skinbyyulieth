<?php
include_once __DIR__ . "/../templates/barra.php"
?>
<h1 class="nombre-pagina">Panel de Administración</h1>

<h2>Buscar Citas</h2>
<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input
                type="date"
                id="fecha"
                name="fecha"
                value="<?php echo $fechaActual; ?>">
        </div>
    </form>
</div>

<div id="citas-admin">
    <ul class="citas">
        <?php
        $idCita = 0;
        $total = 0;

        if (count($citas) === 0) {
        ?>
            <h2 class="servicios-title">No hay citas en esta fecha</h2>
            <?php
        }

        foreach ($citas as $key => $cita) {
            if ($idCita != $cita->id) {
                $total = 0;
            ?>
                <li>
                    <p>ID: <span><?php echo $cita->id; ?></span></p>
                    <p>Hora: <span><?php echo $cita->hora; ?></span></p>
                    <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
                    <p>Email: <span><?php echo $cita->email; ?></span></p>
                    <p>Telefono: <span><?php echo $cita->telefono; ?></span></p>
                    <?php
                    $idCita = $cita->id;
                    ?>
                    <h2 class="servicios-title">Servicios</h2>
                <?php
            } //Fin del if
            $total += $cita->precio;
                ?>
                <p class="servicio"><?php echo $cita->servicio; ?> - <span>$<?php echo number_format($cita->precio, 0, '', '.'); ?></span></p>
                <?php
                // debuguear($citas);
                if (!isset($citas[$key + 1]->id) || $cita->id != $citas[$key + 1]->id) {
                ?>
                    <p class="total">Total: <span>$<?php echo number_format($total, 0, '', '.'); ?></span></p>
                    
                    <form action="/api/eliminar" method="POST">
                        <input type="hidden" name="id" value="<?php echo $cita->id ?>" />
                        <input type="submit" class="boton-eliminar" value="Eliminar" />
                    </form>
            <?php
                }
            } //Fin del for each
            ?>
                </li>
    </ul>
</div>

<?php
$script = '<script src="build/js/buscador.js"></script>';
?>