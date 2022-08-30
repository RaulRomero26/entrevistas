/* ----- ----- ----- Eventos Armas recuperadas ----- ----- ----- */
let selectedRowArmas = null;


//DivMapa.style.cssText = 'display: none !important';

const onFormArmaSubmit = () => {

    const campos = ['tipoArma', 'cantidadArmas', 'descripcionArmas'];

    if (validateFormArma(campos)) {
        let formData = readFormArma(campos);
        if (selectedRowArmas === null)
            insertNewRowArma(formData);
        else
            updateRowArma(formData);

        resetFormArma(campos);
    }

}

const insertNewRowArma = ({ tipoArma, cantidadArmas, descripcionArmas }, type) => {

    const table = document.getElementById('armasRecuperadas').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);

    newRow.insertCell(0).innerHTML = tipoArma;
    newRow.insertCell(1).innerHTML = cantidadArmas;
    newRow.insertCell(2).innerHTML = descripcionArmas.toUpperCase();
    if (type === undefined) {
        newRow.insertCell(3).innerHTML = `<button type="button" class="btn btn-primary" onclick="editArma(this)"> 
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
        </button>`;
        newRow.insertCell(4).innerHTML = `<input type="button" class="btn btn-primary" value="-" onclick="deleteRow(this,armasRecuperadas)">`;
    }

}

const editArma = (obj) => {

    const campos = ['tipoArma', 'cantidadArmas', 'descripcionArmas'];

    document.getElementById('alertEditArma').style.display = 'block';

    selectedRowArmas = obj.parentElement.parentElement;
    for (let i = 0; i < campos.length; i++) {
        document.getElementById(campos[i]).value = selectedRowArmas.cells[i].innerHTML;
    }
}

const updateRowArma = (data) => {

    for (dataKey in data) {
        let i = Object.keys(data).indexOf(dataKey);
        selectedRowArmas.cells[i].innerHTML = data[dataKey].toUpperCase();
    }

    document.getElementById('alertEditArma').style.display = 'none';

}

const readFormArma = (campos) => {

    let formData = {}
    for (let i = 0; i < campos.length; i++) {
        formData[campos[i]] = document.getElementById(campos[i]).value;
    }

    return formData;

}

const resetFormArma = (campos) => {

    for (let i = 0; i < campos.length; i++) {
        document.getElementById(campos[i]).value = '';
    }

    selectedRowArmas = null;

}

