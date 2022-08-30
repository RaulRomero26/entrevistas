
(document.getElementById('nacionalidad_mexicana')).addEventListener('change',cambiar_nacionalidad);
(document.getElementById('nacionalidad_extranjera')).addEventListener('change',cambiar_nacionalidad);
(document.getElementById('nacionalidad_mexicana_pet')).addEventListener('change',cambiar_nacionalidad);
(document.getElementById('nacionalidad_extranjera_pet')).addEventListener('change',cambiar_nacionalidad);
function cambiar_nacionalidad(e){
    if(e.target.id=="nacionalidad_mexicana" || e.target.id=="nacionalidad_extranjera"){
        if((e.target.id).includes("mexicana")){
            document.getElementById('estado_nacimiento').style.display = "block";
            document.getElementById('procedencia_principales_div').style.display = "block";
            document.getElementById('label_procedencia').innerHTML = "Municipio de nacimiento";
        }
        else{
            document.getElementById('estado_nacimiento').style.display = "none";
            document.getElementById('procedencia_principales_div').style.display = "block";
            document.getElementById('label_procedencia').innerHTML = "Procedencia";
            document.getElementById('procedencia_estado_principales').value="SD"
        }
    }
    else{
        if(e.target.id=="nacionalidad_mexicana_pet" || e.target.id=="nacionalidad_extranjera_pet"){
            if((e.target.id).includes("mexicana")){
                document.getElementById('estado_nacimiento_pet').style.display = "block";
                document.getElementById('procedencia_peticionario_div').style.display = "block";
                document.getElementById('label_procedencia_pet').innerHTML = "Municipio de nacimiento";
            }
            else{
                document.getElementById('estado_nacimiento_pet').style.display = "none";
                document.getElementById('procedencia_peticionario_div').style.display = "block";
                document.getElementById('label_procedencia_pet').innerHTML = "Procedencia";
                document.getElementById('procedencia_estado_pet').value="SD"
            }
        }
    }
    
}
document.getElementById('procedencia_principales').addEventListener('input',autocomplete_municipio)
document.getElementById('peticionario_Procedencia').addEventListener('input',autocomplete_municipio)
function autocomplete_municipio(e){
    if(e.target.id=="procedencia_principales"){
        input_elegido=document.getElementById('procedencia_principales')
        termino=(document.getElementById('procedencia_principales')).value
        estado=(document.getElementById('procedencia_estado_principales')).value
    }
    else{
        if(e.target.id=="peticionario_Procedencia"){
            input_elegido=document.getElementById('peticionario_Procedencia')
            termino=(document.getElementById('peticionario_Procedencia')).value
            estado=(document.getElementById('procedencia_estado_pet')).value
        } 
    }
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