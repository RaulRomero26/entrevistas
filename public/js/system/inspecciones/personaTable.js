/*------------------------FORM VALIDATOR------------------------*/
let FV = new FormValidator();
/*------------------------CONTADORES PERSONAS------------------------*/
let numPersonas = 1;
/*------------------------------BUTTONS------------------------------*/
//boton agregar persona
let addPersonBtn = document.getElementById("id_add_persona");
addPersonBtn.addEventListener("click", addPersona);
let editPersonBtn = document.getElementById('id_edit_persona');
editPersonBtn.addEventListener("click", editCampos);
let cancelEditPersonBtn = document.getElementById('id_cancelar_edit_per');
cancelEditPersonBtn.addEventListener("click", cancelEditPersona);
/*--------------------------CAMPOS PERSONA--------------------------*/
//campos de persona
let nombreP = document.getElementById("id_nombre");
let appPaternoP = document.getElementById("id_ap_paterno");
let appMaternoP = document.getElementById("id_ap_materno");
let aliasP = document.getElementById("id_alias");
let fechaNacimientoP = document.getElementById("id_fecha_nacimiento");
/*--------------------------CAMPOS HIDDEN--------------------------*/
let inputPersonaHidden = document.getElementById('id_persona_aux_edit');
/*--------------------------TABLAS--------------------------*/
//tabla personas
let personaTable = document.getElementById("id_tbody_persona");
/*-----------------------FORM ARRAY PERSONAS-----------------------*/
let personasArray = new Array();
/*-----------------------ALARMS-----------------------*/
//edit alarm
let editAlarm = document.getElementById('id_edit_p_mode');

/*-----------------------FUNCTIONS-----------------------*/
//agregar persona a la tabla
function addPersona() {

    //se validan los campos
    const success = validaPersonaForm();
    if (success) {
        //se crea row nuevo
        let row = personaTable.insertRow(personaTable.rows.length);
        row.id = "auxPer_" + numPersonas;

        // console.log(row.id);

        personasArray.push({
                Id: numPersonas,
                Nombre: nombreP.value.toUpperCase(),
                Ap_Paterno: appPaternoP.value.toUpperCase(),
                Ap_Materno: appMaternoP.value.toUpperCase(),
                Alias: aliasP.value.toUpperCase(),
                Fecha_Nacimiento: fechaNacimientoP.value
            })
            //se agrega la info a la tabla
        row.insertCell(0).innerHTML = `${nombreP.value.toUpperCase()} ${appPaternoP.value.toUpperCase()} ${appMaternoP.value.toUpperCase()}`;
        row.insertCell(1).innerHTML = `${aliasP.value.toUpperCase()}`;
        row.insertCell(2).innerHTML = `${fechaNacimientoP.value}`;
        let auxOp = row.insertCell(3);
        auxOp.className = 'sticky_field';
        auxOp.innerHTML = createHtmlOperaciones(numPersonas);

        limpiarPersonaCampos();
        numPersonas++;
        //se oculta alert danger error por si esta activo
        document.getElementById('id_error_p_mode').classList.add('mi_hide');
        // console.log(personasArray);
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

    }



}
//borrar registro de la tabla
function deleteRowPersona(id_row) {
    let elem = document.getElementById("auxPer_" + id_row);
    elem.parentNode.removeChild(elem);
    personasArray = personasArray.filter(per => per.Id !== id_row);
    if (personasArray.length <= 0)
        document.getElementById('id_error_p_mode').classList.remove('mi_hide');

    limpiarPersonaCampos();
    editPersonBtn.classList.add('mi_hide');
    cancelEditPersonBtn.classList.add('mi_hide');
    addPersonBtn.classList.remove('mi_hide');
    editAlarm.classList.add('mi_hide');
}
//editar registro de la tabla
function editRowPersona(id_row) {
    //se asigna la persona buscada desde el array de personas
    const perAuxArray = personasArray.find(per => per.Id === id_row);
    nombreP.value = perAuxArray.Nombre;
    appPaternoP.value = perAuxArray.Ap_Paterno;
    appMaternoP.value = perAuxArray.Ap_Materno;
    aliasP.value = perAuxArray.Alias;
    fechaNacimientoP.value = perAuxArray.Fecha_Nacimiento;
    editAlarm.classList.remove('mi_hide');
    editPersonBtn.classList.remove('mi_hide');
    cancelEditPersonBtn.classList.remove('mi_hide');
    addPersonBtn.classList.add('mi_hide');
    //se cambia el id aux de persona editada
    document.getElementById('id_persona_edit').value = id_row;
}
//editar campos
function editCampos() {
    //id de persona editando
    const id_persona = document.getElementById('id_persona_edit').value
        // console.log(`id: ${id_persona}`);
        //se valida el form de persona
    const success = validaPersonaForm();
    //se cambia el valor en la tabla de personas
    if (success) {
        let elem = document.getElementById("auxPer_" + id_persona);
        elem.cells[0].innerHTML = `${nombreP.value.toUpperCase()} ${appPaternoP.value.toUpperCase()} ${appMaternoP.value.toUpperCase()}`;
        elem.cells[1].innerHTML = `${aliasP.value.toUpperCase()}`;
        elem.cells[2].innerHTML = `${fechaNacimientoP.value}`;

        personasArray.forEach(elem => {
            if (elem.Id == id_persona) {
                elem.Nombre = nombreP.value.toUpperCase();
                elem.Ap_Paterno = appPaternoP.value.toUpperCase();
                elem.Ap_Materno = appMaternoP.value.toUpperCase();
                elem.Alias = aliasP.value.toUpperCase();
                elem.Fecha_Nacimiento = fechaNacimientoP.value;
            }
        });
        // console.log(personasArray);
        //ocultar y mostrar respectivos buttons
        editAlarm.classList.add('mi_hide');
        editPersonBtn.classList.add('mi_hide');
        cancelEditPersonBtn.classList.add('mi_hide');
        addPersonBtn.classList.remove('mi_hide');
        document.getElementById('id_persona_edit').value = '-1';
        limpiarPersonaCampos();

    }
}

