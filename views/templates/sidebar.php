<aside class="sidebar">
    <h2 class="uptask-logo">UpTask</h2>

    <nav class="sidebar__nav">
        <a class="<?php echo ( $titulo === "Proyectos") ? "activo" : ""; ?>" href="/dashboard">Proyectos</a>
        <a class="<?php echo ( $titulo === "Crear Proyecto") ? "activo" : ""; ?>" href="/dashboard/proyecto/crear">Crear Proyecto</a>
        <a class="<?php echo ( $titulo === "Perfil") ? "activo" : ""; ?>" href="/perfil">Perfil</a>
        <a class="cerrar-sesion" href="/cuenta/logout">Cerrar Sesión</a>
    </nav>
</aside>