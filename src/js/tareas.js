(function() {
    let tareas = [];
    let modal;
    let formulario;
    const dashboardContainer = document.querySelector('.dashboard');
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', mostrarFormulario);

    obtenerTareas();

    function mostrarFormulario() {
        modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
            <form action="" class="formulario cerrado nueva-tarea">
                <legend>Añade una nueva tarea</legend>
                <div class="campo">
                    <label for="nombre">Tarea</label>
                    <input 
                    type="text"
                    name="tarea"
                    placeholder="Añadir Tarea"
                    id="tarea"
                    >
                </div>
                <div class="opciones">
                    <input type="submit" class="submit-nueva-tarea" value="Añadir Tarea">
                    <button type="button" class="cerrar-modal">Cancelar</button>
                </div>
            </form>
        `;
        dashboardContainer.appendChild(modal);
        
        formulario = document.querySelector('.formulario');
        setTimeout(() => {
            formulario.classList.remove('cerrado');
            formulario.classList.add('abierto');
        }, 10);

        modal.addEventListener('click', cerrarModal);
        formulario.addEventListener('submit', validarFormulario);
    }

    function cerrarModal(e) {
        const elemento = e.target;
        if( elemento.classList.contains('cerrar-modal') || elemento.classList.contains('modal')) {
            formulario.classList.add('cerrado');
            formulario.classList.remove('abierto');
                
            setTimeout(()=> {
                modal.remove();
            }, 450);
            }
    }

    function validarFormulario(e) {
    e.preventDefault();
    const tarea = document.querySelector('#tarea').value.trim();
    if( tarea.length < 5 ) {
        mostrarAlerta('error', 'El nombre de la tarea debe ser mayor a 5 caracteres', document.querySelector('.formulario legend'));
        return;
    }
    agregarTarea(tarea);
    }

    async function agregarTarea(tarea) {
        const url = `${location.origin}/api/tareas/crear`;
        const datosUrl = obtenerDatosUrl();
        const datos = new FormData();
        datos.append('nombre', tarea);
        datos.append('proyectoId', datosUrl.id);

        const btnSubmit = formulario.querySelector('.submit-nueva-tarea');
        btnSubmit.disabled = true;

        try {
            const res = await fetch(url, {
                method: 'POST',
                body:datos
            });

            const respuesta = await res.json();
            mostrarAlerta( respuesta.tipo, respuesta.mensaje, document.querySelector('.formulario legend') );

            if( respuesta.tipo = 'correcto' ) {
                formulario.reset();
                btnSubmit.disabled = false;

                const tareaObj = {
                    id: respuesta.id,
                    nombre: tarea,
                    estado: "0",
                    proyectoId: respuesta.proyectoId
                }

                tareas = [...tareas, tareaObj];
                mostrarTareas();
            } else {
                btnSubmit.disabled = false;
            }

        } catch (err) {
            mostrarAlerta('error', 'Hubo un error en el servidor',document.querySelector('.formulario legend'))
            btnSubmit.disabled = false;
        }
    }

    function cambiarEstadoActual(tarea) {
        const nuevoEstado =  tarea.estado === "1" ? "0" : "1";
        tarea.estado = nuevoEstado;
        $res = actualizarTarea(tarea);
        
    }

    async function actualizarTarea(tarea) {
        const {estado, id, nombre} = tarea;
        const datos = new FormData();
        datos.append('id', id);
        datos.append('nombre', nombre);
        datos.append('estado', estado);
        datos.append('proyectoId', obtenerDatosUrl().id);

        try {
            const url = `${location.origin}/api/tareas/actualizar`;

            const res = await fetch(url, {
                method: 'POST',
                body: datos
            });

            const resultado = await res.json();

            if( resultado.tipo === "correcto") {
                tareas = tareas.map( tarea => {
                    if ( tarea.id === id ) {
                        tarea.estado = estado
                    }
                    return tarea;
                })

                mostrarTareas();
            }

        } catch (err) {
            console.log(err);
        }
    }

    async function obtenerTareas() {
        const datosUrl = obtenerDatosUrl();
        const url = `${location.origin}/api/tareas?id=${datosUrl.id}`;

        try {
            const res = await fetch(url);
            const resultado = await res.json();
            tareas = resultado.tareas;

            mostrarTareas();
        } catch (err) {
            console.log(err);
        }
    }

    function mostrarTareas() {
        const listaAnterior = document.querySelector('#listado-tareas');
        if( listaAnterior ) listaAnterior.remove();

        const estados = {
            0: 'Pendiente',
            1: 'Completado'
        };
        const contenedorPagina = document.querySelector('.contenedor-sm');
        const listaTareas = document.createElement('UL');
        listaTareas.classList.add('listado-tareas');
        listaTareas.id = 'listado-tareas';

        
        if( tareas.length === 0 ) {
            const textoNoTareas = document.createElement('LI');
            textoNoTareas.className = 'no-tareas';
            textoNoTareas.textContent = 'No Hay tareas';

            listaTareas.appendChild(textoNoTareas);
            contenedorPagina.appendChild(listaTareas);
            return;
        }

        tareas.forEach( tarea => {
            const {id, nombre, estado} = tarea;
            const contenedorTarea = document.createElement('LI');
            contenedorTarea.classList.add('tarea');
            contenedorTarea.dataset.tareaId = id;

            const nombreTarea = document.createElement('P');
            nombreTarea.textContent = nombre;

            const opcionesDiv = document.createElement('DIV');
            opcionesDiv.classList.add('opciones');

            const btnEstadoTarea = document.createElement('BUTTON');
            btnEstadoTarea.classList.add('estado-tarea');
            btnEstadoTarea.classList.add(estados[estado].toLowerCase());
            btnEstadoTarea.dataset.estadoTarea = estado;
            btnEstadoTarea.textContent = estados[estado];
            btnEstadoTarea.ondblclick = ()=> {
                cambiarEstadoActual({...tarea})
            }

            const btnEliminarTarea = document.createElement('BUTTON');
            btnEliminarTarea.classList.add('eliminar-tarea');
            btnEliminarTarea.dataset.idTarea = id;
            btnEliminarTarea.textContent = 'Eliminar Tarea';

            opcionesDiv.append( btnEstadoTarea, btnEliminarTarea );
            contenedorTarea.append( nombreTarea, opcionesDiv );

            listaTareas.appendChild(contenedorTarea);
        })

        contenedorPagina.appendChild(listaTareas);
    }

    function mostrarAlerta(tipo, mensaje, referencia) {
        const alertaAnterior = document.querySelector('.alerta');
        if( alertaAnterior ) alertaAnterior.remove();

        const alerta = document.createElement('DIV');
        alerta.classList.add('alerta', tipo);
        alerta.textContent = mensaje;

        referencia.parentElement.insertBefore(alerta, referencia.nextElementSibling);

        setTimeout(()=> {
            alerta.remove()
        }, 3000);
    }

    function obtenerDatosUrl() {
        const urlParams = new URLSearchParams(location.search);
        const objectParams = Object.fromEntries(urlParams.entries());
        return objectParams;
    }
})();