const validateFormArma = (campos) => {

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
/* ----- ----- ----- Eventos vehiculos recuperados 
Estos eventos incluyen agregar renglones a la tabla de vehiculos, verificar y actualizar cada renglon agregado, leer la tabla,
limpiar los campos del vehiculo y llenarla por primera vez, en las funciones:
onFormVehiculoSubmit, updateRowVehiculo, readFormVehiculo, resetFormVehiculo, validateFormVehiculo, insertNewRowVehiculo y editVehiculo
Ademas de rellenar los selectores para submarca, marca y tipo de vehiculo.
----- ----- ----- */
let selectedRowVehiculo = null;
/*Añadido para los selectores de marca, agregando los elementos que
contiene la tabla catalogo_marca_vehiculos_io*/
const insertMarcasVehiculos= (marcas) => {
    select_m=document.getElementById("Marca");
    for (i = 0; i < marcas.length; i++) {
        let opt = document.createElement('option');
        opt.value = marcas[i]['Marca'].toUpperCase();
        opt.innerHTML = marcas[i]['Marca'].toUpperCase();;
        select_m.appendChild(opt);
    }
}
/*Añadido para los selectores de tipo de vehiculo, agregando los elementos que
contiene la tabla catalogo_tipos_vehiculos*/
const insertTiposVehiculos= (tipos) => {
    select_m=document.getElementById("Tipo_Vehiculo");
    for (i = 0; i < tipos.length; i++) {
        let opt = document.createElement('option');
        opt.value = tipos[i]['Tipo'].toUpperCase();
        opt.innerHTML = tipos[i]['Tipo'].toUpperCase();;
        select_m.appendChild(opt);
    }
}
/*Añadido para los selectores de submarca de vehiculo, agregando los elementos que
contiene la tabla catalogo_submarcas_vehiculos*/
const insertSubmarcaVehiculos= (submarca) => {
    select_m=document.getElementById("Submarca");
    for (i = 0; i < submarca.length; i++) {
        let opt = document.createElement('option');
        opt.value = submarca[i]['Submarca'].toUpperCase();
        opt.innerHTML = submarca[i]['Submarca'].toUpperCase();;
        select_m.appendChild(opt);
    }
}
/*se añade el campo de submarca*/
const onFormVehiculoSubmit = () => {
    const campos = ['Tipo_Situacion_0', 'Tipo_Situacion_1','Submarca', 'Tipo_Vehiculo', 'Placa_Vehiculo','Marca','Modelo','Color','Senia_Particular','No_Serie','Procedencia_Vehiculo','Observacion_Vehiculo'];
    const campos2 = ['Tipo_Situacion_0','Tipo_Vehiculo', 'Placa_Vehiculo','Marca','Submarca','Modelo','Color','Senia_Particular','No_Serie','Procedencia_Vehiculo','Observacion_Vehiculo'];
    if (validateFormVehiculo(campos)) {
        let formData = readFormVehiculo(campos2);
        if (selectedRowVehiculo === null)
            insertNewRowVehiculo(formData);
        else
            updateRowVehiculo(formData);
        resetFormVehiculo(campos);
    }
}
const updateRowVehiculo = (data) => {
    let j=0;
    for (dataKey in data) {
        if (j<1){
            let i = Object.keys(data).indexOf(dataKey);
            selectedRowVehiculo.cells[0].innerHTML = document.getElementById('Tipo_Situacion_0').checked === true ? "Recuperado" : "Involucrado";
        }
        else{
            let i = Object.keys(data).indexOf(dataKey);
            selectedRowVehiculo.cells[i].innerHTML = data[dataKey].toUpperCase();
        }
        j++;    
    }
    document.getElementById('alertEditVehiculo').style.display = 'none';
}
const readFormVehiculo = (campos) => {

    let formData = {}
    formData[campos[0]] = document.getElementById(campos[0]).checked;
    for (let i = 1; i < campos.length; i++) {
        formData[campos[i]] = document.getElementById(campos[i]).value;
    }
    return formData;

}

const resetFormVehiculo = (campos) => {
    document.getElementById('Tipo_Situacion_0').checked=false;
    document.getElementById('Tipo_Situacion_1').checked=false;
    for (let i = 2; i < campos.length; i++) {
        document.getElementById(campos[i]).value = '';
    }

    selectedRowVehiculo = null;

}

const validateFormVehiculo = (campos) => {

    let isValid = true;
    if (document.getElementById('Tipo_Situacion_0').checked || document.getElementById('Tipo_Situacion_1').checked) {
        document.getElementById('Tipo_Situacion-invalid').style.display = 'none';
    } else {
        isValid = false;
        document.getElementById('Tipo_Situacion-invalid').style.display = 'block';
    }
    for (i = 2; i < campos.length; i++) {
        if (document.getElementById(campos[i]).value === "") {
            isValid = false;
            document.getElementById(campos[i] + '-invalid').style.display = 'block';
        } else {
            document.getElementById(campos[i] + '-invalid').style.display = 'none';
        }
    }
    return isValid;
}
/*se añade el campo de submarca*/
const insertNewRowVehiculo = ({ Tipo_Situacion_0, Submarca, Tipo_Vehiculo, Placa_Vehiculo, Marca,Modelo,Color,Senia_Particular,No_Serie,Procedencia_Vehiculo,Observacion_Vehiculo }, type) => {
    const table = document.getElementById('vehiculosRecuperados').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);
    newRow.insertCell(0).innerHTML = Tipo_Situacion_0 === true ? "Recuperado" : "Involucrado";
    newRow.insertCell(1).innerHTML = Tipo_Vehiculo;
    newRow.insertCell(2).innerHTML = Placa_Vehiculo;
    newRow.insertCell(3).innerHTML = Marca;
    newRow.insertCell(4).innerHTML = Submarca;
    newRow.insertCell(5).innerHTML = Modelo;
    newRow.insertCell(6).innerHTML = Color;
    newRow.insertCell(7).innerHTML = Senia_Particular;
    newRow.insertCell(8).innerHTML = No_Serie;
    newRow.insertCell(9).innerHTML = Procedencia_Vehiculo;
    newRow.insertCell(10).innerHTML = Observacion_Vehiculo;
    if (type === undefined) {
        newRow.insertCell(11).innerHTML = `<button type="button" class="btn btn-primary" onclick="editVehiculo(this)"> 
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
        </button>`;
        newRow.insertCell(12).innerHTML = `<input type="button" class="btn btn-primary" value="-" onclick="deleteRow(this,vehiculosRecuperados)">`;
    }

}
const editVehiculo = (obj) => {

/*se añade el campo de submarca*/
const campos = ['Tipo_Situacion_0', 'Tipo_Situacion_1','Tipo_Vehiculo', 'Placa_Vehiculo','Marca','Submarca','Modelo','Color','Senia_Particular','No_Serie','Procedencia_Vehiculo','Observacion_Vehiculo'];
    selectedRowVehiculo = obj.parentElement.parentElement;
    document.getElementById('alertEditVehiculo').style.display = 'block';
    if (selectedRowVehiculo.cells[0].innerHTML=="Recuperado"){
        document.getElementById('Tipo_Situacion_0').checked = true;
    }
    else{
        document.getElementById('Tipo_Situacion_1').checked = true;
    }
    
    for (let i = 2; i < campos.length; i++) {
        document.getElementById(campos[i]).value = selectedRowVehiculo.cells[i-1].innerHTML;
    }
}
/* ----- ----- ----- Eventos droga recuperada ----- ----- ----- */
let selectedRowDrogas = null;

