!function(){let e,t,a=[],o=[];const n=document.querySelectorAll(".filtros-inputs input"),r=document.querySelector(".dashboard");function c(a=!1,o){e=document.createElement("DIV"),e.classList.add("modal"),e.innerHTML=`\n            <form class="formulario cerrado nueva-tarea">\n                <legend>${a?"Cambiar nombre":"Añade una nueva tarea"}</legend>\n                <div class="campo">\n                    <label for="nombre">Tarea</label>\n                    <input \n                    type="text"\n                    name="tarea"\n                    placeholder="${a?"Nuevo Nombre":"Añadir Tarea"}"\n                    id="tarea"\n                    value="${a?o.nombre:""}"\n                    >\n                </div>\n                <div class="opciones">\n                    <input type="submit" class="submit-nueva-tarea" value="${a?"Cambiar Nombre":"Añadir Tarea"}">\n                    <button type="button" class="cerrar-modal">Cancelar</button>\n                </div>\n            </form>\n        `,r.appendChild(e),t=document.querySelector(".formulario"),setTimeout(()=>{t.classList.remove("cerrado"),t.classList.add("abierto")},10),e.addEventListener("click",e=>{d(e.target)}),a?t.addEventListener("submit",t=>{t.preventDefault();const a={...o};a.nombre=document.querySelector("#tarea").value.trim();(async function(e){const t=document.querySelector(".submit-nueva-tarea");t.disabled=!0;return await s(e)?(t.disabled=!1,u("correcto","Nombre Cambiado",document.querySelector(".formulario legend")),!0):(t.disabled=!1,!1)})(a)&&setTimeout(()=>{d(e)},800)}):t.addEventListener("submit",i)}function d(a){(a.classList.contains("cerrar-modal")||a.classList.contains("modal"))&&(t.classList.add("cerrado"),t.classList.remove("abierto"),setTimeout(()=>{e.remove()},450))}function i(e){e.preventDefault();const o=document.querySelector("#tarea").value.trim();o.length<5?u("error","El nombre de la tarea debe ser mayor a 5 caracteres",document.querySelector(".formulario legend")):async function(e){const o=location.origin+"/api/tareas/crear",n=p(),r=new FormData;r.append("nombre",e),r.append("proyectoId",n.id);const c=t.querySelector(".submit-nueva-tarea");c.disabled=!0;try{const n=await fetch(o,{method:"POST",body:r}),d=await n.json();if(u(d.tipo,d.mensaje,document.querySelector(".formulario legend")),d.tipo="correcto"){t.reset(),c.disabled=!1;const o={id:d.id,nombre:e,estado:"0",proyectoId:d.proyectoId};a=[...a,o],m(a)}else c.disabled=!1}catch(e){u("error","Hubo un error en el servidor",document.querySelector(".formulario legend")),c.disabled=!1}}(o)}async function s(e){const{estado:t,id:o,nombre:n}=e,r=new FormData;r.append("id",o),r.append("nombre",n),r.append("estado",t),r.append("proyectoId",p().id);try{const e=location.origin+"/api/tareas/actualizar",c=await fetch(e,{method:"POST",body:r});if("correcto"===(await c.json()).tipo)return a=a.map(e=>(e.id===o&&(e.nombre=n,e.estado=t),e)),m(a),!0}catch(e){return console.log(e),!1}}async function l(e){const{id:t,proyectoId:o}=e,n=location.origin+"/api/tareas/eliminar",r=new FormData;r.append("id",t),r.append("proyectoId",o);try{const e=await fetch(n,{method:"POST",body:r});"correcto"===(await e.json()).tipo&&(a=a.filter(e=>e.id!==t),m(a))}catch(e){console.log(e)}}function m(e){const t=document.querySelector("#listado-tareas");t&&t.remove();const a={0:"Pendiente",1:"Completado"},o=document.querySelector(".contenedor-sm"),n=document.createElement("UL");if(n.classList.add("listado-tareas"),n.id="listado-tareas",0===e.length){const e=document.createElement("LI");return e.className="no-tareas",e.textContent="No Hay tareas",n.appendChild(e),void o.appendChild(n)}e.forEach(e=>{const{id:t,nombre:o,estado:r}=e,d=document.createElement("LI");d.classList.add("tarea"),d.dataset.tareaId=t;const i=document.createElement("P");i.textContent=o,i.setAttribute("title","Cambiar nombre"),i.addEventListener("click",()=>{c(!0,{...e})});const m=document.createElement("DIV");m.classList.add("opciones");const u=document.createElement("BUTTON");u.classList.add("estado-tarea"),u.classList.add(a[r].toLowerCase()),u.dataset.estadoTarea=r,u.setAttribute("title","Actualizar estado de la tarea"),u.textContent=a[r],u.onclick=()=>{!function(e){const t="1"===e.estado?"0":"1";e.estado=t,$res=s(e)}({...e})};const p=document.createElement("BUTTON");p.classList.add("eliminar-tarea"),p.dataset.idTarea=t,p.textContent="Eliminar Tarea",p.onclick=()=>{l({...e})},m.append(u,p),d.append(i,m),n.appendChild(d)}),o.appendChild(n)}function u(e,t,a){const o=document.querySelector(".alerta");o&&o.remove();const n=document.createElement("DIV");n.classList.add("alerta",e),n.textContent=t,a.parentElement.insertBefore(n,a.nextElementSibling),setTimeout(()=>{n.remove()},3e3)}function p(){const e=new URLSearchParams(location.search);return Object.fromEntries(e.entries())}document.querySelector("#agregar-tarea").addEventListener("click",()=>{c()}),async function(){const e=p(),t=`${location.origin}/api/tareas?id=${e.id}`;try{const e=await fetch(t),o=await e.json();a=o.tareas,m(a)}catch(e){console.log(e)}}(),n.forEach(e=>{e.addEventListener("input",()=>{!function(e){if(""===e)return void m(a);o=a.filter(t=>t.estado===e),m(o)}(e.value)})})}();
//# sourceMappingURL=tareas.js.map
