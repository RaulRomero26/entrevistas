/* ----- ----- ----- Condicionales check ----- ----- ----- */
const showHide = (apartado)=>{
    let si = document.getElementById(`${apartado}2`);
    let content = document.getElementById(apartado);
    content.style.display = si.checked ? "block" : "none";
}

/* ----- ----- ----- Eventos Instituciones de seguridad ----- ----- ----- */
let selectedRowInstituciones = null;

const onFormInstitucionSubmit = ()=>{

    const campos = ['tipoInstitucion','corporacionInstitucion'];

    if(validateFormInstitucion(campos)){
        let formData = readFormInstitucion(campos);
        if(selectedRowInstituciones === null)
            insertNewRowInstitucion(formData);
        else
            updateRowInstitucion(formData);

        resetFormInstitucion(campos);
    }

}

const insertNewRowInstitucion = ({tipoInstitucion, corporacionInstitucion},type)=>{

    const table = document.getElementById('institucionesSeguridad').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);

    newRow.insertCell(0).innerHTML = tipoInstitucion;
    newRow.insertCell(1).innerHTML = corporacionInstitucion.toUpperCase();
    if(type === undefined){
        newRow.insertCell(2).innerHTML = `<button type="button" class="btn btn-primary" onclick="editInstitucion(this)"> 
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
        </button>`;
        newRow.insertCell(3).innerHTML = `<input type="button" class="btn btn-primary" value="-" onclick="deleteRow(this,institucionesSeguridad)">`;
    }

}

const editInstitucion = (obj)=>{

    const campos = ['tipoInstitucion','corporacionInstitucion'];

    document.getElementById('alertEditInstitucion').style.display = 'block';

    selectedRowInstituciones = obj.parentElement.parentElement;
    for(let i=0; i<campos.length;i++){
        document.getElementById(campos[i]).value = selectedRowInstituciones.cells[i].innerHTML;
    }
    
}

const updateRowInstitucion = (data)=>{

    for(dataKey in data){
        let i = Object.keys(data).indexOf(dataKey);
        selectedRowInstituciones.cells[i].innerHTML = data[dataKey].toUpperCase();
    }

    document.getElementById('alertEditInstitucion').style.display = 'none';
}

const readFormInstitucion= (campos)=>{
    
    let formData = {}
    for(let i=0; i<campos.length;i++){
        formData[campos[i]] = document.getElementById(campos[i]).value;
    }
    
    return formData;
    
}

const resetFormInstitucion = (campos)=>{
    
    for(let i=0;i<campos.length;i++){
        document.getElementById(campos[i]).value='';
    }

    selectedRowInstituciones = null;

}

const validateFormInstitucion = (campos)=>{

    let isValid = true;

    for(i=0; i<campos.length; i++){
        if(document.getElementById(campos[i]).value === ""){
            isValid = false;
            document.getElementById(campos[i]+'-invalid').style.display = 'block';
        }else{
            document.getElementById(campos[i]+'-invalid').style.display = 'none';
        }
    }

    return isValid;

}

/* ----- ----- ----- Eventos Faltas administrativas ----- ----- ----- */
let selectedRowFaltas = null;

const onFormFaltasSubmit = ()=>{

    const campos = ['descripcionFaltaAdministrativa','dateFaltaAdministrativa'];

    if(validateFormFaltas(campos)){
        let formData = readFormFaltas(campos);
        if(selectedRowFaltas === null)
            insertNewRowFaltas(formData);
        else
            updateRowFaltas(formData);

        resetFormFaltas(campos);
    }

}

const insertNewRowFaltas = ({descripcionFaltaAdministrativa, dateFaltaAdministrativa},type)=>{

    const table = document.getElementById('faltasAdministrativas').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);

    newRow.insertCell(0).innerHTML = descripcionFaltaAdministrativa.toUpperCase();
    newRow.insertCell(1).innerHTML = dateFaltaAdministrativa;
    if(type === undefined){
        newRow.insertCell(2).innerHTML = `<button type="button" class="btn btn-primary" onclick="editFaltas(this)"> 
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
        </button>`;
        newRow.insertCell(3).innerHTML = `<input type="button" class="btn btn-primary" value="-" onclick="deleteRow(this,faltasAdministrativas)">`;
    }
}

