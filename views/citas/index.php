<h1 class="nombre-pagina">Crear nueva Cita</h1>
<p class="descripcion-pagina">Elige tus servicios a continuación:</p>

<nav class="tabs">
    <button type="button" data-paso="1" class="actual">Servicios</button>
    <button type="button" data-paso="2">Información Cita</button>
    <button type="button" data-paso="3">Resumen</button>
</nav>

<div class="app">
    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuación</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <div id="paso-2" class="seccion">
        <h2>Tus datos y cita</h2>
        <p class="text-center">Ingresa tus datos y fecha de tu cita</p>
        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input
                    id="nombre"
                    type="text"
                    value="<?php echo $nombre ?>"
                    disabled>
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input id="fecha" type="date">
            </div>
            <div class="campo">
                <label for="hora">Hora</label>
                <input id="hora" type="time">
            </div>
        </form>
    </div>
    <div id="paso-3" class="seccion">
        <h2>Resumen</h2>
        <p class="text-center">Verifica la información</p>
    </div>
</div>

<div class="paginacion">
    <button class="boton" id="anterior" >&laquo Anterior</button>
    <button class="boton" id="siguiente">Siguiente &raquo</button>
</div>

<?php
    $script = "<script src='/build/js/app.js'></script>"
?>