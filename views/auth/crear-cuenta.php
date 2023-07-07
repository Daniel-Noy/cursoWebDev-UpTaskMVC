<div class="contenedor crear-cuenta">
    <h1 class="uptask-logo">Uptask</h1>
    <p class="tagline">Crea y administra tus proyectos</p>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesión</p>

        <?php include_once __DIR__ . "/../templates/alertas.php" ?>

        <form class="formulario" method="POST">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input
                type="text"
                name="nombre"
                id="nombre"
                placeholder="Tu nombre"
                value="<?php echo $usuario->nombre ?? ''; ?>"
                >
            </div> <!-- Campo -->

            <div class="campo">
                <label for="email">Email</label>
                <input
                type="email"
                name="email"
                id="email"
                placeholder="Tu Email"
                value="<?php echo $usuario->email ?? ''; ?>"
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

            <div class="campo">
                <label for="passwordCheck">Confirma contraseña</label>
                <input
                type="password"
                name="passwordCheck"
                id="passwordCheck"
                placeholder="Confirma tu Contraseña"
                >
            </div> <!-- Campo -->

            <input class="boton" type="submit" value="Crear Cuenta">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
            <a href="/cuenta/password/olvide">¿Olvidaste tu Contraseña?</a>
        </div>
    </div>
</div>