var data = document.getElementById('datos_nuevovehiculo');
var Tipo_Situacion_error = document.getElementById('Tipo_Situacion_error')
var fechar_Vehiculo_error = document.getElementById('fechar_Vehiculo_error')
var colonia_Vehiculo_error = document.getElementById('colonia_Vehiculo_error')
var marca_Vehiculo_error = document.getElementById('marca_Vehiculo_error')
var submarca_Vehiculo_error = document.getElementById('submarca_Vehiculo_error')
var zona_Vehiculo_error = document.getElementById('zona_Vehiculo_error')
var primerr_Vehiculo_error = document.getElementById('primerr_Vehiculo_error')
var Color_error = document.getElementById('Color_error')
var msg_principalesError = document.getElementById('inputsVehiculos_error')
var ficha_Vehiculo_error = document.getElementById('ficha_Vehiculo_error')
//var myFormData = new FormData(data)

document.getElementById('btn_vehiculos_guardar').addEventListener('click', async function(e) {
    e.preventDefault();
    var i = 0
    var myFormData = new FormData(data)
    const buttonV = document.getElementById('btn_vehiculos_guardar');
    var band = []
    let tipo = document.getElementsByName('tipo');
    let opcion="vehiculo";
    for (var i = 0; i <  tipo.length; i++) {
        if (tipo[i].checked) {
            opcion=tipo[i].value;
            break;
        }
    }
    if(opcion=="vehiculo"){
        //tengo que revisar si es de una ficha que ya existe o si es nueva
        let tipo = document.getElementsByName('ficha');
        let opcion="si";//no es nueva, si existe
        for (var i = 0; i <  tipo.length; i++) {
            if (tipo[i].checked) {
                opcion=tipo[i].value;
                break;
            }
        }
        if(opcion=="si"){
            myFormData.append('opciones_ficha',"vehiculo");
            myFormData.append('ficha_vehiculo',"existe");
            myFormData.append('existe',document.getElementById("id_ficha").value);
        }
        else{
            myFormData.append('opciones_ficha',"vehiculo");
            myFormData.append('ficha_vehiculo',"nueva");
        }
    }
    else{
        let respuesta=await getExisteFicha(document.getElementById('ficha_Vehiculo').value)
        if(respuesta.status){
            ficha_Vehiculo_error.innerText = "";
            myFormData.append('opciones_ficha',"remision");
            myFormData.append('ficha_vehiculo',document.getElementById('ficha_Vehiculo').value);
        }
        else{
            band[i++] = "Ingrese una ficha existente";
            ficha_Vehiculo_error.innerText = "Ingrese una ficha existente";
        }
        
    }
    var FV = new FormValidator()
    
    band[i++] = Tipo_Situacion_error.innerText = FV.validate(myFormData.get('Tipo_Situacion'), 'required')
    band[i++] = fechar_Vehiculo_error.innerText = FV.validate(myFormData.get('fechar_Vehiculo'), 'required | date')
    band[i++] = colonia_Vehiculo_error.innerText = await validateColonia()
    band[i++] = marca_Vehiculo_error.innerText = await validateMarca()
    band[i++] = submarca_Vehiculo_error.innerText = await validateSubmarca()
    myFormData.set("primerm_Vehiculo",document.getElementById('primerm_Vehiculo').value)
    band[i++] = zona_Vehiculo_error.innerText = FV.validate(myFormData.get('zona_Vehiculo'), 'required | max_length[200]');
    band[i++] = primerr_Vehiculo_error.innerText = FV.validate(myFormData.get('primerm_Vehiculo'), 'required | max_length[200]')
    band[i++] = Color_error.innerText = FV.validate(myFormData.get('Color'), 'required | max_length[200]')
    var success = true
    band.forEach(element => {
        success &= (element == '') ? true : false
    })
    if (success) {
        buttonV.innerHTML = `
            Guardando
            <div class="spinner-grow spinner-grow-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        `;
        buttonV.classList.add('disabled-link');
        myFormData.append('datos_nuevovehiculo', document.getElementById('datos_nuevovehiculo').value)
        myFormData.append('placas_table', JSON.stringify(readTablePlacas()));
        myFormData.append('niv_table', JSON.stringify(readTableNivs()));
        let respuesta_insercion=await insertarVehiculo(myFormData)
        if(respuesta_insercion.status){
            Tipo_Situacion_error.innerText = ''
            fechar_Vehiculo_error.innerText = ''
            colonia_Vehiculo_error.innerText = ''
            zona_Vehiculo_error.innerText = ''
            primerr_Vehiculo_error.innerText = ''
            Color_error.innerText = ''
            document.getElementById('datos_nuevovehiculo').reset();
            table = document.getElementById('placas_vehiculos');
            document.getElementById('tipo_ficha_remision').style.display="none";
            document.getElementById('tipo_ficha_vehiculo').style.display="block";
            document.getElementById('ficha').style.display="none";
            document.querySelector('#tipo1').checked = true;
            document.querySelector('#tipo2').checked = false;
            document.querySelector('#ficha1').checked = true;
            document.querySelector('#ficha2').checked = false;

            rowCount = table.rows.length;
            tableHeaderRowCount = 1;
            for (i = tableHeaderRowCount; i < rowCount; i++) {
                table.deleteRow(tableHeaderRowCount);
            }
            table = document.getElementById('niv_vehiculos');
            rowCount = table.rows.length;
            for (i = tableHeaderRowCount; i < rowCount; i++) {
                table.deleteRow(tableHeaderRowCount);
            }
            buttonV.innerHTML = `
                Guardar
            `;
            window.scroll({
                top: 0,
                left: 120,
                behavior: 'smooth'
            });

            msg_principalesError.innerHTML = '<div class="alert alert-success text-center" role="alert">Vehiculo agregado con éxito, vaya a editar para agregar fotografías</div>';
            setInterval(() => {
                window.location = base_url_js + "Vehiculos/index";
            }, 800);
        }
        else{
            Tipo_Situacion_error.innerText = (data.Tipo_Situacion_error === undefined) ? '' : data.Tipo_Situacion_error
            fechar_Vehiculo_error.innerText = (data.fechar_Vehiculo_error === undefined) ? '' : data.fechar_Vehiculo_error
            colonia_Vehiculo_error.innerText = (data.colonia_Vehiculo_error === undefined) ? '' : data.colonia_Vehiculo_error
            zona_Vehiculo_error.innerText = (data.zona_Vehiculo_error === undefined) ? '' : data.zona_Vehiculo_error
            primerr_Vehiculo_error.innerText = (data.primerr_Vehiculo_error === undefined) ? '' : data.primerr_Vehiculo_error
            Color_error.innerText = (data.Color_error === undefined) ? '' : data.Color_error
            let messageError;
            if ('error_message' in data) {
                if (data.error_message != 'Render Index') {
                    if (typeof(data.error_message) != 'string') {
                        messageError = `<div class="alert alert-danger text-center" role="alert">Sucedio un error en el servidor: ${data.error_message.errorInfo[2]}</div>`;
                    } else {
                        messageError = `<div class="alert alert-danger text-center" role="alert">Sucedio un error en el servidor: ${data.error_message}</div>`;
                    }
                } else {
                    messageError = `<div class="alert alert-danger text-center alert-session-create" role="alert">
                            <p>Sucedio un error, su sesión caduco o no tiene los permisos necesarios. Por favor vuelva a iniciar sesión.</p>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalLogin">
                                Iniciar sesión
                            </button>
                        </div>`;
                }
            } else {
                messageError = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>'
            }

            msg_principalesError.innerHTML = messageError
            window.scroll({
                top: 0,
                left: 120,
                behavior: 'smooth'
            });
        }

    }
    else{
        msg_principalesError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>'
        window.scroll({
            top: 0,
            left: 120,
            behavior: 'smooth'
        });
    }
})

