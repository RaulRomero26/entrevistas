(document.getElementById('Colonia_hechos')).addEventListener('input', colonia_opciones);
(document.getElementById('Colonia_peticionario')).addEventListener('input', colonia_opciones);
(document.getElementById('Colonia')).addEventListener('input', colonia_opciones);
(document.getElementById('Colonia_detencion')).addEventListener('input', colonia_opciones);
var autocomplete_colonia;
var input_elegido;
function colonia_opciones(e){
    switch(e.target.id){
        case "Colonia_hechos":
            puebla_foraneo=true
            break;
        case "Colonia_peticionario":
            puebla_foraneo=(document.getElementById('domicilio_puebla_peticionario')).checked
            break;
        case "Colonia":
            puebla_foraneo=(document.getElementById('domicilio_puebla')).checked
            break;
        case "Colonia_detencion":
            puebla_foraneo=(document.getElementById('domicilio_puebla_detencion')).checked
            break;
    }
    if(puebla_foraneo===true){
        switch(e.target.id){
            case "Colonia_hechos":
                termino=(document.getElementById('Colonia_hechos')).value
                input_elegido=document.getElementById('Colonia_hechos')
                break;
            case "Colonia_peticionario":
                termino=(document.getElementById('Colonia_peticionario')).value
                input_elegido=document.getElementById('Colonia_peticionario')
                break;
            case "Colonia":
                termino=(document.getElementById('Colonia')).value
                input_elegido=document.getElementById('Colonia')
                break;
            case "Colonia_detencion":
                termino=(document.getElementById('Colonia_detencion')).value
                input_elegido=document.getElementById('Colonia_detencion')
                break;
        }
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
            switch(tipo){
                case "Colonia_hechos":
                    hechos_mapbox['codigo_postal'].value=data[0]['Codigo_postal']
                    break;
                case "Colonia_peticionario":
                    peticionario_mapbox['cp'].value=data[0]['Codigo_postal']
                    break;
                case "Colonia":
                    principales_mapbox['cp'].value=data[0]['Codigo_postal']
                    break;
                case "Colonia_detencion":
                    detencion_mapbox['cp'].value=data[0]['Codigo_postal']
                    break;
            }
        }
    })
    .catch(err => console.log(`Ha ocurrido un error al obtener el codigo postal.\nCódigo de error: ${ err }`))
}
document.getElementById('Calle_hechos').addEventListener('input',calle_opciones)
document.getElementById('Calle2_hechos').addEventListener('input',calle_opciones)
document.getElementById('Calle_1_detencion').addEventListener('input',calle_opciones)
document.getElementById('Calle_2_detencion').addEventListener('input',calle_opciones)
document.getElementById('Calle_peticionario').addEventListener('input',calle_opciones)
document.getElementById('Calle').addEventListener('input',calle_opciones)
function calle_opciones(e){
    switch(e.target.id){
        case "Calle_hechos":
            puebla_foraneo_calle=true
            break;
        case "Calle2_hechos":
            puebla_foraneo_calle=true
            break;
        case "Calle_peticionario":
            puebla_foraneo_calle=(document.getElementById('domicilio_puebla_peticionario')).checked
            break;
        case "Calle":
            puebla_foraneo_calle=(document.getElementById('domicilio_puebla')).checked
            break;
        case "Calle_1_detencion":
            puebla_foraneo_calle=(document.getElementById('domicilio_puebla_detencion')).checked
            break;
        case "Calle_2_detencion":
            puebla_foraneo_calle=(document.getElementById('domicilio_puebla_detencion')).checked
            break;
    }
    if(puebla_foraneo_calle===true){
        input_elegido=document.getElementById('Calle_hechos')
        switch(e.target.id){
            case "Calle_hechos":
                termino=(document.getElementById('Calle_hechos')).value
                input_elegido=document.getElementById('Calle_hechos')
                break;
            case "Calle2_hechos":
                termino=(document.getElementById('Calle2_hechos')).value
                input_elegido=document.getElementById('Calle2_hechos')
                break;
            case "Calle_1_detencion":
                termino=(document.getElementById('Calle_1_detencion')).value
                input_elegido=document.getElementById('Calle_1_detencion')
                break;
            case "Calle_2_detencion":
                termino=(document.getElementById('Calle_2_detencion')).value
                input_elegido=document.getElementById('Calle_2_detencion')
                break;
            case "Calle_peticionario":
                termino=(document.getElementById('Calle_peticionario')).value
                input_elegido=document.getElementById('Calle_peticionario')
                break;
            case "Calle":
                termino=(document.getElementById('Calle')).value
                input_elegido=document.getElementById('Calle')
                break;
        }

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