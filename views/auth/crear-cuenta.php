<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Ingresa tu información para crear una cuenta</p>
<?php
    include_once __DIR__ . "/../templates/alertas.php"
?>

<form class="formulario" method="POST" action="/crear-cuenta">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input 
            type="text"
            id="nombre"
            name="nombre"
            placeholder="Tu Nombre"
            value="<?php echo s($user->nombre) ?>"
        />
    </div>

    <div class="campo">
        <label for="apellido">Apellido</label>
        <input 
            type="text"
            id="apellido"
            name="apellido"
            placeholder="Tu Apellido"
            value="<?php echo s($user->apellido) ?>"

        />
    </div>

    <div class="campo">
        <label for="telefono">Teléfono</label>
        <input 
            type="text"
            id="telefono"
            name="telefono"
            placeholder="Tu Telefono"
            value="<?php echo s($user->telefono) ?>"
        />
    </div>

    <div class="campo">
        <label for="email">E-mail</label>
        <input 
        type="email"
        id="email"
        name="email"
        placeholder="Tu E-mail"
        value="<?php echo s($user->email) ?>"
        />
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input 
            type="password"
            name="password"
            id="password"
            placeholder="Tu Password"
        
        />
    </div>

    <input class="boton" type="submit" value="Crear Cuenta">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Iniciar Sesión</a>
    <a href="/olvide">¿Olvidaste tu password?</a>
</div>