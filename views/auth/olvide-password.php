<div class="contenedor olvide-password">
<?php include_once __DIR__ . "/../templates/nombre-sitio.php";?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recupera tu Contraseña ingresando el Correo registrado</p>
        <?php include_once __DIR__ . "/../templates/alertas.php" ?>

        <form class="formulario" method="POST">

            <div class="campo">
                <label for="email">Email</label>
                <input
                type="email"
                name="email"
                id="email"
                placeholder="Tu Email"
                >
            </div> <!-- Campo -->

            <input class="boton" type="submit" value="Enviar Correo">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
            <a href="/cuenta/crear">¿Aún no tienes cuenta? Crea una</a>
        </div>
    </div>
</div>