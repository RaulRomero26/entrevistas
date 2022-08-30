
const inputColonia = document.getElementById('colonia');
const tipo_Colonia = document.getElementById('tipo_colonia');
const myFormData =  new FormData();
inputColonia.addEventListener('input', () => {
    tipo_Colonia.value = (inputColonia.value === '') ? '' : tipo_Colonia.value;  
    myFormData.append('termino', inputColonia.value)
    fetch(base_url_js + 'EventosDelictivos/getColonia', {
            method: 'POST',
            body: myFormData
    })
    .then(res => res.json())
    .then(data => {
        //console.log(data)
        const arr = data.map( r => ({ label: r.Colonia, value: r.Colonia, tipo: r.Tipo_Colonia }))
        autocomplete({
            input: colonia,
            fetch: function(text, update) {
                text = text.toLowerCase();
                const suggestions = arr.filter(n => n.label.toLowerCase().includes(text))
                update(suggestions);
            },
            onSelect: function(item) {
                colonia.value = item.label;
                tipo_Colonia.value = item.tipo;
                
            }
        }); 
    })
    .catch(err => alert(`Ha ocurrido un error al obtener las colonias.\nCódigo de error: ${ err }`))
});



const tipo_evento_ED = document.getElementById('tipo_evento');
const myFormData_1 =  new FormData();
tipo_evento_ED.addEventListener('input', () => {
    myFormData_1.append('termino', tipo_evento_ED.value)
    fetch(base_url_js + 'EventosDelictivos/getEventos', {
            method: 'POST',
            body: myFormData_1
    })
    .then(res => res.json())
    .then(data => {
        console.log(data)
        const arr = data.map( r => ({ label: r.descripcion, value: r.descripcion }))
        autocomplete({
            input: tipo_evento_ED,
            fetch: function(text, update) {
                text = text.toLowerCase();
                const suggestions = arr.filter(n => n.label.toLowerCase().includes(text))
                update(suggestions);
            },
            onSelect: function(item) {
                tipo_evento_ED.value = item.label;
            }
        }); 
    })
    .catch(err => alert(`Ha ocurrido un error al obtener las colonias.\nCódigo de error: ${ err }`))
});