const editFaltas = (obj)=>{

    const campos = ['descripcionFaltaAdministrativa','dateFaltaAdministrativa'];

    document.getElementById('alertEditFaltaAdmin').style.display = 'block';

    selectedRowFaltas = obj.parentElement.parentElement;
    for(let i=0; i<campos.length;i++){
        document.getElementById(campos[i]).value = selectedRowFaltas.cells[i].innerHTML;
    }
    
}

const updateRowFaltas = (data)=>{

    for(dataKey in data){
        let i = Object.keys(data).indexOf(dataKey);
        selectedRowFaltas.cells[i].innerHTML = data[dataKey].toUpperCase();
    }

    document.getElementById('alertEditFaltaAdmin').style.display = 'none';

}

const readFormFaltas= (campos)=>{
    
    let formData = {}
    for(let i=0; i<campos.length;i++){
        formData[campos[i]] = document.getElementById(campos[i]).value;
    }
    
    return formData;
    
}

const resetFormFaltas = (campos)=>{
    
    for(let i=0;i<campos.length;i++){
        document.getElementById(campos[i]).value='';
    }

    selectedRowFaltas = null;

}

const validateFormFaltas = (campos)=>{

    let isValid = true;

    for(i=0; i<campos.length; i++){
        if(document.getElementById(campos[i]).value === ""){
            isValid = false;
            document.getElementById(campos[i]+'-invalid').style.display = 'block';
        }else{
            document.getElementById(campos[i]+'-invalid').style.display = 'none';
        }
    }

    return isValid;

}

/* ----- ----- ----- Eventos Antecedentes Penales ----- ----- ----- */
let selectedRowAntecedentes = null;

const onFormAntecedentesSubmit = ()=>{

    const campos = ['descripcionAntecedentePenal','dateAntecedentePenal'];

    if(validateFormAntecedentes(campos)){
        let formData = readFormAntecedentes(campos);
        if(selectedRowAntecedentes === null)
            insertNewRowAntecedentes(formData);
        else
            updateRowAntecedentes(formData);

        resetFormAntecedentes(campos);
    }

}

const insertNewRowAntecedentes = ({descripcionAntecedentePenal, dateAntecedentePenal},type)=>{

    const table = document.getElementById('antecedentePenales').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);

    newRow.insertCell(0).innerHTML = descripcionAntecedentePenal.toUpperCase();
    newRow.insertCell(1).innerHTML = dateAntecedentePenal;
    if(type === undefined){
        newRow.insertCell(2).innerHTML = `<button type="button" class="btn btn-primary" onclick="editAntecedentes(this)"> 
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
        </button>`;
        newRow.insertCell(3).innerHTML = `<input type="button" class="btn btn-primary" value="-" onclick="deleteRow(this,antecedentePenales)">`;
    }

}

const editAntecedentes = (obj)=>{

    const campos = ['descripcionAntecedentePenal','dateAntecedentePenal'];

    document.getElementById('alertEditAntecedente').style.display = 'block';

    selectedRowAntecedentes = obj.parentElement.parentElement;
    for(let i=0; i<campos.length;i++){
        document.getElementById(campos[i]).value = selectedRowAntecedentes.cells[i].innerHTML;
    }
    
}

const updateRowAntecedentes = (data)=>{

    for(dataKey in data){
        let i = Object.keys(data).indexOf(dataKey);
        selectedRowAntecedentes.cells[i].innerHTML = data[dataKey].toUpperCase();
    }

    document.getElementById('alertEditAntecedente').style.display = 'none';

}

const readFormAntecedentes= (campos)=>{
    
    let formData = {}
    for(let i=0; i<campos.length;i++){
        formData[campos[i]] = document.getElementById(campos[i]).value;
    }
    
    return formData;
    
}

const resetFormAntecedentes = (campos)=>{
    
    for(let i=0;i<campos.length;i++){
        document.getElementById(campos[i]).value='';
    }

    selectedRowAntecedentes = null;

}

