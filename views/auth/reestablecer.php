<div class="contenedor reestablecer">
<?php include_once __DIR__ . "/../templates/nombre-sitio.php";?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recupera tu Contraseña ingresando el Correo registrado</p>

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

            <input class="boton" type="submit" value="Enviar Correo">
        </form>
    </div>
</div>