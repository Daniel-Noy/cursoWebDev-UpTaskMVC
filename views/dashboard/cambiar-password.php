<?php include_once __DIR__ . "/header-dashboard.php" ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . "/../templates/alertas.php" ?>

    <a href="/perfil">Volver al perfil</a>

    <form class="formulario" method="POST">
        <div class="campo">
            <label for="actualPassword">Contraseña Actual</label>
            <input 
            type="password"
            id="actualPassword"
            name="actualPassword"
            placeholder="Tu Contraseña"
            >
        </div>

        <div class="campo">
            <label for="nuevoPassword">Nueva Contraseña</label>
            <input 
            type="password"
            id="nuevoPassword"
            name="nuevoPassword"
            placeholder="Tu nueva contraseña"
            >
        </div>

        <input type="submit" value="Cambiar Contraseña">
    </form>
</div>

<?php include_once __DIR__ . "/footer-dasboard.php" ?>