const insertarVehiculo =  async (myFormData) => {
    try {
     //   var myFormData = new FormData(data_enviar);
        const response = await fetch(base_url_js + '/Vehiculos/agregarVehiculoSeccion', {
            method: 'POST',
            body: myFormData
        });
        const data = await response.json();
        return data;
    } catch (error) {
        console.log(error);
    }
}

const getExisteFicha =  async (id_ficha) => {
    try {
        var myFormDataF = new FormData();
        myFormDataF.append('buscar',id_ficha)
        const response = await fetch(base_url_js + '/Vehiculos/obtenerFicha', {
            method: 'POST',
            body: myFormDataF
        });
        const data = await response.json();
        return data;
    } catch (error) {
        console.log(error);
    }
}

const readTablePlacas=()=> {
    const table = document.getElementById('placas_vehiculos');
    let placas = [];
    for (let i = 1; i < table.rows.length; i++) {
        placas.push({
            ['row']: {
                tipo: table.rows[i].cells[0].innerHTML,
                placa: table.rows[i].cells[1].innerHTML,
                procedencia: table.rows[i].cells[2].innerHTML,
            }
        });
    }
    return placas;
}

const readTableNivs=()=> {
    const table = document.getElementById('niv_vehiculos');
    let nivs = [];
    for (let i = 1; i < table.rows.length; i++) {
        nivs.push({
            ['row']: {
                tipo: table.rows[i].cells[0].innerHTML,
                niv: table.rows[i].cells[1].innerHTML,
            }
        });
    }
    return nivs;
}

