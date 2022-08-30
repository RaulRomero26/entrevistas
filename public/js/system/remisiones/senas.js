function clickPiece(id,name){

    const piece = document.getElementById(id);

    if(selectedRowSenas != null){
        alert('Lo sentimos no puede realizar esta acción mientras edita un elemento');
    }else{
        if(piece.classList.contains('piece-active')){
            
            const li = document.getElementById('li-'+id);
            
            li.parentNode.removeChild(li);
            piece.classList.remove('piece-active');

        }else{

            const list = document.getElementById("list"),
                text = document.createTextNode(name),
                newItem = document.createElement("li");

            newItem.appendChild(text);
            newItem.setAttribute("id",'li-'+id);
            newItem.setAttribute("class",'senas-list');
            list.appendChild(newItem);
            piece.classList.add('piece-active');

        }
    }

}

/* ----- ----- ----- Toogle tipo de seña particular (Tatuajes u otros) ----- ----- ----- */
function selectSena(){
    const selectSena = document.getElementById("senasparticulares");
    document.getElementById("tatuajes").style.display = selectSena.value != "TATUAJES" ? 'none': 'block';
}

/* ----- ----- ----- Toogle del perfil de cuerpo humano (FRONTAL/Posterior) ----- ----- ----- */
const onChangePerfil = ()=>{
    const selectPerfil = document.getElementById("selectPerfil");
    document.getElementById("front").style.display = selectPerfil.value != "FRONTAL" ? 'none': 'block';
    document.getElementById("back").style.display = selectPerfil.value != "FRONTAL" ? 'block': 'none';
}

function selectPiece(partes){
    const items = partes.getElementsByTagName('li');
    for(let i=0; i<items.length; i++){
        const id = items[i].id.substring(3);
        document.getElementById(id).classList.remove('piece-active');
        document.getElementById(id).classList.add('select-piece');
    }
}

/* ----- ----- ----- Eventos señas particulares ----- ----- ----- */
let selectedRowSenas = null;

const onFormSenasSubmit = ()=>{

    const campos = ['selectPerfil','senasparticulares','clasificacion','colorTatuaje','descripcion'];

    if(validateFormSena()){
        let formData = readFormDataSenas(campos);
        if(selectedRowSenas === null)
            insertNewRowSenas(formData);
        else
            updateRowSenas(formData);
        resetFormSenas(campos);
    }

}

const readFormDataSenas = (campos)=>{
    let formData = {};
    for(let i=0; i<campos.length;i++){
        if(campos[i] === 'colorTatuaje'){
            formData[campos[i]] = document.getElementById(campos[i]).checked;
        }else{
            formData[campos[i]] = document.getElementById(campos[i]).value;
        }
    }

    formData['list'] = document.getElementById('list').innerHTML;
    return formData;
}