const onFormDrogaSubmit = () => {

    const campos = ['tipoDroga', 'cantidadDroga', 'unidadDroga', 'descripcionDroga'];

    if (validateFormDroga(campos)) {
        let formData = readFormDroga(campos);
        if (selectedRowDrogas === null)
            insertNewRowDroga(formData);
        else
            updateRowDroga(formData);

        resetFormDroga(campos);
    }
}

const insertNewRowDroga = ({ tipoDroga, cantidadDroga, unidadDroga, descripcionDroga }, type) => {

    const table = document.getElementById('drogasAseguradas').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);

    newRow.insertCell(0).innerHTML = tipoDroga;
    newRow.insertCell(1).innerHTML = cantidadDroga;
    newRow.insertCell(2).innerHTML = unidadDroga;
    newRow.insertCell(3).innerHTML = descripcionDroga.toUpperCase();
    if (type === undefined) {
        newRow.insertCell(4).innerHTML = `<button type="button" class="btn btn-primary" onclick="editDroga(this)"> 
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
        </button>`;
        newRow.insertCell(5).innerHTML = `<input type="button" class="btn btn-primary" value="-" onclick="deleteRow(this,drogasAseguradas)">`;
    }

}

const editDroga = (obj) => {

    const campos = ['tipoDroga', 'cantidadDroga', 'unidadDroga', 'descripcionDroga'];

    document.getElementById('alertEditDroga').style.display = 'block';

    selectedRowDrogas = obj.parentElement.parentElement;
    for (let i = 0; i < campos.length; i++) {
        document.getElementById(campos[i]).value = selectedRowDrogas.cells[i].innerHTML;
    }

}

const updateRowDroga = (data) => {

    for (dataKey in data) {
        let i = Object.keys(data).indexOf(dataKey);
        selectedRowDrogas.cells[i].innerHTML = data[dataKey].toUpperCase();
    }

    document.getElementById('alertEditDroga').style.display = 'none';

}

const readFormDroga = (campos) => {

    let formData = {}
    for (let i = 0; i < campos.length; i++) {
        formData[campos[i]] = document.getElementById(campos[i]).value;
    }

    return formData;

}

const resetFormDroga = (campos) => {

    for (let i = 0; i < campos.length; i++) {
        document.getElementById(campos[i]).value = '';
    }

    selectedRowDrogas = null;

}

const validateFormDroga = (campos) => {

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

/* ----- ----- ----- Eventos objetos recuperados ----- ----- ----- */
let selectedRowOtros = null;

const onFormOtroSubmit = () => {

    const campos = ['descripcionOtros'];

    if (validateFormOtro(campos)) {
        let formData = readFormOtros(campos);
        if (selectedRowOtros === null)
            insertNewRowOtro(formData);
        else
            updateRowOtro(formData);

        resetFormOtros(campos);
    }

}

const insertNewRowOtro = ({ descripcionOtros }, type) => {

    const table = document.getElementById('objetosAsegurados').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);

    newRow.insertCell(0).innerHTML = descripcionOtros.toUpperCase();
    if (type === undefined) {
        newRow.insertCell(1).innerHTML = `<button type="button" class="btn btn-primary" onclick="editOtro(this)"> 
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
        </button>`;
        newRow.insertCell(2).innerHTML = `<input type="button" class="btn btn-primary" value="-" onclick="deleteRow(this,objetosAsegurados)">`;
    }

}

const editOtro = (obj) => {

    const campos = ['descripcionOtros'];

    document.getElementById('alertEditObjeto').style.display = 'block';

    selectedRowOtros = obj.parentElement.parentElement;
    for (let i = 0; i < campos.length; i++) {
        document.getElementById(campos[i]).value = selectedRowOtros.cells[i].innerHTML;
    }

}

const updateRowOtro = (data) => {

    for (dataKey in data) {
        let i = Object.keys(data).indexOf(dataKey);
        selectedRowOtros.cells[i].innerHTML = data[dataKey].toUpperCase();
    }

    document.getElementById('alertEditObjeto').style.display = 'none';

}

const readFormOtros = (campos) => {

    let formData = {}
    for (let i = 0; i < campos.length; i++) {
        formData[campos[i]] = document.getElementById(campos[i]).value;
    }

    return formData;

}

const resetFormOtros = (campos) => {

    for (let i = 0; i < campos.length; i++) {
        document.getElementById(campos[i]).value = '';
    }
    selectedRowOtros = null;

}

const validateFormOtro = (campos) => {

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

/* ----- ----- ----- Funciones reutilizables ----- ----- ----- */

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