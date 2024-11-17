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
                name="fecha">
        </div>
    </form>
</div>

<div id="citas-admin">
    <ul class="citas">
        <?php
        $idCita = 0;
        foreach ($citas as $cita) {
            if ($idCita != $cita->id) {
        ?>
                <li>
                    <p>ID: <span><?php echo $cita->id;?></span></p>
                    <p>Hora: <span><?php echo $cita->hora;?></span></p>
                    <p>Cliente: <span><?php echo $cita->cliente;?></span></p>
                <?php
                $idCita = $cita->id;
                ?>
                <h2>Servicios</h2>
            <?php
            } //Fin del if
            ?>
            <p class="servicio"><?php echo $cita->servicio; ?></p>
        <?php
        } //Fin del for each
        ?>
        </li>
    </ul>
</div>