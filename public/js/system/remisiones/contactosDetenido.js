/* ----- ----- -----
Archivo nuevo que gestiona las funciones de la tabla de contactos conocidos
todas estan funciones son analogas a las originales destinadas
a las tablas de armas, objetos y drogas.
Solo cambia los nombres de los campos.
-------------------*/
let selectedRowContacto = null;

const onFormContactoSubmit = () => {
    const campos = ['parentezco_conocido', 'Nombre_conocido', 'apaterno_conocido','amaterno_conocido','telefono_conocido','edad_conocido','sexo_conocido'];

    if (validateFormContacto(campos)) {
        let formData = readFormContacto(campos);
        if (selectedRowContacto === null)
            insertNewRowContacto(formData);
        else
            updateRowContacto(formData);

        resetFormContacto(campos);
    }

}

const insertNewRowContacto = ({ parentezco_conocido, Nombre_conocido, apaterno_conocido, amaterno_conocido,telefono_conocido,edad_conocido,sexo_conocido}, type) => {

    const table = document.getElementById('informacionConocidos').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);

    newRow.insertCell(0).innerHTML = parentezco_conocido;
    newRow.insertCell(1).innerHTML = Nombre_conocido;
    newRow.insertCell(2).innerHTML = apaterno_conocido;
    newRow.insertCell(3).innerHTML = amaterno_conocido;
    newRow.insertCell(4).innerHTML = telefono_conocido;
    newRow.insertCell(5).innerHTML = edad_conocido;
    newRow.insertCell(6).innerHTML = sexo_conocido.toUpperCase() === "H" ? "HOMBRE" : "MUJER";
    if (type === undefined) {
        newRow.insertCell(7).innerHTML = `<button type="button" class="btn btn-primary" onclick="editContacto(this)"> 
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
        </button>`;
        newRow.insertCell(8).innerHTML = `<input type="button" class="btn btn-primary" value="-" onclick="deleteRow(this,informacionConocidos)">`;
    }

}

const editContacto = (obj) => {
    const campos = ['parentezco_conocido', 'Nombre_conocido', 'apaterno_conocido','amaterno_conocido','telefono_conocido','edad_conocido','sexo_conocido'];

    document.getElementById('alertEditContacto').style.display = 'block';

    selectedRowContacto = obj.parentElement.parentElement;
    for (let i = 0; i < campos.length; i++) {
        document.getElementById(campos[i]).value = selectedRowContacto.cells[i].innerHTML;
    }
}

const updateRowContacto = (data) => {
    for (dataKey in data) {
        let i = Object.keys(data).indexOf(dataKey);
        selectedRowContacto.cells[i].innerHTML = data[dataKey].toUpperCase();
    }

    document.getElementById('alertEditContacto').style.display = 'none';

}

const readFormContacto = (campos) => {
    let formData = {}
    for (let i = 0; i < campos.length; i++) {
        formData[campos[i]] = document.getElementById(campos[i]).value;
    }

    return formData;

}

const resetFormContacto = (campos) => {
    for (let i = 0; i < campos.length; i++) {
        document.getElementById(campos[i]).value = '';
    }

    selectedRowContacto = null;

}

const validateFormContacto = (campos) => {
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