(document.getElementById('Colonia')).addEventListener('input', colonia_opciones);
var autocomplete_colonia;
var input_elegido;
function colonia_opciones(e){
    puebla_foraneo=(document.getElementById('domicilio_puebla')).checked
    if(puebla_foraneo===true){
        termino=(document.getElementById('Colonia')).value
        input_elegido=document.getElementById('Colonia')
        const myFormDataMP =  new FormData();
        myFormDataMP.append('termino', termino)
        fetch(base_url_js + 'Catalogos/getColonia', {
                method: 'POST',
                body: myFormDataMP
        })
        .then(res => res.json())
        .then(data => {
            const arr = data.map( r => ({ label: `${r.Tipo} ${r.Colonia}`, value: `${r.Colonia}`, tipo: r.Tipo }))
            autocomplete_colonia=autocomplete({
                input: input_elegido,
                fetch: function(text, update) {
                    text = text.toLowerCase();
                    const suggestions = arr.filter(n => n.label.toLowerCase().includes(text))
                    update(suggestions);
                },
                onSelect: function(item) {
                    switch(e.target.id){
                        case "Colonia_hechos":
                            hechos_mapbox['Colonia'].value=item.label
                            break;
                        case "Colonia_peticionario":
                            peticionario_mapbox['colonia'].value=item.label
                            break;
                        case "Colonia":
                            principales_mapbox['colonia'].value=item.label
                            break;
                        case "Colonia_detencion":
                            detencion_mapbox['colonia'].value=item.label
                            break;
                    }
                    buscarCodigoPostal(item.value,e.target.id)
                }
            }); 
        })
        .catch(err => console.log(`Ha ocurrido un error al obtener las colonias.\nCódigo de error: ${ err }`))
                
    }
    else{
        for (const element of document.getElementsByClassName("autocomplete ")){
            element.style.display="none";
            element.innerHTML=""
        }   
    }  
}
function buscarCodigoPostal(colonia,tipo){
    const myFormData_cp =  new FormData();
    myFormData_cp.append('cp', colonia)
    fetch(base_url_js + 'Catalogos/getCP', {
        method: 'POST',
        body: myFormData_cp
    })
    .then(res => res.json())
    .then(data => {
        if(data.length>0){
            principales_mapbox['cp'].value=data[0]['Codigo_postal']
        }
    })
    .catch(err => console.log(`Ha ocurrido un error al obtener el codigo postal.\nCódigo de error: ${ err }`))
}
document.getElementById('Calle').addEventListener('input',calle_opciones)
function calle_opciones(e){
    puebla_foraneo_calle=(document.getElementById('domicilio_puebla')).checked
    if(puebla_foraneo_calle===true){
        termino=(document.getElementById('Calle')).value
        input_elegido=document.getElementById('Calle')
        const myFormData_calle =  new FormData();
        myFormData_calle.append('termino', termino)
        fetch(base_url_js + 'Catalogos/getCalles', {
                method: 'POST',
                body: myFormData_calle
        })
        .then(res => res.json())
        .then(data => {
            const arr = data.map( r => ({ label: `${r.Calle}`, value: `${r.Calle}` }))
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
    else{
        for (const element of document.getElementsByClassName("autocomplete")){
            element.style.display="none";
            element.innerHTML=""
        } 
    }
}