/*----------------Eventos de la tabla de placas-----------------*/
let selectedRowPlacas = null;
const onFormPlacaSubmit  = () => {
    const campos = ['tipo_placa', 'Placa_Vehiculo', 'procedencia_placa'];
    if (validateFormPlaca(campos)) {
        let formData = readFormNiv(campos);
        if (selectedRowPlacas === null)
            insertNewRowPlaca(formData);
        else
            updateRowPlaca(formData);
        resetFormPlaca(campos);
    }
}

const insertNewRowPlaca = ({ tipo_placa, Placa_Vehiculo, procedencia_placa }, type) => {
    const table = document.getElementById('placas_vehiculos').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);
    newRow.insertCell(0).innerHTML = tipo_placa;
    newRow.insertCell(1).innerHTML = Placa_Vehiculo;
    newRow.insertCell(2).innerHTML = procedencia_placa.toUpperCase();
    if (type === undefined) {
        newRow.insertCell(3).innerHTML = `<button type="button" class="btn btn-primary" onclick="EditPlaca(this)"> 
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
        </button>`;
        newRow.insertCell(4).innerHTML = `<input type="button" class="btn btn-primary" value="-" onclick="deleteRow(this,placas_vehiculos)">`;
    }
}

const EditPlaca = (obj) => {
    const campos = ['tipo_placa', 'Placa_Vehiculo', 'procedencia_placa'];
    document.getElementById('alertEditPlaca').style.display = 'block';
    selectedRowPlacas = obj.parentElement.parentElement;
    for (let i = 0; i < campos.length; i++) {
        document.getElementById(campos[i]).value = selectedRowPlacas.cells[i].innerHTML;
    }
}

const updateRowPlaca = (data) => {
    for (dataKey in data) {
        let i = Object.keys(data).indexOf(dataKey);
        selectedRowPlacas.cells[i].innerHTML = data[dataKey].toUpperCase();
    }
    document.getElementById('alertEditPlaca').style.display = 'none';
}