const insertNewRowSenas = ({selectPerfil,senasparticulares,clasificacion,colorTatuaje,descripcion,list},type)=>{

    const table = document.getElementById('senas').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);
    
    if(type === undefined){
        const partes = document.getElementById('list');
        selectPiece(partes);
    }

    newRow.insertCell(0).innerHTML = selectPerfil;
    newRow.insertCell(1).innerHTML = list;
    newRow.insertCell(2).innerHTML = senasparticulares;
    if(senasparticulares === 'TATUAJES' && colorTatuaje === true){
        newRow.insertCell(3).innerHTML = `
            <div class="form-check ml-5">
                <input class="form-check-input" type="radio" value="true" checked>
                <label class="form-check-label">
                </label>
            </div>
        `;
    }else{
        newRow.insertCell(3).innerHTML = '';
    }
    if(senasparticulares === 'TATUAJES'){
        newRow.insertCell(4).innerHTML = clasificacion;
    }else{
        newRow.insertCell(4).innerHTML = '';
    }
    newRow.insertCell(5).innerHTML = descripcion.toUpperCase();
    if(type === 'view'){   
        newRow.insertCell(6).innerHTML = `
            <div id="imageContent_row${newRow.rowIndex}"></div>
        `;
    }else{
        newRow.insertCell(6).innerHTML = `
            <div class="d-flex justify-content-around" id="uploadContent_row${newRow.rowIndex}">
                <div class="form-group">
                    <input type="file" name="sena_row${newRow.rowIndex}" accept="image/*" id="fileSena_row${newRow.rowIndex}" class="inputfile uploadFileSenas" onchange="uploadFile(event)" data-toggle="tooltip" data-placement="bottom">
                    <label for="fileSena_row${newRow.rowIndex}" >
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cloud-upload" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z"/>
                            <path fill-rule="evenodd" d="M7.646 4.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V14.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3z"/>
                        </svg>
                    </label>
                </div>
                <div class="form-group ml-2 senas-canvas-mobile">
                    <label class="btn-photo" id="row-${newRow.rowIndex}" onclick="onloadCamera('senas',this)" data-toggle="modal" data-target="#capturePhotosenas">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-camera" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M15 12V6a1 1 0 0 0-1-1h-1.172a3 3 0 0 1-2.12-.879l-.83-.828A1 1 0 0 0 9.173 3H6.828a1 1 0 0 0-.707.293l-.828.828A3 3 0 0 1 3.172 5H2a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"/>
                            <path fill-rule="evenodd" d="M8 11a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            <path d="M3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
                        </svg>
                    </label>
                </div>
            </div>
            <div id="imageContent_row${newRow.rowIndex}"></div>
        `;
        newRow.insertCell(7).innerHTML = `<button type="button" class="btn btn-primary" onclick="editSenas(this)"> 
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
        </button>`;
        newRow.insertCell(8).innerHTML = `<input type="button" class="btn btn-primary" value="-" onclick="deleteSena(this)">`;
    }

}

const editSenas = (obj)=>{

    const svgs = document.getElementById('body').getElementsByTagName('svg');

    for(let i=0; i<svgs.length; i++){
        if(svgs[i].classList.contains('piece-active')){
            document.getElementById(svgs[i].id).classList.remove('piece-active');
        }
    }

    document.getElementById('alertEditSena').style.display = 'block';
    
    selectedRowSenas = obj.parentElement.parentElement;
    document.getElementById('list').innerHTML = selectedRowSenas.cells[1].innerHTML;
    document.getElementById('senasparticulares').value = selectedRowSenas.cells[2].innerHTML;
    document.getElementById('clasificacion').value = selectedRowSenas.cells[4].innerHTML;
    document.getElementById('descripcion').value = selectedRowSenas.cells[5].innerHTML;

    if(selectedRowSenas.cells[3].innerHTML.length != 0){
        document.getElementById('colorTatuaje').checked = true;
    }
    
    var selectSena = document.getElementById("senasparticulares");
    document.getElementById("tatuajes").style.display = selectSena.value != "TATUAJES" ? 'none': 'block';

}

const updateRowSenas = ({senasparticulares,colorTatuaje,clasificacion,descripcion})=>{

    selectedRowSenas.cells[2].innerHTML = senasparticulares;
    if(senasparticulares === 'TATUAJES' &&  colorTatuaje === true)
        selectedRowSenas.cells[3].innerHTML = `
            <div class="form-check ml-5">
                <input class="form-check-input" type="radio" value="true" checked>
                <label class="form-check-label">
                </label>
            </div>
        `;
    else
        selectedRowSenas.cells[3].innerHTML = '';
    if(senasparticulares === 'TATUAJES')
        selectedRowSenas.cells[4].innerHTML = clasificacion;
    else
        selectedRowSenas.cells[4].innerHTML = '';
    selectedRowSenas.cells[5].innerHTML = descripcion.toUpperCase();
    document.getElementById('alertEditSena').style.display = 'none';

}

const resetFormSenas = (campos)=>{

    for(let i=1;i<campos.length;i++){
        if(campos[i] === 'colorTatuaje'){
            document.getElementById(campos[i]).checked = false;
        }else{
            document.getElementById(campos[i]).value='';
        }
    }
    document.getElementById('list').innerHTML ='';

    selectedRowSenas = null;

}

