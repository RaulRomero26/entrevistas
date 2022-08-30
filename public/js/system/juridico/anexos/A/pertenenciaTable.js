/*------------------------FORM VALIDATOR------------------------*/
let FV = new FormValidator();
/*------------------------CONTADORES PERTENENCIAS------------------------*/
let numPert = 1;
/*------------------------------BUTTONS------------------------------*/
//boton agregar pertenencia
let addPertBtn = document.getElementById("id_btn_add_pert");
addPertBtn.addEventListener("click", addPertenencia);
let editPertBtn = document.getElementById("id_btn_edit_pert");
editPertBtn.addEventListener("click", editCampos);
let cancelPertBtn = document.getElementById("id_btn_cancel_pert");
cancelPertBtn.addEventListener("click", cancelEditPertenencia);

/*--------------------------CAMPOS PERTENENCIA--------------------------*/
//campos de pertenencia
let pertenencia = document.getElementById("id_pertenencia");
let breveDesc = document.getElementById("id_descripcion");
let destino = document.getElementById("id_destino");
/*--------------------------CAMPOS HIDDEN--------------------------*/
let inputPertenenciaHidden = document.getElementById('id_pertenencia_edit');
/*--------------------------TABLAS--------------------------*/
//tabla pertenencia
let pertenenciaTable = document.getElementById("id_tbody_pertenencias");
/*-----------------------FORM ARRAY PERTENENCIAS-----------------------*/
let pertenenciaArray = new Array();
/*-----------------------ALARMS-----------------------*/
//edit alarm
let editAlarm = document.getElementById('id_edit_p_mode');
let errorAlarm = document.getElementById('id_error_p_mode');

/*-----------------------FUNCTIONS-----------------------*/
//agregar pertenencia a la tabla
function addPertenencia() {

    //se validan los campos
    const success = validaPertForm();
    if (success) {
        //se crea row nuevo
        let row = pertenenciaTable.insertRow(pertenenciaTable.rows.length);
        row.id = "auxPer_" + numPert;

        pertenenciaArray.push({
            Id: numPert,
            Pertenencia: pertenencia.value.toUpperCase(),
            Descripcion: breveDesc.value.toUpperCase(),
            Destino: destino.value.toUpperCase()
        })

        //se agrega la info a la tabla
        row.insertCell(0).innerHTML = `${pertenencia.value.toUpperCase()}`;
        row.insertCell(1).innerHTML = `${breveDesc.value.toUpperCase()}`;
        row.insertCell(2).innerHTML = `${destino.value.toUpperCase()}`;
        let auxOp = row.insertCell(3);
        auxOp.className = 'sticky_field';
        auxOp.innerHTML = createHtmlOperaciones(numPert);

        limpiarPertenenciaCampos();
        numPert++;
        //se oculta alert danger error por si esta activo
        errorAlarm.classList.add('mi_hide');

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

    }



}
//borrar registro de la tabla
function deleteRowPertenencia(id_row) {
    let elem = document.getElementById("auxPer_" + id_row);
    elem.parentNode.removeChild(elem);
    pertenenciaArray = pertenenciaArray.filter(per => per.Id !== id_row);
    if (pertenenciaArray.length <= 0)
        errorAlarm.classList.remove('mi_hide');

    limpiarPertenenciaCampos();
    editPertBtn.classList.add('mi_hide');
    cancelPertBtn.classList.add('mi_hide');
    addPertBtn.classList.remove('mi_hide');
    editAlarm.classList.add('mi_hide');


}
//editar registro de la tabla
function editRowPertenencia(id_row) {
    //se asigna la persona buscada desde el array de personas
    const perAuxArray = pertenenciaArray.find(per => per.Id === id_row);
    pertenencia.value = perAuxArray.Pertenencia;
    breveDesc.value = perAuxArray.Descripcion;
    destino.value = perAuxArray.Destino;

    editAlarm.classList.remove('mi_hide');
    editPertBtn.classList.remove('mi_hide');
    cancelPertBtn.classList.remove('mi_hide');
    addPertBtn.classList.add('mi_hide');
    //se cambia el id aux de persona editada
    inputPertenenciaHidden.value = id_row;
}
//editar campos
function editCampos() {
    //id de persona editando
    const id_persona = inputPertenenciaHidden.value
        // console.log(`id: ${id_persona}`);
        //se valida el form de persona
    const success = validaPertForm();
    //se cambia el valor en la tabla de personas
    if (success) {
        let elem = document.getElementById("auxPer_" + id_persona);
        elem.cells[0].innerHTML = `${pertenencia.value.toUpperCase()}`;
        elem.cells[1].innerHTML = `${breveDesc.value.toUpperCase()}`;
        elem.cells[2].innerHTML = `${destino.value.toUpperCase()}`;

        pertenenciaArray.forEach(elem => {
            if (elem.Id == id_persona) {
                elem.Pertenencia = pertenencia.value.toUpperCase();
                elem.Descripcion = breveDesc.value.toUpperCase();
                elem.Destino = destino.value.toUpperCase();
            }
        });

        //ocultar y mostrar respectivos buttons
        editAlarm.classList.add('mi_hide');
        editPertBtn.classList.add('mi_hide');
        cancelPertBtn.classList.add('mi_hide');
        addPertBtn.classList.remove('mi_hide');
        inputPertenenciaHidden.value = '-1';
        limpiarPertenenciaCampos();



    }
}

function cancelEditPertenencia() {
    limpiarPertenenciaCampos();
    editPertBtn.classList.add('mi_hide');
    cancelPertBtn.classList.add('mi_hide');
    addPertBtn.classList.remove('mi_hide');
    editAlarm.classList.add('mi_hide');
}

//crear los botones dinámicamente de editar y borrar para cada row
function createHtmlOperaciones(id_row) {
    // console.log(id_row);
    return `
        <button type="button" id="id_button1_${id_row}" class="btn btn-sm mi-btn-edit" data-toggle="tooltip" data-placement="bottom" title="Editar registro" onclick="editRowPertenencia(${id_row})">
            <i class="material-icons v-a-middle">edit</i>
        </button>
                
        <button type="button" id="id_button2_${id_row}" class="btn btn-sm mi-btn-delete" data-toggle="tooltip" data-placement="bottom" title="Borrar registro" onclick="deleteRowPertenencia(${id_row})">
            <i class="material-icons v-a-middle">delete</i>
        </button>
       
    `;
}

//función para validar campos
const validaPertForm = () => {
    //validaciones para agregar nueva persona
    let ind = 0;
    let band = []; //banderas success
    band[ind++] = error_pertenencia.textContent = FV.validate(pertenencia.value, "required | max_length[250]");
    band[ind++] = error_descripcion.textContent = FV.validate(breveDesc.value, "required | max_length[250]");
    band[ind++] = error_destino.textContent = FV.validate(destino.value, "required | max_length[250]");

    //se comprueban todas las validaciones
    let success = true;
    band.forEach((element) => {
        success &= element == "" ? true : false;
    })

    return success;
}

const limpiarPertenenciaCampos = () => {
    pertenencia.value = "";
    breveDesc.value = "";
    destino.value = "";
}

const vaciarTablaPertenencias = () => {
    pertenenciaTable.innerHTML = "";
}