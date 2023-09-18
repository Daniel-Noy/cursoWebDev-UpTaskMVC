!function(){const o=document.querySelector("#eliminar-proyecto");o.onclick=()=>{!async function(o){const a=new FormData;a.append("id",o);const t=await fetch("/dashboard/proyecto/eliminar",{method:"POST",body:a});(await t.json()).resultado&&location.replace("/dashboard")}(o.dataset.id)}}();
//# sourceMappingURL=proyectos.js.map