const validateFormAntecedentes = (campos)=>{

    let isValid = true;

    for(i=0; i<campos.length; i++){
        if(document.getElementById(campos[i]).value === ""){
            isValid = false;
            document.getElementById(campos[i]+'-invalid').style.display = 'block';
        }else{
            document.getElementById(campos[i]+'-invalid').style.display = 'none';
        }
    }

    return isValid;

}

/* ----- ----- ----- Eventos Adicciones ----- ----- ----- */
let selectedRowAdicciones = null;

const onFormAdiccionesSubmit = ()=>{

    const campos = ['tipoAdiccion','tiempoConsumo','frecuenciaConsumo','sueleRobar'];

    if(validateFormAdicciones(campos)){
        let formData = readFormAdicciones(campos);
        if(selectedRowAdicciones === null)
            insertNewRowAdicciones(formData);
        else
            updateRowAdicciones(formData);

        resetFormAdicciones(campos);
    }

}

const insertNewRowAdicciones= ({tipoAdiccion, tiempoConsumo, frecuenciaConsumo, sueleRobar},type)=>{

    const table = document.getElementById('adiccones').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);

    newRow.insertCell(0).innerHTML = tipoAdiccion;
    newRow.insertCell(1).innerHTML = tiempoConsumo.toUpperCase();
    newRow.insertCell(2).innerHTML = frecuenciaConsumo.toUpperCase();
    newRow.insertCell(3).innerHTML = sueleRobar.toUpperCase();
    if(type === undefined){
        newRow.insertCell(4).innerHTML = `<button type="button" class="btn btn-primary" onclick="editAdicciones(this)"> 
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
        </button>`;
        newRow.insertCell(5).innerHTML = `<input type="button" class="btn btn-primary" value="-" onclick="deleteRow(this,adiccones)">`;
    }

}

const editAdicciones = (obj)=>{

    const campos = ['tipoAdiccion','tiempoConsumo','frecuenciaConsumo','sueleRobar'];

    document.getElementById('alertEditAdiccion').style.display = 'block';

    selectedRowAdicciones = obj.parentElement.parentElement;
    for(let i=0; i<campos.length;i++){
        document.getElementById(campos[i]).value = selectedRowAdicciones.cells[i].innerHTML;
    }

    if(document.getElementById('sueleRobar').value != ''){
        document.getElementById('mantener').style.display = 'block';
        document.getElementById('mantener2').checked = true;
    }else{
        document.getElementById('mantener').style.display = 'none';
        document.getElementById('mantener1').checked = true;
    }
    
}

const updateRowAdicciones = (data)=>{

    for(dataKey in data){
        let i = Object.keys(data).indexOf(dataKey);
        selectedRowAdicciones.cells[i].innerHTML = data[dataKey].toUpperCase();
    }

    const sueleRobar = document.getElementById('mantener2');
    selectedRowAdicciones.cells[3].innerHTML = sueleRobar.checked ? data.sueleRobar.toUpperCase() : '';

    document.getElementById('alertEditAdiccion').style.display = 'none';

}

const readFormAdicciones = (campos)=>{
    
    let formData = {}
    for(let i=0; i<campos.length;i++){
        formData[campos[i]] = document.getElementById(campos[i]).value;
    }
    
    return formData;
    
}

const resetFormAdicciones = (campos)=>{
    
    for(let i=0;i<campos.length;i++){
        document.getElementById(campos[i]).value='';
    }

    document.getElementById('mantener1').checked = true;
    document.getElementById('mantener').style.display = 'none';

    selectedRowAdicciones = null;

}

const validateFormAdicciones = (campos)=>{

    let isValid = true;

    const roba = document.getElementById('mantener2');

    if(roba.checked){
        for(i=0; i<campos.length; i++){
            if(document.getElementById(campos[i]).value === ""){
                isValid = false;
                document.getElementById(campos[i]+'-invalid').style.display = 'block';
            }else{
                document.getElementById(campos[i]+'-invalid').style.display = 'none';
            }
        }
    }else{
        for(i=0; i<campos.length-1; i++){
            if(document.getElementById(campos[i]).value === ""){
                isValid = false;
                document.getElementById(campos[i]+'-invalid').style.display = 'block';
            }else{
                document.getElementById(campos[i]+'-invalid').style.display = 'none';
            }
        }
    }

    return isValid;

}