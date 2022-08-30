const table = document.getElementById('FaltaDelitoTabla');
let selectedRowFaltaDelito = null;

const agregarFila = () => {
    const campos = ['delito_1', 'ruta', 'unidad', 'negocio'];
    if (validateFormFaltaDelito(campos)) {
        let formData = readFormFaltaDelito(campos);
        if (selectedRowFaltaDelito === null)
            insertNewRowFaltaDelito(formData);
        else
            updateFaltaDelito(formData);

        resetFormFaltaDelito(campos);
    }
}

const insertNewRowFaltaDelito = ({ delito_1, ruta, unidad, negocio}) => {
    
    if(existDelito(delito_1)){
        window.alert('El elemento ya existe en la tabla');
        return;
    }

    const tableDelito = table.getElementsByTagName('tbody')[0];
    let newRow = tableDelito.insertRow(table.length);

    newRow.insertCell(0).innerHTML = delito_1.toUpperCase();
    newRow.insertCell(1).innerHTML = negocio.toUpperCase();
    newRow.insertCell(2).innerHTML = ruta.toUpperCase();
    newRow.insertCell(3).innerHTML = unidad.toUpperCase();
    newRow.insertCell(4).innerHTML = `<button type="button" class="btn btn-primary" onclick="editFaltaDelito(this)"> 
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
        </svg>
    </button>`;
    newRow.insertCell(5).innerHTML = `<input type="button" class="btn btn-primary" value="-" onclick="deleteRow(this,FaltaDelitoTabla)">`; 
}

const editFaltaDelito = (obj) => {
    
    
    document.getElementById('msg_ubicacionHechosFalta').style.display = 'block';
    selectedRowFaltaDelito = obj.parentElement.parentElement;

    delitoSelectDom(selectedRowFaltaDelito.cells[0].innerHTML);

    document.getElementById('delito_1').value = selectedRowFaltaDelito.cells[0].innerHTML;
    document.getElementById('negocio').value = selectedRowFaltaDelito.cells[1].innerHTML;
    document.getElementById('ruta').value = selectedRowFaltaDelito.cells[2].innerHTML;
    document.getElementById('unidad').value = selectedRowFaltaDelito.cells[3].innerHTML;

}

const updateFaltaDelito = ({ delito_1, ruta, unidad, negocio}) => {

    if(existDelito(delito_1)){
        if(delito_1 != selectedRowFaltaDelito.cells[0].innerText){
            window.alert('El elemento ya existe en la tabla');
            document.getElementById('msg_ubicacionHechosFalta').style.display = 'none';
            return;
        }
    }

    const tableDelito = table.getElementsByTagName('tbody')[0];

    selectedRowFaltaDelito.cells[0].innerHTML = delito_1.toUpperCase();
    (delito_1 === 'ROBO A COMERCIO') ? selectedRowFaltaDelito.cells[1].innerHTML = negocio.toUpperCase() : selectedRowFaltaDelito.cells[1].innerHTML = '';
    (delito_1 === 'ROBO A TRANSPORTE PÚBLICO') ? selectedRowFaltaDelito.cells[2].innerHTML = ruta.toUpperCase() : selectedRowFaltaDelito.cells[2].innerHTML = '';
    (delito_1 === 'ROBO A TRANSPORTE PÚBLICO') ? selectedRowFaltaDelito.cells[3].innerHTML = unidad.toUpperCase() : selectedRowFaltaDelito.cells[3].innerHTML = '';

    document.getElementById('msg_ubicacionHechosFalta').style.display = 'none';
}

const readFormFaltaDelito = (campos) => {

    let formData = {}
    for (let i = 0; i < campos.length; i++) {
        formData[campos[i]] = document.getElementById(campos[i]).value;
    }

    return formData;

}

const resetFormFaltaDelito = (campos) => {

    for (let i = 0; i < campos.length; i++) {
        if(campos[i] != campos[0]){
            document.getElementById(campos[i]).value = '';
        }
    }

    selectedRowFaltaDelito = null;

}

const validateFormFaltaDelito = (campos) => {

    const delito = document.getElementById(campos[0]).value,
        ruta = document.getElementById(campos[1]).value,
        unidad = document.getElementById(campos[2]).value,
        comercio = document.getElementById(campos[3]).value;

    let FV = new FormValidator(),
        i = 0,
        band = [],
        success = true;

    switch(delito){
        case 'ROBO A COMERCIO':
            band[i++] = document.getElementById('letrero_1').innerText = FV.validate(delito, 'required');
            band[i++] = document.getElementById(`${campos[3]}_error`).innerText = FV.validate(comercio, 'required');
            break;
        case 'ROBO A TRANSPORTE PÚBLICO':
            band[i++] = document.getElementById('letrero_1').innerText = FV.validate(delito, 'required');
            band[i++] = document.getElementById(`${campos[1]}_error`).innerText = FV.validate(ruta, 'required');
            band[i++] = document.getElementById(`${campos[2]}_error`).innerText = FV.validate(unidad, 'required');
        break;
        default:
            band[i++] = document.getElementById('letrero_1').innerText = FV.validate(delito, 'required');
        break;
    }

    band.forEach(element => {
        success &= (element == '') ? true : false
    })

    return success;
}

const existDelito = (delito_1)=>{
    let band = false
    if(table.rows.length>1){
        let rows = table.rows;
        rows.forEach((row, i)=>{
            if(i>0) if(row.cells[0].innerText === delito_1) band = true;
        })
    }

    return band;

}