const deleteSena = (obj)=>{
    if(confirm('¿Desea eliminar este elemento?')){
        
        const svgs = document.getElementById('body').getElementsByTagName('svg'),
            table = document.getElementById('senas');

        for(let i=0; i<svgs.length; i++){
            if(svgs[i].classList.contains('select-piece')){
                document.getElementById(svgs[i].id).classList.remove('select-piece');
            }
        }

        const row = obj.parentElement.parentElement;
        table.deleteRow(row.rowIndex);

        for(let i=1;i<table.rows.length;i++){

            let contenedorImg = table.rows[i].cells[6].childNodes[3];

            contenedorImg.setAttribute('id', 'imageContent_row'+i);
            contenedorImg.childNodes[1].childNodes[3].setAttribute('id', 'images_row_'+i);

            let contenedorInput = table.rows[i].cells[6].childNodes[1];

            contenedorInput.setAttribute('id', 'uploadContent_row'+i);
            contenedorInput.childNodes[1].childNodes[1].setAttribute('id', 'fileSena_row'+i);
            contenedorInput.childNodes[1].childNodes[1].setAttribute('name', 'sena_row'+i);
            contenedorInput.childNodes[1].childNodes[3].setAttribute('for', 'fileSena_row'+i);
            contenedorInput.childNodes[3].childNodes[1].setAttribute('id', 'row-'+i);

        }

        const items = table.getElementsByTagName('li');

        for(let j=0; j<items.length;j++){

            if(!document.getElementById(items[j].id.substring(3)).classList.contains('select-piece')){
                document.getElementById(items[j].id.substring(3)).classList.add('select-piece');
            }

        }
    }
}

const validateFormSena = () =>{

    let isValid = true;

    const items = document.getElementById('list').getElementsByTagName('li');
    if(items.length === 0){
        isValid = false; 
        document.getElementById('list-invalid').style.display = 'block';
    }else{
        document.getElementById('list-invalid').style.display = 'none';
        const tipo = document.getElementById('senasparticulares');
    
        if(tipo.value === ""){
            isValid = false; 
            document.getElementById('senasparticulares-invalid').style.display = 'block';
        }else{
            document.getElementById('senasparticulares-invalid').style.display = 'none';
            if(tipo.value === "TATUAJES"){
                if(document.getElementById('clasificacion').value === ""){
                    isValid = false;
                    document.getElementById('clasificacion-invalid').style.display = 'block';
                }else{
                    document.getElementById('clasificacion-invalid').style.display = 'none';
                }
                if(document.getElementById('descripcion').value === ""){
                    isValid = false;
                    document.getElementById('descripcion-invalid').style.display = 'block';
                }else{
                    document.getElementById('descripcion-invalid').style.display = 'none';
                }
            }else{
                if(document.getElementById('descripcion').value === ""){
                    isValid = false;
                    document.getElementById('descripcion-invalid').style.display = 'block';
                }else{
                    document.getElementById('descripcion-invalid').style.display = 'none';
                }
            }
        }
    }


    return isValid;
}


/* ----- ----- ----- Eventos accesorios ----- ----- ----- */
let selectedRowAccesorios = null;

const onFormAccesorioSubmit = ()=>{

    const campos = ['tipoAccesorio','descripcionAccesorio'];

    if(validateFormAccesorio(campos)){
        let formData = readFormDataAccesorio(campos);
        if(selectedRowAccesorios === null)
            insertNewRowAccesorio(formData);
        else
            updateRowAccesorio(formData);
        resetFormAccesorio(campos);
    }

}

const readFormDataAccesorio = (campos)=>{
    
    let formData = {}
    for(let i=0; i<campos.length;i++){
        formData[campos[i]] = document.getElementById(campos[i]).value;
    }
    
    return formData;
}

