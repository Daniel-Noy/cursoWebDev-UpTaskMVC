<?php include_once __DIR__ . "/header-dashboard.php" ?>

    <div class="contenedor-sm">
        <div class="contenedor-nueva-tarea">
            <button class="agregar-tarea" id="agregar-tarea" type="button"> &plus; Nueva tarea</button>
            <button class="agregar-tarea" id="eliminar-proyecto" type="button" data-id="<?php echo $proyectoId?>"> Eliminar proyecto</button>
        </div>

        <div class="filtros" id="filtros">
            <div class="filtros-inputs">
                <h2>Filtros:</h2>
                <div class="campo">
                    <label for="todas">Todas</label>
                    <input 
                    type="radio"
                    id="todas"
                    name="filtro"
                    value=""
                    checked
                    >
                </div>
                <div class="campo">
                    <label for="completadas">Completadas</label>
                    <input 
                    type="radio"
                    id="completadas"
                    name="filtro"
                    value="1"
                    >
                </div>
                <div class="campo">
                    <label for="pendientes">Pendientes</label>
                    <input 
                    type="radio"
                    id="pendientes"
                    name="filtro"
                    value="0"
                    >
                </div>
            </div>
        </div>
    </div>


<?php include_once __DIR__ . "/footer-dasboard.php" ?>

<?php 
    $script .= "<script src='/build/js/tareas.js'></script>";
    $script .= "<script src='/build/js/proyectos.js'></script>";
?>