function cancelEditPersona() {
    limpiarPersonaCampos();
    editPersonBtn.classList.add('mi_hide');
    cancelEditPersonBtn.classList.add('mi_hide');
    addPersonBtn.classList.remove('mi_hide');
    editAlarm.classList.add('mi_hide');
}

//crear los botones dinámicamente de editar y borrar para cada row
function createHtmlOperaciones(id_row) {
    // console.log(id_row);
    return `
        <button type="button" class="btn btn-sm mi-btn-edit" data-toggle="tooltip" data-placement="bottom" title="Editar registro" onclick="editRowPersona(${id_row})">
            <i class="material-icons v-a-middle">edit</i>
        </button>
                
        <button type="button" class="btn btn-sm mi-btn-delete" data-toggle="tooltip" data-placement="bottom" title="Borrar registro" onclick="deleteRowPersona(${id_row})">
            <i class="material-icons v-a-middle">delete</i>
        </button>
       
    `;
}

//función para validar campos
const validaPersonaForm = () => {
    //validaciones para agregar nueva persona
    let ind = 0;
    let band = []; //banderas success
    band[ind++] = error_nombre.textContent = FV.validate(nombreP.value, "required | max_length[100]");
    band[ind++] = error_ap_paterno.textContent = FV.validate(appPaternoP.value, "required | max_length[100]");
    band[ind++] = error_ap_materno.textContent = FV.validate(appMaternoP.value, "required | max_length[100]");
    band[ind++] = error_alias.textContent = FV.validate(aliasP.value, "required | max_length[100]");

    //se comprueban todas las validaciones
    let success = true;
    band.forEach((element) => {
        success &= element == "" ? true : false;
    })

    return success;
}

const limpiarPersonaCampos = () => {
    nombreP.value = "";
    appPaternoP.value = "";
    appMaternoP.value = "";
    aliasP.value = "";
    fechaNacimientoP.value = "";
}

const vaciarTablaPersonas = () => {
    personaTable.innerHTML = "";
}