const insertNewRowAccesorio = ({tipoAccesorio,descripcionAccesorio},type)=>{

    const table = document.getElementById('accesorios').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);

    newRow.insertCell(0).innerHTML = tipoAccesorio;
    newRow.insertCell(1).innerHTML = descripcionAccesorio.toUpperCase();
    if(type === undefined){
        newRow.insertCell(2).innerHTML = `<button type="button" class="btn btn-primary" onclick="editAccesorio(this)"> 
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
        </button>`;
        newRow.insertCell(3).innerHTML = `<input type="button" class="btn btn-primary" value="-" onclick="deleteAccesorio(this)">`;
    }

}

const editAccesorio = (obj)=>{

    const campos = ['tipoAccesorio','descripcionAccesorio'];

    document.getElementById('alertEditAccesorio').style.display = 'block';

    selectedRowAccesorios = obj.parentElement.parentElement;
    for(let i=0; i<campos.length;i++){
        document.getElementById(campos[i]).value = selectedRowAccesorios.cells[i].innerHTML;
    }

}

const updateRowAccesorio = (data)=>{

    for(dataKey in data){
        let i = Object.keys(data).indexOf(dataKey);
        selectedRowAccesorios.cells[i].innerHTML = data[dataKey].toUpperCase();
    }

    document.getElementById('alertEditAccesorio').style.display = 'none';

}

const deleteAccesorio = (obj)=>{
    if(confirm('¿Desea eliminar este elemento?')){
        const row = obj.parentElement.parentElement;
        document.getElementById('accesorios').deleteRow(row.rowIndex);
        resetFormAccesorio();
    }
}

const resetFormAccesorio = (campos)=>{

    for(let i=0;i<campos.length;i++){
        document.getElementById(campos[i]).value='';
    }

    selectedRowAccesorios = null;

}

