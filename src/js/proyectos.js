(function() {
    const btnEliminarProyecto = document.querySelector('#eliminar-proyecto');
btnEliminarProyecto.onclick = ()=> {
    eliminarProyecto(btnEliminarProyecto.dataset.id);

}

async function eliminarProyecto(id) {
    const url = '/dashboard/proyecto/eliminar';
    const data = new FormData();
    data.append('id', id);
    const res = await fetch(url, {
        method: 'POST',
        body: data
    });
    const respuesta = await res.json();
    if( respuesta.resultado) {
        location.replace('/dashboard');
    }
}
})();