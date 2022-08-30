var data = document.getElementById('datos_editarvehiculo');
var fechar_Vehiculo_error = document.getElementById('fechar_VehiculoE_error')
var colonia_Vehiculo_error = document.getElementById('colonia_VehiculoE_error')
var marca_Vehiculo_error = document.getElementById('Marca_VehiculoE_error')
var submarca_Vehiculo_error = document.getElementById('Submarca_VehiculoE_error')
var zona_Vehiculo_error = document.getElementById('zona_VehiculoE_error')
var primerr_Vehiculo_error = document.getElementById('primerr_VehiculoE_error')
var Color_error = document.getElementById('ColorE_error')
var tipo_error = document.getElementById('Tipo_VehiculoE_error')
var marca_error = document.getElementById('Marca_VehiculoE_error')
var submarca_error = document.getElementById('Submarca_VehiculoE_error')
var msg_principalesError = document.getElementById('inputsVehiculosE_error')
var ficha_remision_anterior=0
var ficha_vehiculo_anterior=0
var tipo_original=""
const pathFile = base_url_js + `public/files/Vehiculos/${document.getElementById('no_vehiculo_').value}/PDF/`;
document.getElementById('btn_vehiculos_editar').addEventListener('click', async function(e) {
    e.preventDefault();
    const buttonV = document.getElementById('btn_vehiculos_editar');
    var myFormData = new FormData(data)
    myFormData.append('placas_table', JSON.stringify(readTablePlacas()));
    myFormData.append('niv_table', JSON.stringify(readTableNivs()));
    var band = []
    var FV = new FormValidator()
    var i = 0
    band[i++] = fechar_Vehiculo_error.innerText = FV.validate(myFormData.get('fechar_VehiculoE'), 'required | date')
    band[i++] = colonia_Vehiculo_error.innerText = await validateColonia();
    band[i++] = marca_Vehiculo_error.innerText = await validateMarca();
    band[i++] = submarca_Vehiculo_error.innerText = await validateSubmarca();
    band[i++] = zona_Vehiculo_error.innerText = FV.validate(myFormData.get('zona_VehiculoE'), 'required | max_length[200]');
    myFormData.set("primerm_VehiculoE",document.getElementById('primerm_VehiculoE').value)
    band[i++] = primerr_Vehiculo_error.innerText = FV.validate(myFormData.get('primerm_VehiculoE'), 'required | max_length[200]')
    band[i++] = Color_error.innerText = FV.validate(myFormData.get('ColorE'), 'required | max_length[200]')
    band[i++] = tipo_error.innerText = FV.validate(myFormData.get('Tipo_VehiculoE'), 'required')
    const file = document.getElementById('fileVehiculos');
    if (file.files[0] != undefined) {
        myFormData.append('file_vehiculos', file.files[0]);
    }
    if(document.getElementById("cambiar_ficha").checked){
        if(tipo_original=="vehiculo"){
            //---vehiculo a vehiculos
            if(document.getElementById("tipo1").checked){
                //----vehiculo a vehiculo nuevo
                if(document.getElementById("ficha1").checked){
                    myFormData.append('cambio',"vehiculo_vehiculo_nuevo");
                }
                else{
                    //--vehiculo a vehiculo existe
                    myFormData.append('cambio',"vehiculo_vehiculo_existe");
                    myFormData.append('ficha_vehiculo_nueva',document.getElementById('id_ficha').value);
                }
            }
            //----vehiculo a remision
            else{
                let respuesta=await getExisteFicha(document.getElementById('ficha_Vehiculo').value)
                    if(respuesta.status){
                        ficha_Vehiculo_error.innerText = "";
                        myFormData.append('cambio',"vehiculo_remision");
                        myFormData.append('ficha_vehiculo_nueva',document.getElementById('ficha_Vehiculo').value);
                    }
                    else{
                        band[i++] = "Ingrese una ficha existente";
                        ficha_Vehiculo_error.innerText = "Ingrese una ficha existente";
                    }
            }
        }
        else{
            //----remision a vehiculo
            if(document.getElementById("tipo1").checked){
                //-----remision a vehiculo nuevo
                if(document.getElementById("ficha1").checked){
                    myFormData.append('cambio',"remision_vehiculo_nuevo");
                }
                //-----remision a vehiculo existe
                else{
                    myFormData.append('cambio',"remision_vehiculo_existe");
                    myFormData.append('ficha_vehiculo_nueva',document.getElementById('id_ficha').value);
                }
            }
            else{
                //--remision a remision
                if(document.getElementById("ficha_Vehiculo").value!=ficha_remision_anterior){
                    //se cambio hay que verificar que esa ficha existe
                    let respuesta=await getExisteFicha(document.getElementById('ficha_Vehiculo').value)
                    if(respuesta.status){
                        ficha_Vehiculo_error.innerText = "";
                        myFormData.append('cambio',"remision_remision");
                        myFormData.append('ficha_vehiculo_nueva',document.getElementById('ficha_Vehiculo').value);
                    }
                    else{
                        band[i++] = "Ingrese una ficha existente";
                        ficha_Vehiculo_error.innerText = "Ingrese una ficha existente";
                    }
                }
                else{
                    myFormData.append('cambio',"no");
                }
            }   
        }   
    }
    else
        myFormData.append('cambio',"no");
    if(document.getElementById('cancelar_vehiculo').checked)
        myFormData.append('inactiva',0);
    else
        myFormData.append('inactiva',1);

    myFormData.append('modo_admin',document.getElementById('es_admin').value);
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
        myFormData.append('datos_editarvehiculo', document.getElementById('datos_editarvehiculo').value)
        fetch(base_url_js + '/Vehiculos/updateVehiculo', {
            method: 'POST',
            body: myFormData
        })

        .then(res => res.json())

        .then(data => {
            buttonV.innerHTML = `
                Guardar
            `;
            buttonV.classList.remove('disabled-link');
            if (!data.status) {
                fechar_Vehiculo_error.innerText = (data.fechar_VehiculoE_error === undefined) ? '' : data.fechar_VehiculoE_error
                colonia_Vehiculo_error.innerText = (data.colonia_VehiculoE_error === undefined) ? '' : data.colonia_VehiculoE_error
                zona_Vehiculo_error.innerText = (data.zona_VehiculoE_error === undefined) ? '' : data.zona_VehiculoE_error
                primerr_Vehiculo_error.innerText = (data.primerr_VehiculoE_error === undefined) ? '' : data.primerr_VehiculoE_error
                Color_error.innerText = (data.ColorE_error === undefined) ? '' : data.ColorE_error
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
                setInterval(() => {
                    window.location = base_url_js + "Vehiculos/index";
                }, 800);
            
            } else {
                fechar_Vehiculo_error.innerText = ''
                colonia_Vehiculo_error.innerText = ''
                zona_Vehiculo_error.innerText = ''
                primerr_Vehiculo_error.innerText = ''
                Color_error.innerText = ''
                window.scroll({
                    top: 0,
                    left: 120,
                    behavior: 'smooth'
                });

                msg_principalesError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información actualizada con éxito</div>';
                setInterval(() => {
                    window.location = base_url_js + "Vehiculos/index";
                }, 800);
            }
        })

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


window.onload = function() {
    var no_vehiculo_editar = document.getElementById('no_vehiculo_')

    var myFormData = new FormData()
    myFormData.append('no_vehiculo_editar', no_vehiculo_editar.value)

    fetch(base_url_js + '/Vehiculos/getVehiculoEditar', {
        method: 'POST',
        body: myFormData
    })
    .then(res => res.json())

    .then(data => {
    
        document.getElementById('fechar_VehiculoE').value=data.vehiculo.FECHA_RECUPERACION;
        document.getElementById('fechad_VehiculoE').value=data.vehiculo.FECHA_PUESTA_DISPOSICION;
        if(data.vehiculo.ID_VEHICULO<5430)
            document.getElementById('remision_VehiculoE').disabled = false;
       if(data.vehiculo.NO_FICHA_R!=0){
           //----------ES FICHA DE REMISION
            document.querySelector('#tipo1').checked = false;
            document.querySelector('#tipo2').checked = true;
            document.getElementById('ficha_Vehiculo').value=data.vehiculo.NO_FICHA_R
            document.getElementById('ficha_Vehiculo').disabled = true;
            document.getElementById('primerm_VehiculoE').disabled = true;
            document.getElementById('tipo_ficha_remision').style.display="block"
            document.getElementById('tipo_ficha_vehiculo').style.display="none"
            ficha_remision_anterior=data.vehiculo.NO_FICHA_R
            tipo_original="remision";
       }
       else{
           //---------ES FICHA DE VEHICULO
            document.querySelector('#tipo1').checked = true;
            document.querySelector('#tipo2').checked = false;
            document.getElementById('ficha_Vehiculo_v').value=data.vehiculo.NO_FICHA_V
            document.getElementById('ficha_Vehiculo_v').disabled = true;
            document.getElementById('tipo_ficha_remision').style.display="none"
            document.getElementById('tipo_ficha_vehiculo').style.display="block"
            ficha_vehiculo_anterior=data.vehiculo.NO_FICHA_V
            tipo_original="vehiculo";
       }
      
        document.getElementById('tipo1').disabled=true;
        document.getElementById('tipo2').disabled=true;
        document.getElementById('Tipo_SituacionE').value = data.vehiculo.ESTADO
        document.getElementById('colonia_VehiculoE').value=data.vehiculo.COLONIA;
        document.getElementById('zona_VehiculoE').value = data.vehiculo.ZONA_EVENTO
        document.getElementById('primerm_VehiculoE').value = data.vehiculo.PRIMER_RESPONDIENTE
        document.getElementById('MarcaE').value = data.vehiculo.MARCA
        document.getElementById('SubmarcaE').value = data.vehiculo.SUBMARCA
        document.getElementById('ModeloE').value = data.vehiculo.MODELO
        document.getElementById('ColorE').value = data.vehiculo.COLOR
        document.getElementById('CDI_VehiculoE').value = data.vehiculo.CDI
        document.getElementById('remision_VehiculoE').value = data.vehiculo.NO_REMISION
        document.getElementById('Tipo_VehiculoE').value = data.vehiculo.TIPO
        document.getElementById('Observacion_VehiculoE').value = data.vehiculo.OBSERVACIONES
        document.getElementById('Narrativas_VehiculoE').value = data.vehiculo.NARRATIVAS
        if(data.vehiculo.ACTIVA==0)
            document.getElementById('cancelar_vehiculo').checked=true;
               
        if(data.vehiculo.NOMBRE_MP!="" & data.vehiculo.NOMBRE_MP!=" " ){
            NOMBRE_MP=data.vehiculo.NOMBRE_MP.split(" ");
            document.getElementById('apellidom_mpE').value = NOMBRE_MP[NOMBRE_MP.length-1]
            document.getElementById('apellidop_mpE').value = NOMBRE_MP[NOMBRE_MP.length-2]
            document.getElementById('nombre_mpE').value=""
            for (let i = 0; i <= NOMBRE_MP.length-3; i++) {
                document.getElementById('nombre_mpE').value += NOMBRE_MP[i]+" "
            }
        }
        const rowsTablePlacas = data.placas;
        for (let i = 0; i < rowsTablePlacas.length; i++) {
            let formData = {
                tipo_placaE: rowsTablePlacas[i].DESCRIPCION,
                Placa_VehiculoE: rowsTablePlacas[i].PLACA,
                procedencia_placaE: rowsTablePlacas[i].PROCEDENCIA
            }
            insertNewRowPlaca(formData);
        }
        const rowsTableNivs = data.nivs;
        for (let i = 0; i < rowsTableNivs.length; i++) {
            let formData = {
                tipo_nivE: rowsTableNivs[i].DESCRIPCION,
                No_SerieE: rowsTableNivs[i].NO_SERIE,
            }
            insertNewRowNiv(formData);
        }
        if (data.vehiculo.Path_file != null) {
            document.getElementById('viewPDFIPH').innerHTML = `
                <embed src="${pathFile + data.vehiculo.Path_file}" width="100%" height="400"  type="application/pdf">
            `;
        }
        
        
    })
};


/*----------------Eventos de la tabla de placas-----------------*/
let selectedRowPlacas = null;
const onFormPlacaSubmitE  = () => {
    const campos = ['tipo_placaE', 'Placa_VehiculoE', 'procedencia_placaE'];
    if (validateFormPlaca(campos)) {
        let formData = readFormNiv(campos);
        if (selectedRowPlacas === null)
            insertNewRowPlaca(formData);
        else
            updateRowPlaca(formData);
        resetFormPlaca(campos);
    }
}

const insertNewRowPlaca = ({ tipo_placaE, Placa_VehiculoE, procedencia_placaE }, type) => {
    const table = document.getElementById('placas_vehiculosE').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);
    newRow.insertCell(0).innerHTML = tipo_placaE;
    newRow.insertCell(1).innerHTML = Placa_VehiculoE;
    newRow.insertCell(2).innerHTML = procedencia_placaE.toUpperCase();
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
    const campos = ['tipo_placaE', 'Placa_VehiculoE', 'procedencia_placaE'];
    document.getElementById('alertEditPlacaE').style.display = 'block';
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
    document.getElementById('alertEditPlacaE').style.display = 'none';
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
const onFormNivSubmitE = () => {
    const campos = ['tipo_nivE', 'No_SerieE'];
    if (validateFormNiv(campos)) {
        let formData = readFormNiv(campos);
        if (selectedRowNiv === null)
            insertNewRowNiv(formData);
        else
            updateRowNiv(formData);
        resetFormNiv(campos);
    }
}
const insertNewRowNiv = ({ tipo_nivE, No_SerieE }, type) => {
    const table = document.getElementById('niv_vehiculosE').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);
    newRow.insertCell(0).innerHTML = tipo_nivE;
    newRow.insertCell(1).innerHTML = No_SerieE;
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
    const campos = ['tipo_nivE', 'No_SerieE'];
    document.getElementById('alertEditNivE').style.display = 'block';
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
    document.getElementById('alertEditNivE').style.display = 'none';
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
const readTablePlacas=()=> {
    const table = document.getElementById('placas_vehiculosE');
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
    const table = document.getElementById('niv_vehiculosE');
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
    let vehiculo = document.getElementById("tipo_ficha_vehiculo_cambiar");
    let remision = document.getElementById("tipo_ficha_remision");
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
    document.getElementById('ficha_Vehiculo').disabled = false;
    document.getElementById('ficha_Vehiculo').value="";
    if(remision.style.display=="block")
        document.getElementById('ficha_Vehiculo').addEventListener('input',sacar_primer_respondiente)
    if(remision.style.display=="none")
        document.getElementById('primerm_VehiculoE').disabled=false;
  //  fichal.style.display = (opcion=="si") ? "none" : "block";
}
cambiar_ficha.addEventListener('change', (event) => {
    if (event.currentTarget.checked) {
      if(ficha_remision_anterior!=0){
        if(document.getElementById('es_admin').value==1){
                document.getElementById('ficha_Vehiculo').disabled = false;
                document.getElementById('ficha_Vehiculo').value = "";
                document.getElementById('primerm_VehiculoE').disabled = false;
                document.getElementById('ficha_Vehiculo').addEventListener('input',sacar_primer_respondiente)
                document.getElementById('tipo1').disabled=false;
                document.getElementById('tipo2').disabled=false;
        }
      }
      else{
        if(document.getElementById('es_admin').value==1){
                document.getElementById('ficha_Vehiculo_v').disabled = false;
                document.getElementById('tipo_ficha_vehiculo_cambiar').style.display ="block"; 
                document.getElementById('tipo_ficha_vehiculo').style.display ="none"; 
                document.getElementById('tipo1').disabled=false;
                document.getElementById('tipo2').disabled=false;
        }
      }
    } else {
        //----pensar en esto al final
        if(ficha_remision_anterior!=0){
            if(document.getElementById('es_admin').value==1){
                    document.getElementById('ficha_Vehiculo').disabled = false;
                    document.getElementById('ficha_Vehiculo').value = "";
                    document.getElementById('ficha_Vehiculo').addEventListener('input',sacar_primer_respondiente)
                    document.getElementById('primerm_VehiculoE').disabled = false;
                    document.getElementById('tipo1').disabled=true;
                    document.getElementById('tipo2').disabled=true;
            }
          }
          else{
            if(document.getElementById('es_admin').value==1){
                    document.getElementById('ficha_Vehiculo_v').disabled = true;
                    document.getElementById('tipo_ficha_vehiculo_cambiar').style.display ="none"; 
                    document.getElementById('tipo_ficha_vehiculo').style.display ="block"; 
                    document.getElementById('tipo1').disabled=true;
                    document.getElementById('tipo2').disabled=true;
            }
          }
    }
  })
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
/* -------------------------------AUTOCOMPLETE DE LAS COLONIAS----------------------------------------------*/
const inputColonia = document.getElementById('colonia_VehiculoE');
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
            input: colonia_VehiculoE,
            fetch: function(text, update) {
                text = text.toLowerCase();
                const suggestions = arr.filter(n => n.label.toLowerCase().includes(text))
                update(suggestions);
            },
            onSelect: function(item) {
                colonia_VehiculoE.value = item.label;
            }
        }); 
    })
    .catch(err => alert(`Ha ocurrido un error al obtener las colonias.\nCódigo de error: ${ err }`))
});

