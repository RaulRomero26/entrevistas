/* ----- ----- ----- Tabla de detenidos ----- ----- ----- */

let selectedRowPersonal = null;

document.getElementById('btn-add-personal').addEventListener('click', () => {


    const campos = ['Nombre_PLI', 'Ap_Paterno_PLI', 'Ap_Materno_PLI', 'Cargo', 'Institucion'];
    if (validateFormPersonal(campos)) {
        let formData = readFormPersonal(campos);
        if (selectedRowPersonal === null)
            insertNewRowPersonal(formData);
        else
            updateRowDetenido(formData);

        resetFormPersonal(campos);
    }

})

const insertNewRowPersonal = ({ Nombre_PLI, Ap_Paterno_PLI, Ap_Materno_PLI, Cargo, Institucion }, type) => {

    const table = document.getElementById('elementos_intervencion').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);

    newRow.insertCell(0).innerHTML = Nombre_PLI.toUpperCase();
    newRow.insertCell(1).innerHTML = Ap_Paterno_PLI.toUpperCase();
    newRow.insertCell(2).innerHTML = Ap_Materno_PLI.toUpperCase();
    newRow.insertCell(3).innerHTML = Cargo.toUpperCase();
    newRow.insertCell(4).innerHTML = Institucion.toUpperCase();
    if (type != 'view') {
        newRow.insertCell(5).innerHTML = `<button class="btn btn-primary action_row" onclick="editDetenido(this)"> 
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
        </button>`;
        newRow.insertCell(6).innerHTML = `<input type="button" class="btn btn-primary action_row" value="-" onclick="deleteRow(this,elementos_intervencion)">`;
    }
}

const editDetenido = (obj) => {

    document.getElementById('alertEditPersonal').style.display = 'block';

    selectedRowPersonal = obj.parentElement.parentElement;

    const campos = ['Nombre_PLI', 'Ap_Paterno_PLI', 'Ap_Materno_PLI', 'Cargo', 'Institucion'];

    campos.forEach((elem, i) => {
        document.getElementById(elem).value = selectedRowPersonal.cells[i].innerHTML;
    });

}

const updateRowDetenido = ({ Nombre_PLI, Ap_Paterno_PLI, Ap_Materno_PLI, Cargo, Institucion }) => {

    selectedRowPersonal.cells[0].innerHTML = Nombre_PLI.toUpperCase();
    selectedRowPersonal.cells[1].innerHTML = Ap_Paterno_PLI.toUpperCase();
    selectedRowPersonal.cells[2].innerHTML = Ap_Materno_PLI.toUpperCase();
    selectedRowPersonal.cells[3].innerHTML = Cargo.toUpperCase();
    selectedRowPersonal.cells[4].innerHTML = Institucion.toUpperCase();
    document.getElementById('alertEditPersonal').style.display = 'none';

}

const readFormPersonal = (campos) => {
    let formData = {}
    for (let i = 0; i < campos.length; i++) {
        formData[campos[i]] = document.getElementById(campos[i]).value;
    }
    return formData;
}

const resetFormPersonal = (campos) => {
    for (let i = 0; i < campos.length; i++) {
        document.getElementById(campos[i]).value = '';
    }
    selectedRowPersonal = null;
}

/* ----- ----- ----- Funciones reutilizables ----- ----- ----- */

const deleteRow = (obj, tableId) => {
    if (confirm('¿Desea eliminar este elemento?')) {
        const row = obj.parentElement.parentElement;
        document.getElementById(tableId.id).deleteRow(row.rowIndex);

    }
}

const validateFormPersonal = (campos) => {
    let isValid = true;
    for (i = 0; i < campos.length; i++) {
        if (document.getElementById(campos[i]).value === "") {
            isValid = false;
            document.getElementById(campos[i] + '_error').innerText = 'Campo requerido';
        } else {
            document.getElementById(campos[i] + '_error').innerText = '';
        }
    }
    return isValid;
}

const readTablePersonal = () => {
    const table = document.getElementById('elementos_intervencion');

    let Personal = [];

    for (let i = 1; i < table.rows.length; i++) {
        Personal.push({
            ['row']: {
                Nombre_PLI: table.rows[i].cells[0].innerHTML,
                Ap_Paterno_PLI: table.rows[i].cells[1].innerHTML,
                Ap_Materno_PLI: table.rows[i].cells[2].innerHTML,
                Cargo: table.rows[i].cells[3].innerHTML,
                Institucion: table.rows[i].cells[4].innerHTML,
            }
        });
    }

    return Personal;
}