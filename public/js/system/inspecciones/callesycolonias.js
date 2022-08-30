const inputColonia = document.getElementById('id_colonia');
const myFormData =  new FormData();
var colonia_actual;
inputColonia.addEventListener('input', () => {
    myFormData.append('termino', inputColonia.value)
    fetch(base_url_js + 'Catalogos/getColonia', {
            method: 'POST',
            body: myFormData
    })
    .then(res => res.json())
    .then(data => {
        const arr = data.map( r => ({ label: `${r.Tipo} ${r.Colonia}`, value: `${r.Colonia}`, tipo: r.Tipo }))
        autocomplete({
            input: id_colonia,
            fetch: function(text, update) {
                text = text.toLowerCase();
                const suggestions = arr.filter(n => n.label.toLowerCase().includes(text))
                update(suggestions);
            },
            onSelect: function(item) {
                id_colonia.value = item.label;
                colonia_actual=item.value;
                buscarCodigoPostal()
            }
        }); 
    })
    .catch(err => console.log(`Ha ocurrido un error al obtener las colonias.\nCódigo de error: ${ err }`))
});
function buscarCodigoPostal(){
    console.log(colonia_actual)
    const myFormData_cp =  new FormData();
    myFormData_cp.append('cp', colonia_actual)
    fetch(base_url_js + 'Catalogos/getCP', {
        method: 'POST',
        body: myFormData_cp
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);
        if(data.length>0){
            inspeccion['codigo_postal'].value=data[0]['Codigo_postal']
            console.log(data[0]['Codigo_postal'])
        }
    })
    .catch(err => console.log(`Ha ocurrido un error al obtener el codigo postal.\nCódigo de error: ${ err }`))
}

const inputCalle = document.getElementById('id_calle_1');
const myFormData_calle =  new FormData();
inputCalle.addEventListener('input', () => {
    myFormData_calle.append('termino', inputCalle.value)
    fetch(base_url_js + 'Catalogos/getCalles', {
            method: 'POST',
            body: myFormData_calle
    })
    .then(res => res.json())
    .then(data => {
        const arr = data.map( r => ({ label: `${r.Calle}`, value: `${r.Calle}` }))
        autocomplete({
            input: id_calle_1,
            fetch: function(text, update) {
                text = text.toLowerCase();
                const suggestions = arr.filter(n => n.label.toLowerCase().includes(text))
                update(suggestions);
            },
            onSelect: function(item) {
                id_calle_1.value = item.label;
            }
        }); 
    })
    .catch(err => alert(`Ha ocurrido un error al obtener las colonias.\nCódigo de error: ${ err }`))
});

const inputCalle2 = document.getElementById('id_calle_2');
const myFormData_calle2 =  new FormData();
inputCalle2.addEventListener('input', () => {
    myFormData_calle2.append('termino', inputCalle2.value)
    fetch(base_url_js + 'Catalogos/getCalles', {
            method: 'POST',
            body: myFormData_calle2
    })
    .then(res => res.json())
    .then(data => {
        const arr = data.map( r => ({ label: `${r.Calle}`, value: `${r.Calle}` }))
        autocomplete({
            input: id_calle_2,
            fetch: function(text, update) {
                text = text.toLowerCase();
                const suggestions = arr.filter(n => n.label.toLowerCase().includes(text))
                update(suggestions);
            },
            onSelect: function(item) {
                id_calle_2.value = item.label;
            }
        }); 
    })
    .catch(err => alert(`Ha ocurrido un error al obtener las colonias.\nCódigo de error: ${ err }`))
});