<div class="contenedor reestablecer">
<?php include_once __DIR__ . "/../templates/nombre-sitio.php";?>

    <div class="contenedor-sm">
        <?php include_once __DIR__ . "/../templates/alertas.php" ?>
        
        <?php if ($usuario) :?>
            <p class="descripcion-pagina">Ingresa tu nueva contraseña</p>
            <form class="formulario" method="POST">

                <div class="campo">
                    <label for="password">Nueva Contraseña</label>
                    <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Nueva Contraseña"
                    >
                </div> <!-- Campo -->

                <div class="campo">
                <label for="passwordCheck">Confirma contraseña</label>
                <input
                type="password"
                name="passwordCheck"
                id="passwordCheck"
                placeholder="Confirma tu Contraseña"
                >
            </div> <!-- Campo -->

                <input class="boton" type="submit" value="Cambiar contraseña">
            </form>
        <?php endif; ?>

        <div class="acciones">
            <a href="/cuenta/crear">¿Aún no tienes cuenta? Crea una</a>
            <a href="/">Iniciar Sesión</a>
        </div>
    </div>
</div>