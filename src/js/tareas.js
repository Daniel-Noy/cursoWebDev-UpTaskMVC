(function() {
    const dashboardContainer = document.querySelector('.dashboard');
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', mostrarFormulario);

    function mostrarFormulario() {
        const modal = document.createElement('DIV');
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
        
        const formulario = document.querySelector('.formulario');
        setTimeout(() => {
            formulario.classList.remove('cerrado');
            formulario.classList.add('abierto');
        }, 10);

        modal.addEventListener('click', (e) => {
            const elemento = e.target;
            if( elemento.classList.contains('cerrar-modal') || elemento.classList.contains('modal')) {
                formulario.classList.add('cerrado');
                formulario.classList.remove('abierto');
                    
                setTimeout(()=> {
                    modal.remove();
                }, 450);
                }
        });
        formulario.addEventListener('submit', validarFormulario);
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

    function agregarTarea() {
        
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
})();