const validateFormAccesorio = (campos)=>{

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

/* ----- ----- ----- Convetir string de la DB a li ----- ----- ----- */
const createListLI = (parte,perfil)=>{
    const partes = parte.split(',');
    let li = [];

    const arreglo = [
        {
            "id": "ROSTRO",
            "value": "li-head",
            "perfil": "FRONTAL"
        },
        {
            "id": "CUELLO",
            "value": "li-neck",
            "perfil": "FRONTAL"
        },
        {
            "id": "PECTORAL DERECHO",
            "value": "li-chest-right",
            "perfil": "FRONTAL"
        },
        {
            "id": "PECTORAL IZQUIERDO",
            "value": "li-chest-left",
            "perfil": "FRONTAL"
        },
        {
            "id": "HOMBRO DERECHO",
            "value": "li-shoulder-right",
            "perfil": "FRONTAL"
        },
        {
            "id": "HOMBRO IZQUIERDO",
            "value": "li-shoulder-left",
            "perfil": "FRONTAL"
        },
        {
            "id": "BRAZO DERECHO",
            "value": "li-arm-right",
            "perfil": "FRONTAL"
        },
        {
            "id": "BRAZO IZQUIERDO",
            "value": "li-arm-left",
            "perfil": "FRONTAL"
        },
        {
            "id": "ANTE-BRAZO DERECHO",
            "value": "li-forearm-right",
            "perfil": "FRONTAL"
        },
        {
            "id": "ANTE-BRAZO IZQUIERDO",
            "value": "li-forearm-left",
            "perfil": "FRONTAL"
        },
        {
            "id": "ABDOMEN DERECHO",
            "value": "li-abdomen-right",
            "perfil": "FRONTAL"
        },
        {
            "id": "ABDOMEN IZQUIERDO",
            "value": "li-abdomen-left",
            "perfil": "FRONTAL"
        },
        {
            "id": "MUSLO DERECHO",
            "value": "li-leg-right",
            "perfil": "FRONTAL"
        },
        {
            "id": "MUSLO IZQUIERDO",
            "value": "li-leg-left",
            "perfil": "FRONTAL"
        },
        {
            "id": "MANO DERECHA",
            "value": "li-hand-right",
            "perfil": "FRONTAL"
        },
        {
            "id": "MANO IZQUIERDA",
            "value": "li-hand-left",
            "perfil": "FRONTAL"
        },
        {
            "id": "PIERNA DERECHA",
            "value": "li-calf-right",
            "perfil": "FRONTAL"
        },
        {
            "id": "PIERNA IZQUIERDA",
            "value": "li-calf-left",
            "perfil": "FRONTAL"
        },
        {
            "id": "PIE DERECHO",
            "value": "li-foot-right",
            "perfil": "FRONTAL"
        },
        {
            "id": "PIE IZQUIERDO",
            "value": "li-foot-left",
            "perfil": "FRONTAL"
        },
        {
            "id": "NUCA",
            "value": "li-nape",
            "perfil": "POSTERIOR"
        },
        {
            "id": "TRAPECIO DERECHO",
            "value": "li-trapezius-right",
            "perfil": "POSTERIOR"
        },
        {
            "id": "TRAPECIO IZQUIERDO",
            "value": "li-trapezius-left",
            "perfil": "POSTERIOR"
        },
        {
            "id": "TRONCO DERECHO",
            "value": "li-trunk-right",
            "perfil": "POSTERIOR"
        },
        {
            "id": "TRONCO IZQUIERDO",
            "value": "li-trunk-left",
            "perfil": "POSTERIOR"
        },
        {
            "id": "HOMBRO DERECHO",
            "value": "li-p-shoulder-right",
            "perfil": "POSTERIOR"
        },
        {
            "id": "HOMBRO IZQUIERDO",
            "value": "li-p-shoulder-left",
            "perfil": "POSTERIOR"
        },
        {
            "id": "BRAZO DERECHO",
            "value": "li-p-arm-right",
            "perfil": "POSTERIOR"
        },
        {
            "id": "BRAZO IZQUIERDO",
            "value": "li-p-arm-left",
            "perfil": "POSTERIOR"
        },
        {
            "id": "ANTE-BRAZO DERECHO",
            "value": "li-p-forearm-right",
            "perfil": "POSTERIOR"
        },
        {
            "id": "ANTE-BRAZO IZQUIERDO",
            "value": "li-p-forearm-left",
            "perfil": "POSTERIOR"
        },
        {
            "id": "GLUTEO DERECHO",
            "value": "li-gluteus-right",
            "perfil": "POSTERIOR"
        },
        {
            "id": "GLUTEO IZQUIERDO",
            "value": "li-gluteus-left",
            "perfil": "POSTERIOR"
        },
        {
            "id": "MANO DERECHA",
            "value": "li-p-hand-right",
            "perfil": "POSTERIOR"
        },
        {
            "id": "MANO IZQUIERDA",
            "value": "li-p-hand-left",
            "perfil": "POSTERIOR"
        },
        {
            "id": "MUSLO DERECHO",
            "value": "li-p-leg-right",
            "perfil": "POSTERIOR"
        },
        {
            "id": "MUSLO IZQUIERDO",
            "value": "li-p-leg-left",
            "perfil": "POSTERIOR"
        },
        {
            "id": "PIERNA DERECHA",
            "value": "li-p-calf-right",
            "perfil": "POSTERIOR"
        },
        {
            "id": "PIERNA IZQUIERDA",
            "value": "li-p-calf-left",
            "perfil": "POSTERIOR"
        },
        {
            "id": "PIE DERECHO",
            "value": "li-p-foot-right",
            "perfil": "POSTERIOR"
        },
        {
            "id": "PIE IZQUIERDO",
            "value": "li-p-foot-left",
            "perfil": "POSTERIOR"
        },
        {
            "id": "TALON DERECHO",
            "value": "li-heel-right",
            "perfil": "POSTERIOR"
        },
        {
            "id": "TALON IZQUIERDO",
            "value": "li-heel-left",
            "perfil": "POSTERIOR"
        }
    ]

    for(let i=0;i<partes.length;i++){
        let value;
        for(let j=0; j<arreglo.length;j++){
            if(arreglo[j].id === partes[i] & arreglo[j].perfil === perfil){
                value = arreglo[j].value;
            }
        }
        li.push(`<li id="${value}" class="senas-list">${partes[i]}</li>`);
    }

    return li;
}