const readFormPlaca = (campos) => {
    let formData = {}
    for (let i = 0; i < campos.length; i++) {
        formData[campos[i]] = document.getElementById(campos[i]).value;
    }
    return formData;
}
const resetFormPlaca = (campos) => {
    for (let i = 0; i < campos.length; i++) {
        document.getElementById(campos[i]).value = '';
    }
    selectedRowPlacas = null;
}
const validateFormPlaca = (campos) => {
    let isValid = true;
    for (i = 0; i < campos.length; i++) {
        if (document.getElementById(campos[i]).value === "") {
            isValid = false;
            document.getElementById(campos[i] + '-invalid').style.display = 'block';
        } else {
            document.getElementById(campos[i] + '-invalid').style.display = 'none';
        }
    }
    return isValid;
}
/*----------------Eventos de la tabla de numeros de serie-----------------*/
let selectedRowNiv = null;
const onFormNivSubmit = () => {
    const campos = ['tipo_niv', 'No_Serie'];
    if (validateFormNiv(campos)) {
        let formData = readFormNiv(campos);
        if (selectedRowNiv === null)
            insertNewRowNiv(formData);
        else
            updateRowNiv(formData);
        resetFormNiv(campos);
    }
}
const insertNewRowNiv = ({ tipo_niv, No_Serie }, type) => {
    const table = document.getElementById('niv_vehiculos').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);
    newRow.insertCell(0).innerHTML = tipo_niv;
    newRow.insertCell(1).innerHTML = No_Serie;
    if (type === undefined) {
        newRow.insertCell(2).innerHTML = `<button type="button" class="btn btn-primary" onclick="editArma(this)"> 
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
        </button>`;
        newRow.insertCell(3).innerHTML = `<input type="button" class="btn btn-primary" value="-" onclick="deleteRow(this,niv_vehiculos)">`;
    }
}
const editArma = (obj) => {
    const campos = ['tipo_niv', 'No_Serie'];
    document.getElementById('alertEditNiv').style.display = 'block';
    selectedRowNiv = obj.parentElement.parentElement;
    for (let i = 0; i < campos.length; i++) {
        document.getElementById(campos[i]).value = selectedRowNiv.cells[i].innerHTML;
    }
}
const updateRowNiv = (data) => {
    for (dataKey in data) {
        let i = Object.keys(data).indexOf(dataKey);
        selectedRowNiv.cells[i].innerHTML = data[dataKey].toUpperCase();
    }
    document.getElementById('alertEditNiv').style.display = 'none';
}
const readFormNiv = (campos) => {
    let formData = {}
    for (let i = 0; i < campos.length; i++) {
        formData[campos[i]] = document.getElementById(campos[i]).value;
    }
    return formData;
}
const resetFormNiv = (campos) => {
    for (let i = 0; i < campos.length; i++) {
        document.getElementById(campos[i]).value = '';
    }
    selectedRowNiv = null;

}
const validateFormNiv = (campos) => {
    let isValid = true;
    for (i = 0; i < campos.length; i++) {
        if (document.getElementById(campos[i]).value === "") {
            isValid = false;
            document.getElementById(campos[i] + '-invalid').style.display = 'block';
        } else {
            document.getElementById(campos[i] + '-invalid').style.display = 'none';
        }
    }
    return isValid;
}
const deleteRow = (obj, tableId) => {

    if (confirm('¿Desea eliminar este elemento?')) {
        const row = obj.parentElement.parentElement;
        document.getElementById(tableId.id).deleteRow(row.rowIndex);
        if (tableId.id === 'elementosParticipantes') {

            let band = true;

            for (let i = 1; i < tableId.rows.length; i++) {
                if (i > 1 && tableId.rows[i].cells[6].childNodes[1].innerHTML != tableId.rows[i - 1].cells[6].childNodes[1].innerHTML) {
                    band = false;
                }
            }

            if (band) {
                for (let i = 1; i < tableId.rows.length; i++) {
                    tableId.rows[i].cells[6].innerHTML = `
                        <p class="mb-0">${tableId.rows[i].cells[6].childNodes[1].innerHTML}</p>
                    `
                }
            }
        }
    }

}
const showHide = ()=>{
    let si = document.getElementById("ficha");
    let ficha = document.getElementsByName('ficha');
    let opcion="no";
    for (var i = 0; i <  ficha.length; i++) {
        if (ficha[i].checked) {
            opcion=ficha[i].value;
            break;
        }
    }
    si.style.display = (opcion=="si") ? "block" : "none";
}
const showHide2 = ()=>{
    let vehiculo = document.getElementById("tipo_ficha_vehiculo");
    let remision = document.getElementById("tipo_ficha_remision");
//    let fichal = document.getElementById("ficha");
    let ficha = document.getElementsByName('tipo');
    let opcion="vehiculo";
    for (var i = 0; i <  ficha.length; i++) {
        if (ficha[i].checked) {
            opcion=ficha[i].value;
            break;
        }
    }
    vehiculo.style.display = (opcion=="remision") ? "none" : "block";
    remision.style.display = (opcion=="remision") ? "block" : "none";
    console.log(remision.style.display)
    if(remision.style.display=="block"){
        document.getElementById('ficha_Vehiculo').addEventListener('input',sacar_primer_respondiente)
        document.getElementById('ficha_Vehiculo').value=""
    }
        
    if(remision.style.display=="none")
        document.getElementById('primerm_Vehiculo').disabled=false;
  //  fichal.style.display = (opcion=="si") ? "none" : "block";
}
/* -------------------------------AUTOCOMPLETE DE LAS COLONIAS----------------------------------------------*/
const inputColonia = document.getElementById('colonia_Vehiculo');
const myFormData =  new FormData();
inputColonia.addEventListener('input', () => {
    myFormData.append('termino', inputColonia.value)
    fetch(base_url_js + 'Catalogos/getColonia', {
            method: 'POST',
            body: myFormData
    })
    .then(res => res.json())
    .then(data => {
        const arr = data.map( r => ({ label: `${r.Tipo} ${r.Colonia}`, value: `${r.Tipo} ${r.Colonia}`, tipo: r.Tipo }))
        autocomplete({
            input: colonia_Vehiculo,
            fetch: function(text, update) {
                text = text.toLowerCase();
                const suggestions = arr.filter(n => n.label.toLowerCase().includes(text))
                update(suggestions);
            },
            onSelect: function(item) {
                colonia_Vehiculo.value = item.label;
            }
        }); 
    })
    .catch(err => alert(`Ha ocurrido un error al obtener las colonias.\nCódigo de error: ${ err }`))
});

const validateColonia = async ()=> {
    var coloniaValida = "Ingrese una colonia valida";
    coloniasCatalogo = await getAllColonias();
    if((document.getElementById('colonia_Vehiculo').value).length>0){
        let inputColoniaValue = createObjectColonia (document.getElementById('colonia_Vehiculo').value);
        const result = coloniasCatalogo.find( colonia => (colonia.Tipo == inputColoniaValue.Tipo && colonia.Colonia == inputColoniaValue.Colonia) ) // SI ESTO ME REGRESA EL MISMO OBJETO QUIERE DECIR QUE SI LO ENCONTRO EN EL CATALOGO UNDEFINED SI NO
        if (result)
            coloniaValida = ""
    }
    else
        coloniaValida="Campo requerido"
    return coloniaValida;
}

