let selectedRowSegVehPer = null;

const onFormSegVehiculosSubmit = () => {

    const campos = ['marcaVehiculoSegPer', 'modeloVehiculoSegPer', 'colorVehiculoSegPer', 'identifiacionVehiculoSegPer', 'placaVehiculoSegPer', 'usoVehiculoSegPer', 'caracteristicasVehiculoSegPer','involucrado_robado2'];
    if (validateFormVehiculos(campos)) {
        let formData = readFormSegVehPer(campos);
        if (selectedRowSegVehPer === null)
            insertNewRowSegVehPer(formData);
        else
            updateRowSegVehPer(formData);

        resetFormSegVehPer(campos);
    }
}

const insertNewRowSegVehPer = ({ marcaVehiculoSegPer, modeloVehiculoSegPer, colorVehiculoSegPer, placaVehiculoSegPer, identifiacionVehiculoSegPer, usoVehiculoSegPer, caracteristicasVehiculoSegPer, involucrado_robado2 }, type) => {

    const table = document.getElementById('seguimientoVehiculosPer').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);

    newRow.insertCell(0).innerHTML = marcaVehiculoSegPer;
    newRow.insertCell(1).innerHTML = modeloVehiculoSegPer;
    newRow.insertCell(2).innerHTML = colorVehiculoSegPer;
    newRow.insertCell(3).innerHTML = identifiacionVehiculoSegPer;
    newRow.insertCell(4).innerHTML = placaVehiculoSegPer;
    newRow.insertCell(5).innerHTML = usoVehiculoSegPer;
    newRow.insertCell(6).innerHTML = involucrado_robado2;
    newRow.insertCell(7).innerHTML = caracteristicasVehiculoSegPer;
    if (type != 'view') {
        newRow.insertCell(8).innerHTML = `<button class="btn btn-primary" onclick="editSegVehPer(this)"> 
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
        </button>`;
        newRow.insertCell(9).innerHTML = `<input type="button" class="btn btn-primary" value="-" onclick="deleteRow(this,seguimientoVehiculosPer)">`;
    }
}

const editSegVehPer = (obj) => {

    document.getElementById('alertEditVehiculoSP').style.display = 'block';

    selectedRowSegVehPer = obj.parentElement.parentElement;
    document.getElementById('marcaVehiculoSegPer').value = selectedRowSegVehPer.cells[0].innerHTML;
    document.getElementById('modeloVehiculoSegPer').value = selectedRowSegVehPer.cells[1].innerHTML;
    document.getElementById('colorVehiculoSegPer').value = selectedRowSegVehPer.cells[2].innerHTML;
    document.getElementById('identifiacionVehiculoSegPer').value = selectedRowSegVehPer.cells[3].innerHTML;
    document.getElementById('placaVehiculoSegPer').value = selectedRowSegVehPer.cells[4].innerHTML;
    document.getElementById('usoVehiculoSegPer').value = selectedRowSegVehPer.cells[5].innerHTML;
    document.getElementById('caracteristicasVehiculoSegPer').value = selectedRowSegVehPer.cells[7].innerHTML;

    (selectedRowSegVehPer.cells[6].innerHTML === 'ROBADO') ? document.getElementById('involucrado_robado2').checked = true : document.getElementById('involucrado_robado1').checked = true;
}

const updateRowSegVehPer = ({ marcaVehiculoSegPer, modeloVehiculoSegPer, colorVehiculoSegPer, placaVehiculoSegPer, identifiacionVehiculoSegPer, usoVehiculoSegPer, caracteristicasVehiculoSegPer}) => {

    selectedRowSegVehPer.cells[0].innerHTML = marcaVehiculoSegPer.toUpperCase();
    selectedRowSegVehPer.cells[1].innerHTML = modeloVehiculoSegPer.toUpperCase();
    selectedRowSegVehPer.cells[2].innerHTML = colorVehiculoSegPer.toUpperCase();
    selectedRowSegVehPer.cells[3].innerHTML = identifiacionVehiculoSegPer.toUpperCase();
    selectedRowSegVehPer.cells[4].innerHTML = placaVehiculoSegPer.toUpperCase();
    selectedRowSegVehPer.cells[5].innerHTML = usoVehiculoSegPer.toUpperCase();
    selectedRowSegVehPer.cells[6].innerHTML = (document.getElementById('involucrado_robado2').checked) ?  'ROBADO'  : 'INVOLUCRADO';
    selectedRowSegVehPer.cells[7].innerHTML = caracteristicasVehiculoSegPer.toUpperCase();
    document.getElementById('alertEditVehiculoSP').style.display = 'none';

}

const readFormSegVehPer = (campos) => {
    let formData = {}
    for (let i = 0; i < campos.length; i++) {
        if(campos[i] === 'involucrado_robado2'){
            (document.getElementById('involucrado_robado2').checked) ? formData[campos[i]] = 'ROBADO'  : formData[campos[i]] = 'INVOLUCRADO';
        }else{
            formData[campos[i]] = document.getElementById(campos[i]).value;
        }
    }
    return formData;
}

const resetFormSegVehPer = (campos) => {
    for (let i = 0; i < campos.length; i++) {
        document.getElementById(campos[i]).value = '';
    }
    selectedRowSegVehPer = null;
}

/* ----- ----- ----- Funciones reutilizables ----- ----- ----- */

const deleteRow = (obj, tableId) => {
    if (confirm('¿Desea eliminar este elemento?')) {
        const row = obj.parentElement.parentElement;
        document.getElementById(tableId.id).deleteRow(row.rowIndex);
    }
}

const validateFormVehiculos = (campos) => {
    let isValid = true;
    for (i = 0; i < campos.length; i++) {
        if (campos[i] === 'marcaVehiculoSegPer') {
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