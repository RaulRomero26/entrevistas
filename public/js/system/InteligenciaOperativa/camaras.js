let selectedRowCamaras = null;

const onFormSegCamarasSubmit = () => {

    const campos = ['Ubicacion_Camaras', 'Funciona_Camara', 'tipo_camara2'];
    if (validateFormCamaras(campos)) {
        let formData = readFormCamaras(campos);
        if (selectedRowCamaras === null)
            insertNewRowCamaras(formData);
        else
            updateRowCamaras(formData);

        resetFormCamaras(campos);
    }
}

const insertNewRowCamaras = ({ Ubicacion_Camaras, Funciona_Camara, tipo_camara2}, type) => {

    const table = document.getElementById('camarasIO').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);

    newRow.insertCell(0).innerHTML = Ubicacion_Camaras;
    newRow.insertCell(1).innerHTML = Funciona_Camara;
    newRow.insertCell(2).innerHTML = tipo_camara2;
    if (type != 'view') {
        newRow.insertCell(3).innerHTML = `<button class="btn btn-primary" onclick="editRowCamaras(this)"> 
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
        </button>`;
        newRow.insertCell(4).innerHTML = `<input type="button" class="btn btn-primary" value="-" onclick="deleteRowCamara(this,camarasIO)">`;
    }
}

const editRowCamaras = (obj) => {

    document.getElementById('alertEditCamaras').style.display = 'block';

    selectedRowCamaras = obj.parentElement.parentElement;
    document.getElementById('Ubicacion_Camaras').value = selectedRowCamaras.cells[0].innerHTML;
    document.getElementById('Funciona_Camara').value = selectedRowCamaras.cells[1].innerHTML;

    (selectedRowCamaras.cells[2].innerHTML === 'LPR') ? document.getElementById('tipo_camara2').checked = true : document.getElementById('tipo_camara1').checked = true;
}

const updateRowCamaras = ({ Ubicacion_Camaras, Funciona_Camara}) => {

    selectedRowCamaras.cells[0].innerHTML = Ubicacion_Camaras.toUpperCase();
    selectedRowCamaras.cells[1].innerHTML = Funciona_Camara.toUpperCase();
    selectedRowCamaras.cells[2].innerHTML = (document.getElementById('tipo_camara2').checked) ? 'LPR' : 'CÁMARA';
    document.getElementById('alertEditCamaras').style.display = 'none';

}

const readFormCamaras = (campos) => {
    let formData = {}
    for (let i = 0; i < campos.length; i++) {
        if(campos[i] === 'tipo_camara2'){
            (document.getElementById('tipo_camara2').checked) ? formData[campos[i]] = 'LPR' : formData[campos[i]] = 'CÁMARA';
        }else{
            formData[campos[i]] = document.getElementById(campos[i]).value;
        }
    }
    return formData;
}

const resetFormCamaras = (campos) => {
    for (let i = 0; i < campos.length; i++) {
        document.getElementById(campos[i]).value = '';
    }
    selectedRowCamaras = null;
}

/* ----- ----- ----- Funciones reutilizables ----- ----- ----- */

const deleteRowCamara = (obj, tableId) => {
    if (confirm('¿Desea eliminar este elemento?')) {
        const row = obj.parentElement.parentElement;
        document.getElementById(tableId.id).deleteRow(row.rowIndex);
    }
}

const validateFormCamaras = (campos) => {
    let isValid = true;
    for (i = 0; i < campos.length; i++) {
        if(campos[i] != 'tipo_camara2'){
            if (document.getElementById(campos[i]).value === "") {
                isValid = false;
                document.getElementById(campos[i] + '-invalid').style.display = 'block';
            } else {
                document.getElementById(campos[i] + '-invalid').style.display = 'none';
            }
        }
    }
    return isValid;
}