(document.getElementById('nacionalidad_mexicana_nueva')).addEventListener('change',cambiar_nacionalidad_nueva);
(document.getElementById('nacionalidad_extranjera_nueva')).addEventListener('change',cambiar_nacionalidad_nueva);
function cambiar_nacionalidad_nueva(e){
    if((e.target.id).includes("mexicana")){
        document.getElementById('estado_nacimiento_nueva').style.display = "block";
        document.getElementById('procedencia_principales_div').style.display = "block";
        document.getElementById('label_procedencia').innerHTML = "Municipio de nacimiento";
    }
    else{
        document.getElementById('estado_nacimiento_nueva').style.display = "none";
        document.getElementById('procedencia_principales_div').style.display = "block";
        document.getElementById('label_procedencia').innerHTML = "Procedencia";
        document.getElementById('procedencia_estado_principales_nueva').value="SD";
    }  
}
document.getElementById('procedencia_principales').addEventListener('input',autocomplete_municipio_nueva)
function autocomplete_municipio_nueva(e){
    input_elegido=document.getElementById('procedencia_principales')
    termino=(document.getElementById('procedencia_principales')).value
    estado=(document.getElementById('procedencia_estado_principales_nueva')).value
    const myFormData_muni =  new FormData();
    myFormData_muni.append('termino', termino)
    myFormData_muni.append('estado', estado)
    fetch(base_url_js + 'Remisiones/getMunicipios', {
            method: 'POST',
            body: myFormData_muni
    })
    .then(res => res.json())
    .then(data => {
        const arr = data.map( r => ({ label: `${r.Municipio}`, value: `${r.Municipio}` }))
        autocomplete({
            input: input_elegido,
            fetch: function(text, update) {
                text = text.toLowerCase();
                const suggestions = arr.filter(n => n.label.toLowerCase().includes(text))
                update(suggestions);
            },
            onSelect: function(item) {
                input_elegido.value = item.label;
            }
        }); 
    })
    .catch(err => alert(`Ha ocurrido un error al obtener las colonias.\nCódigo de error: ${ err }`))  
}