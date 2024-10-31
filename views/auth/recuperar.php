<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Ingresa tu nuevo Password</p>

<?php
include_once __DIR__ . "/../templates/alertas.php"
?>

<?php
if ($error) {
?>
    <div class="acciones">
        <a href="/">¿Ya tienes una cuenta? Iniciar Sesión</a>
        <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear cuenta</a>
    </div>
<?php
    return;
}
?>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Nuevo Password" />
    </div>
    <input class="boton" type="submit" value="Confirmar">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Iniciar Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear cuenta</a>
</div>