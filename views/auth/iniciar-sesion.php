<div class="contenedor login">
    <?php include_once __DIR__ . "/../templates/nombre-sitio.php";?>
    
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Inicia sesion en UpTask</p>
        <?php include_once __DIR__ . "/../templates/alertas.php";?>

        <form class="formulario" method="POST">
            <div class="campo">
                <label for="email">Email</label>
                <input
                type="email"
                name="email"
                id="email"
                placeholder="Tu Email"
                value="<?php echo $correo; ?>"
                >
            </div> <!-- Campo -->
            
            <div class="campo">
                <label for="password">Contraseña</label>
                <input
                type="password"
                name="password"
                id="password"
                placeholder="Tu Contraseña"
                >
            </div> <!-- Campo -->

            <input class="boton" type="submit" value="Iniciar Sesión">
        </form>

        <div class="acciones">
            <a href="/cuenta/crear">¿Aún no tienes cuenta? Crea una</a>
            <a href="/cuenta/password/olvide">¿Olvidaste tu Contraseña?</a>
        </div>
    </div>
</div>