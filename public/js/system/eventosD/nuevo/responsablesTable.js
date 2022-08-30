/* ----- ----- ----- Tabla de detenidos ----- ----- ----- */

let selectedRowResponsables = null;

document.getElementById('btn_add_element').addEventListener('click', () => {
    const campos = ['no_remision_table', 'nombre_table', 'edad_table', 'sexo_table'];
    if (validateFormResponsables(campos)) {
        let formData = readFormResponsables(campos);
        if (selectedRowResponsables === null)
            insertNewRowResponsable(formData);
        else
            updateRowResponsables(formData);

        resetFormResponsables(campos);
    }

})

const insertNewRowResponsable = ({ no_remision_table, nombre_table, edad_table, sexo_table }) => {

    const table = document.getElementById('responsables_table').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);

    newRow.insertCell(0).innerHTML = no_remision_table.toUpperCase();
    newRow.insertCell(1).innerHTML = nombre_table.toUpperCase();
    newRow.insertCell(2).innerHTML = edad_table.toUpperCase();
    newRow.insertCell(3).innerHTML = sexo_table.toUpperCase();
    newRow.insertCell(4).innerHTML = `<button class="btn btn-primary action_row" onclick="editResponsable(this)"> 
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
        </svg>
    </button>`;
    newRow.insertCell(5).innerHTML = `<input type="button" class="btn btn-primary action_row" value="-" onclick="deleteRow(this,responsables_table)">`;
}

const editResponsable = (obj) => {

    document.getElementById('msg_table').innerHTML = `
        <div class="alert alert-warning text-center" role="alert">
            Está editando una falta / delito
        </div>
    `;
    
    selectedRowResponsables = obj.parentElement.parentElement;

    const campos = ['no_remision_table', 'nombre_table', 'edad_table', 'sexo_table'];
    
    campos.forEach((elem, i) => {
        document.getElementById(elem).value = selectedRowResponsables.cells[i].innerHTML;
    });

}

const updateRowResponsables = ({ no_remision_table, nombre_table, edad_table, sexo_table}) => {
    
    selectedRowResponsables.cells[0].innerHTML = no_remision_table;
    selectedRowResponsables.cells[1].innerHTML = nombre_table.toUpperCase();
    selectedRowResponsables.cells[2].innerHTML = edad_table;
    selectedRowResponsables.cells[3].innerHTML = sexo_table;

    document.getElementById('msg_table').innerHTML = '';

}

const readFormResponsables = (campos) => {
    let formData = {}
    for (let i = 0; i < campos.length; i++) {
        formData[campos[i]] = document.getElementById(campos[i]).value;
    }
    return formData;
}

const resetFormResponsables = (campos) => {
    for (let i = 0; i < campos.length; i++) {
        if(campos[i] != 'sexo_table'){
            document.getElementById(campos[i]).value = '';
        }
    }
    selectedRowResponsables = null;
}

/* ----- ----- ----- Funciones reutilizables ----- ----- ----- */

const deleteRow = (obj, tableId) => {
    if (confirm('¿Desea eliminar este elemento?')) {
        const row = obj.parentElement.parentElement;
        document.getElementById(tableId.id).deleteRow(row.rowIndex);

    }
}

const validateFormResponsables = (campos) => {
    let isValid = true;

    campos.forEach(elem=>{
        if(elem === 'sexo_table'){
            if(document.getElementById(elem).value === ''){
                document.getElementById(`${elem}_error`).innerText = 'Compo requerido';
                isValid = false;
            }else{
                document.getElementById(`${elem}_error`).innerText = '';
            }
        }
    });

    return isValid;
}

const readTableDetenidos = ()=>{
    const table = document.getElementById('tableDetenidos');

    let detenidos = [];

    for(let i = 1; i<table.rows.length; i++){
        detenidos.push({
            ['row']:{
                nombre: table.rows[i].cells[0].innerHTML,
                primerApellido: table.rows[i].cells[1].innerHTML,
                segundoApellido: table.rows[i].cells[2].innerHTML,
                fecha: table.rows[i].cells[3].innerHTML,
                edad: table.rows[i].cells[4].innerHTML,
                sexo: table.rows[i].cells[5].innerHTML,
            }
        });
    }

    return detenidos;
}