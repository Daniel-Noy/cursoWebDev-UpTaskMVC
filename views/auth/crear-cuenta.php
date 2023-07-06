<div class="contenedor crear-cuenta">
    <h1 class="uptask-logo">Uptask</h1>
    <p class="tagline">Crea y administra tus proyectos</p>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesión</p>

        <form class="formulario" method="POST">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input
                type="text"
                name="nombre"
                id="nombre"
                placeholder="Tu nombre"
                >
            </div> <!-- Campo -->

            <div class="campo">
                <label for="email">Email</label>
                <input
                type="email"
                name="email"
                id="email"
                placeholder="Tu Email"
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
                <label for="password-check">Confirma contraseña</label>
                <input
                type="password"
                name="password-check"
                id="password-check"
                placeholder="Confirma tu Contraseña"
                >
            </div> <!-- Campo -->

            <input class="boton" type="submit" value="Crear Cuenta">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
            <a href="/cuenta/contraseña/olvide">¿Olvidaste tu Contraseña?</a>
        </div>
    </div>
</div>