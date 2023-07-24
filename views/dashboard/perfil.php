<?php include_once __DIR__ . "/header-dashboard.php" ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . "/../templates/alertas.php" ?>

    <a href="perfil/password">Cambiar Contraseña</a>

    <form class="formulario" method="POST">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input 
            type="text"
            id="nombre"
            name="nombre"
            value="<?php echo $_SESSION["nombre"] ?? ""?>"
            placeholder="Tu Nombre"
            >
        </div>

        <div class="campo">
            <label for="email">Email</label>
            <input 
            type="email"
            id="email"
            name="email"
            value="<?php echo $_SESSION["email"] ?? ""?>"
            placeholder="Tu Email"
            >
        </div>

        <input type="submit" value="Guardar Cambios">
    </form>
</div>

<?php include_once __DIR__ . "/footer-dasboard.php" ?>