const getAllColonias = async () => {
    try {
        const response = await fetch(base_url_js + 'Catalogos/getColonias', {
            method: 'POST'
        });
        const data = await response.json();
        return data;
        
    } catch (error) {
        console.log(error);
    }
} 
const createObjectColonia = (colonia) => {
    separado = colonia.split(' ');
    objetoColonia = {
        Tipo: '',
        Colonia: ''
    }
    if(separado){
        objetoColonia.Tipo = separado[0];
        for(let i = 1; i<separado.length; i++){
            objetoColonia.Colonia += separado[i]+' ';
        }
    }
    objetoColonia.Colonia = objetoColonia.Colonia.trim();
    return objetoColonia
}
document.getElementById('Submarca').addEventListener('input',submarca_opciones)
function submarca_opciones(e){
        termino=(document.getElementById('Submarca')).value
        input_elegido=document.getElementById('Submarca')
        const myFormData_submarca =  new FormData();
        myFormData_submarca.append('termino', termino)
        fetch(base_url_js + 'Catalogos/getSubmarcasTermino', {
                method: 'POST',
                body: myFormData_submarca
        })
        .then(res => res.json())
        .then(data => {
            const arr = data.map( r => ({ label: `${r.Submarca}`, value: `${r.Submarca}` }))
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
document.getElementById('Marca').addEventListener('input',marcas_opciones)
function marcas_opciones(e){
    termino=(document.getElementById('Marca')).value
    input_elegido=document.getElementById('Marca')
    const myFormData_marca =  new FormData();
    myFormData_marca.append('termino', termino)
    fetch(base_url_js + 'Catalogos/getMarcasTermino', {
            method: 'POST',
            body: myFormData_marca
    })
    .then(res => res.json())
    .then(data => {
        const arr = data.map( r => ({ label: `${r.Marca.toUpperCase()}`, value: `${r.Marca}` }))
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
const validateMarca = async ()=> {
    var marcaValida = "Ingrese una marca valida";
    marcasCatalogo = await getAllMarcas();
    let inputMarcaValue = document.getElementById('Marca').value;
    if(inputMarcaValue.length>0){
        const result = marcasCatalogo.find(element => (element.Marca).toUpperCase() == inputMarcaValue.toUpperCase());
        if (result)
            marcaValida = ""
    }
    else
        marcaValida="Campo requerido"
    return marcaValida;
}

const getAllMarcas = async () => {
    try {
        const response = await fetch(base_url_js + 'Catalogos/getAMarcas', {
            method: 'POST'
        });
        const data = await response.json();
        return data;
        
    } catch (error) {
        console.log(error);
    }
} 
const validateSubmarca = async ()=> {
    var submarcaValida = "Ingrese una marca valida";
    submarcasCatalogo = await getAllSubmarcas();
    let inputSubmarcaValue = document.getElementById('Submarca').value;
    if(inputSubmarcaValue.length>0){
        const result = submarcasCatalogo.find(element => (element.Submarca).toUpperCase() == inputSubmarcaValue.toUpperCase());
        if (result)
            submarcaValida = ""
    }
    else
        submarcaValida="Campo requerido"
    
    return submarcaValida;
}

const getAllSubmarcas = async () => {
    try {
        const response = await fetch(base_url_js + 'Catalogos/getSMarcas', {
            method: 'POST'
        });
        const data = await response.json();
        return data;
        
    } catch (error) {
        console.log(error);
    }
} 
  

async function sacar_primer_respondiente(){
    if(document.getElementById('ficha_Vehiculo').value.length>=5){
        try {
            var myFormData = new FormData();
            myFormData.append("ficha_buscar",document.getElementById('ficha_Vehiculo').value);
            const response = await fetch(base_url_js + '/Vehiculos/sacarPrimerR', {
                method: 'POST',
                body: myFormData
            });
            const data = await response.json();
            if(data.sector!="null"){
                document.getElementById('primerm_Vehiculo').disabled=false;
                document.getElementById('primerm_Vehiculo').value=data.sector;
                document.getElementById('primerm_Vehiculo').disabled=true;
            }
            else
                document.getElementById('primerm_Vehiculo').disabled=false;
        } catch (error) {
            console.log(error);
        }
    }
}
