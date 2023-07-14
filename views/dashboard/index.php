<?php include_once __DIR__ . "/header-dashboard.php" ?>

<?php if (count($proyectos) === 0) {?>
    <p class="no-proyectos">Aun no tienes proyectos. <a href="/dashboard/proyecto/crear">Crear uno aqui.</a></p>
<?php } else {?>
    <ul class="listado-proyectos">
        <?php foreach($proyectos as $proyecto) { ?>
            <li class="proyecto">
                <a href="<?php echo "/dashboard/proyecto?id={$proyecto->url}"?>">
                    <?php echo $proyecto->proyecto ?>
                </a>
            </li>
        <?php } ?>

        <li class="proyecto crear">
            <a href="/dashboard/proyecto/crear">&plus; Crear Proyecto</a>
        </li>
    </ul>
<?php } ?>

<?php include_once __DIR__ . "/footer-dasboard.php" ?>