const validateColonia = async ()=> {
    var coloniaValida = "Ingrese una colonia valida";
    coloniasCatalogo = await getAllColonias();
    if((document.getElementById('colonia_VehiculoE').value).length>0){
        let inputColoniaValue = createObjectColonia (document.getElementById('colonia_VehiculoE').value);
        console.log(inputColoniaValue)
        console.log(coloniasCatalogo)
      //  console.log(inputColoniaValue)
        const result = coloniasCatalogo.find( colonia => (colonia.Tipo.toUpperCase() == inputColoniaValue.Tipo.toUpperCase() && colonia.Colonia.toUpperCase() == inputColoniaValue.Colonia.toUpperCase()) ) // SI ESTO ME REGRESA EL MISMO OBJETO QUIERE DECIR QUE SI LO ENCONTRO EN EL CATALOGO UNDEFINED SI NO
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
const uploadFileIPH = (obj) => {
    const name = obj.target.files[0].name,
        content = document.getElementById('fileIPHResult');

    content.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
            <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
            <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
            <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
        </svg>
        <p class="text-center">${name}</p>
    `;
}
document.getElementById('SubmarcaE').addEventListener('input',submarca_opciones)
function submarca_opciones(e){
        termino=(document.getElementById('SubmarcaE')).value
        input_elegido=document.getElementById('SubmarcaE')
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
document.getElementById('MarcaE').addEventListener('input',marcas_opciones)
function marcas_opciones(e){
    termino=(document.getElementById('MarcaE')).value
    input_elegido=document.getElementById('MarcaE')
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
    let inputMarcaValue = document.getElementById('MarcaE').value;
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
    let inputSubmarcaValue = document.getElementById('SubmarcaE').value;
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
                document.getElementById('primerm_VehiculoE').disabled=false;
                document.getElementById('primerm_VehiculoE').value=data.sector;
                document.getElementById('primerm_VehiculoE').disabled=true;
            }
            else
                document.getElementById('primerm_VehiculoE').disabled=false;
        } catch (error) {
            console.log(error);
        }
    }
}

    
