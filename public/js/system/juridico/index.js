const btn = document.getElementById('btn-search-element'),
    input = document.getElementById('input-search-element'),
    data = document.getElementById('data_elemento'),
    error = document.getElementById('error-search-element'),
    numControl = document.getElementById('numControl'),
    placaElemento = document.getElementById('placaElemento'),
    unidadElemento = document.getElementById('unidadElemento'),
    cargoElemento = document.getElementById('cargoElemento'),
    adscripcionElemento = document.getElementById('adscripcionElemento'),
    fieldsets = document.getElementsByTagName('fieldset'),
    btn_fielsets = document.getElementsByClassName('btn-fieldset'),
    huboDetenidos = document.getElementsByName('huboDetenidos'),
    nombreElemento = document.getElementById('nombreElemento'),
    primerApellidoElemento = document.getElementById('primerApellidoElemento'),
    segundoApellidoElemento = document.getElementById('segundoApellidoElemento'),
    formManual = document.getElementById('formManual'),
    formManualContent = document.getElementById('formManualContent'),
    anoDetenido = document.getElementById('anoDetenido');

btn.addEventListener('click', (e) => {
    getElemento();
});

input.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        getElemento();
    }
})

anoDetenido.addEventListener('input', ()=>{
    let hoy = new Date()
    let fechaNacimiento = new Date(anoDetenido.value)
    let edad = hoy.getFullYear() - fechaNacimiento.getFullYear()
    let diferenciaMeses = hoy.getMonth() - fechaNacimiento.getMonth()
    if (
        diferenciaMeses < 0 ||
        (diferenciaMeses === 0 && hoy.getDate() < fechaNacimiento.getDate())
    ) {
        edad--
    }
    document.getElementById('edadDetenido').value = edad;
})

const getElemento = () => {
    btn.innerText = `Buscando`;
    btn.setAttribute('disabled', '');
    let myFormData = new FormData(data),
        band = [],
        FV = new FormValidator(),
        i = 0,
        succes = true;

    band[i++] = error.innerText = FV.validate(myFormData.get('input-search-element'), 'required');

    band.forEach(elem => {
        succes &= (elem == '') ? true : false;
    })

    if (succes) {
        fetch(base_url_js + 'BuscarPolicia', {
                method: 'POST',
                body: myFormData
            })
            .then(res => res.json())
            .then(data => {
                btn.innerText = 'Buscar';
                btn.removeAttribute('disabled');
                if (!data.status) {
                    error.innerText = data.error_message;
                } else {
                    if ((data.res).length > 1) {
                        document.getElementById('list-group-elementos').style.display = 'block';
                        document.getElementById('list-group-elementos-label').style.display = 'block';
                        document.getElementById('content-elementos').style.display = 'none';
                        document.getElementById('list-group-elementos').innerHTML = '';
                        numControl.setAttribute('readonly', '');
                        nombreElemento.setAttribute('readonly', '');
                        primerApellidoElemento.setAttribute('readonly', '');
                        segundoApellidoElemento.setAttribute('readonly', '');
                        cargoElemento.setAttribute('readonly', '');
                        data.res.forEach((element,i)=>{
                            if(i<4){
                                document.getElementById('list-group-elementos').innerHTML += `<div class="list-group-item list-group-item-action py-1" onclick="addElementForm('${element.Paterno}','${element.Materno}', '${element.Nombre}','${element.No_ControlMunicipio}', '${element.No_PlacaPolicia}', '${element.TipoEmpleado}', '${element.AdscripCom}')">${decode_utf8(element.Paterno)} ${decode_utf8(element.Materno)} ${decode_utf8(element.Nombre)}</div>`;
                            }
                        });
                    } else {
                        document.getElementById('content-elementos').style.display = 'block';
                        document.getElementById('btn-continuar-fieldset').style.display = 'block';
                        document.getElementById('list-group-elementos').style.display = 'none';
                        document.getElementById('list-group-elementos-label').style.display = 'none';
                        numControl.setAttribute('readonly', '');
                        nombreElemento.setAttribute('readonly', '');
                        primerApellidoElemento.setAttribute('readonly', '');
                        segundoApellidoElemento.setAttribute('readonly', '');
                        cargoElemento.setAttribute('readonly', '');
                        let cargo = '';
                        switch (data.res[0].TipoEmpleado) {
                            case 'M':
                                cargo = 'MUNICIPAL'
                                break;
                            case 'P':
                                cargo = 'POLICIA'
                                break;
                            case 'V':
                                cargo = 'VIALIDAD'
                                break;
                        }
                        numControl.value = data.res[0].No_ControlMunicipio;
                        nombreElemento.value = decode_utf8(data.res[0].Nombre);
                        primerApellidoElemento.value = decode_utf8(data.res[0].Paterno);
                        segundoApellidoElemento.value = decode_utf8(data.res[0].Materno);
                        placaElemento.value = data.res[0].No_PlacaPolicia;
                        unidadElemento.value = "";
                        cargoElemento.value = decode_utf8(cargo);
                        adscripcionElemento.value = data.res[0].AdscripCom;
                    }
                }
            })
    } else {
        btn.innerText = 'Buscar';
        btn.removeAttribute('disabled');
    }
}

const addElementForm = (paterno, materno, nombre, noControl, placa, TipoEmpleado, AdscripCom)=>{
    document.getElementById('content-elementos').style.display = 'block';
    document.getElementById('btn-continuar-fieldset').style.display = 'block';
    document.getElementById('list-group-elementos').style.display = 'none';
    document.getElementById('list-group-elementos-label').style.display = 'none';
    let cargo = '';
    switch (TipoEmpleado) {
        case 'M':
            cargo = 'MUNICIPAL'
            break;
        case 'P':
            cargo = 'POLICIA'
            break;
        case 'V':
            cargo = 'VIALIDAD'
            break;
    }
    numControl.value = noControl;
    nombreElemento.value = decode_utf8(nombre);
    primerApellidoElemento.value = decode_utf8(paterno);
    segundoApellidoElemento.value = decode_utf8(materno);
    placaElemento.value = placa;
    unidadElemento.value = "";
    cargoElemento.value = decode_utf8(cargo);
    adscripcionElemento.value = AdscripCom;
}

formManual.addEventListener('change', ()=>{
    if(formManual.checked){
        document.getElementById('content-elementos').style.display = 'block';
        document.getElementById('btn-continuar-fieldset').style.display = 'block';
        numControl.removeAttribute('readonly');
        nombreElemento.removeAttribute('readonly');
        primerApellidoElemento.removeAttribute('readonly');
        segundoApellidoElemento.removeAttribute('readonly');
        cargoElemento.removeAttribute('readonly');
    }else{
        document.getElementById('content-elementos').style.display = 'none';
        document.getElementById('btn-continuar-fieldset').style.display = 'none';
        numControl.setAttribute('readonly', '');
        nombreElemento.setAttribute('readonly', '');
        primerApellidoElemento.setAttribute('readonly', '');
        segundoApellidoElemento.setAttribute('readonly', '');
        cargoElemento.setAttribute('readonly', '');
    }
});

for (let i = 0; i < btn_fielsets.length; i++) {
    btn_fielsets[i].addEventListener('click', () => {
        const form = document.getElementById('content-elementos');
        let accion = btn_fielsets[i].innerText;
        switch (accion) {
            case 'Cancelar':
                $('#nuevaRegistroJuridico').modal('hide');
                break;
            case 'Continuar':
                let band = [],
                    FV = new FormValidator(),
                    j = 0,
                    myFormData = new FormData(form);
                band[j++] = document.getElementById('error-nombreElemento').innerText = FV.validate(myFormData.get('nombreElemento'), 'required');
                band[j++] = document.getElementById('error-primerApellidoElemento').innerText = FV.validate(myFormData.get('primerApellidoElemento'), 'required');
                band[j++] = document.getElementById('error-segundoApellidoElemento').innerText = FV.validate(myFormData.get('segundoApellidoElemento'), 'required');
                band[j++] = document.getElementById('error-numControl').innerText = FV.validate(myFormData.get('numControl'), 'required');
                band[j++] = document.getElementById('error-cargoElemento').innerText = FV.validate(myFormData.get('cargoElemento'), 'required');
                let success = true
                band.forEach(element => {
                    success &= (element == '') ? true : false
                });
                if(success){
                    fieldsets[0].style.display = 'none';
                    fieldsets[1].style.display = 'block';
                    formManualContent.style.display = 'none';
                    document.getElementById('data_elemento').style.display = 'none';
                    document.getElementById('btn-cancelar-fieldset').innerText = 'Anterior';
                    document.getElementById('btn-continuar-fieldset').innerText = 'Guardar';
                    document.getElementById('title-fieldset').innerText = 'Paso 2: Listar detenido(s)';
                }
            break;
            case 'Anterior':
                fieldsets[0].style.display = 'block';
                fieldsets[1].style.display = 'none';
                formManualContent.style.display = 'block';
                document.getElementById('data_elemento').style.display = 'block';
                document.getElementById('btn-cancelar-fieldset').innerText = 'Cancelar';
                document.getElementById('btn-continuar-fieldset').innerText = 'Continuar';
                document.getElementById('title-fieldset').innerText = 'Paso 1: Buscar elemento';
                break;
            case 'Guardar':
                let band2 = [],
                    FV2 = new FormValidator(),
                    k = 0,
                    myFormData2 = new FormData(form);
                band2[k++] = document.getElementById('error-nombreElemento').innerText = FV2.validate(myFormData2.get('nombreElemento'), 'required');
                band2[k++] = document.getElementById('error-primerApellidoElemento').innerText = FV2.validate(myFormData2.get('primerApellidoElemento'), 'required');
                band2[k++] = document.getElementById('error-segundoApellidoElemento').innerText = FV2.validate(myFormData2.get('segundoApellidoElemento'), 'required');
                band2[k++] = document.getElementById('error-numControl').innerText = FV2.validate(myFormData2.get('numControl'), 'required');
                band2[k++] = document.getElementById('error-cargoElemento').innerText = FV2.validate(myFormData2.get('cargoElemento'), 'required');
                let success2 = true;
                band2.forEach(element => {
                    success2 &= (element == '') ? true : false
                });
                if(success2){
                    if (fieldsets[1].style.display === 'block') {
                        const input = validateInputsTables(['nombreDetenido', 'primerApellidoDetenido', 'segundoApellidoDetenido', 'edadDetenido', 'sexoDetenido']);
                        if (!input) {
                            document.getElementById('error-tableDetenidos').innerText = 'No se a agregado el registro a la tabla';
                            return;
                        }

                        if(document.getElementById('tableDetenidos').rows.length <= 1){
                            document.getElementById('error-tableDetenidos').innerText = 'No se a agregado ningún detenido';
                            return;
                        }

                    }
                    
                    if(fieldsets[0].style.display === '' || fieldsets[0].style.display === 'block'){
                        if(!window.confirm('Creará una puesta sin detenido, ¿está seguro?')){
                            return;
                        }
                    }

                    const buttonSave = btn_fielsets[1],
                        buttonPrev = btn_fielsets[0],
                        msg_puestaError = document.getElementById('msg_puestaError');
                    
                    buttonSave.innerHTML = `
                        Guardando
                        <div class="spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    `;
                    buttonSave.classList.add('disabled-link');
                    buttonPrev.classList.add('disabled-link');
                    myFormData2.append('btn_save', buttonSave.value);
                    myFormData2.append('detenidos', JSON.stringify(readTableDetenidos()));

                    fetch(base_url_js+'Juridico/crearPuesta',{
                        method: 'POST',
                        body: myFormData2
                    })
                    .then(res=>res.json())
                    .then(data=>{
                        
                        if (!data.status) {
                            buttonSave.innerHTML = `
                                Guardar
                            `;
                            buttonSave.classList.remove('disabled-link');
                            buttonPrev.classList.remove('disabled-link');
                            let messageError;
                            if ('error_message' in data) {
                                if (data.error_message != 'Render Index') {
                                    if (typeof(data.error_message) != 'string') {
                                        messageError = `<div class="alert alert-danger text-center" role="alert">Sucedio un error en el servidor: ${data.error_message.errorInfo[2]}</div>`;
                                    } else {
                                        messageError = `<div class="alert alert-danger text-center" role="alert">Sucedio un error en el servidor: ${data.error_message}</div>`;
                                    }
                                } else {
                                    messageError = `<div class="alert alert-danger text-center alert-session-create" role="alert">
                                            <p>Sucedio un error, su sesión caduco o no tiene los permisos necesarios. Por favor vuelva a iniciar sesión.</p>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalLogin">
                                                Iniciar sesión
                                            </button>
                                        </div>`;
                                }
                            } else {
                                messageError = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>'
                            }

                            msg_puestaError.innerHTML = messageError
                            window.scroll({
                                top: 0,
                                left: 100,
                                behavior: 'smooth'
                            });
                        }else{
                            msg_puestaError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información almacenada correctamente. En breve será redirigido a la versión completa del IPH</div>';

                            buttonPrev.style.display = 'none';
                            buttonSave.style.display = 'none';

                            setInterval(function() { window.location = base_url_js + 'Juridico/Puesta/'+data.id_puesta}, 3000);
                        }
                    });
                }
            break;
        }
    })
}

for (let i = 0; i < huboDetenidos.length; i++) {
    huboDetenidos[i].addEventListener('click', () => {
        if (huboDetenidos[i].value === 'true') {
            document.getElementById('btn-continuar-fieldset').innerText = 'Continuar';
        } else {
            document.getElementById('btn-continuar-fieldset').innerText = 'Guardar';
        }
    })
}

const validateInputsTables = (campos) => {

    let isValid = true;

    for (i = 0; i < campos.length; i++) {
        if (document.getElementById(campos[i]).value != "") {
            isValid = false;
        }
    }

    return isValid;

}


/* ----- ----- ----- Tabla de detenidos ----- ----- ----- */

let selectedRowDetenidos = null;

document.getElementById('btn-add-detenido').addEventListener('click', () => {

    const campos = ['nombreDetenido', 'primerApellidoDetenido', 'segundoApellidoDetenido', 'anoDetenido', 'edadDetenido', 'sexoDetenido'];
    if (validateFormDetenidos(campos)) {
        let formData = readFormDetenidos(campos);
        if (selectedRowDetenidos === null)
            insertNewRowDetenidos(formData);
        else
            updateRowDetenido(formData);

        resetFormDetenidos(campos);
    }

})

const insertNewRowDetenidos = ({ nombreDetenido, primerApellidoDetenido, segundoApellidoDetenido, anoDetenido, edadDetenido, sexoDetenido }, type) => {

    const table = document.getElementById('tableDetenidos').getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.length);

    newRow.insertCell(0).innerHTML = nombreDetenido;
    newRow.insertCell(1).innerHTML = primerApellidoDetenido;
    newRow.insertCell(2).innerHTML = segundoApellidoDetenido;
    newRow.insertCell(3).innerHTML = anoDetenido;
    newRow.insertCell(4).innerHTML = edadDetenido;
    newRow.insertCell(5).innerHTML = sexoDetenido;
    if (type != 'view') {
        newRow.insertCell(6).innerHTML = `<button class="btn btn-primary" onclick="editDetenido(this)"> 
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
        </button>`;
        newRow.insertCell(7).innerHTML = `<input type="button" class="btn btn-primary" value="-" onclick="deleteRow(this,tableDetenidos)">`;
    }
}

const editDetenido = (obj) => {

    document.getElementById('alertEditDetenidos').style.display = 'block';

    selectedRowDetenidos = obj.parentElement.parentElement;

    const campos = ['nombreDetenido', 'primerApellidoDetenido', 'segundoApellidoDetenido', 'anoDetenido', 'edadDetenido', 'sexoDetenido'];

    campos.forEach((elem, i) => {
        document.getElementById(elem).value = selectedRowDetenidos.cells[i].innerHTML;
    });

}

const updateRowDetenido = ({ nombreDetenido, primerApellidoDetenido, segundoApellidoDetenido, edadDetenido, sexoDetenido }) => {

    selectedRowDetenidos.cells[0].innerHTML = nombreDetenido.toUpperCase();
    selectedRowDetenidos.cells[1].innerHTML = primerApellidoDetenido.toUpperCase();
    selectedRowDetenidos.cells[2].innerHTML = segundoApellidoDetenido.toUpperCase();
    selectedRowDetenidos.cells[3].innerHTML = anoDetenido.value;
    selectedRowDetenidos.cells[4].innerHTML = edadDetenido.toUpperCase();
    selectedRowDetenidos.cells[5].innerHTML = sexoDetenido.toUpperCase();
    document.getElementById('alertEditDetenidos').style.display = 'none';

}

const readFormDetenidos = (campos) => {
    let formData = {}
    for (let i = 0; i < campos.length; i++) {
        formData[campos[i]] = document.getElementById(campos[i]).value;
    }
    return formData;
}

const resetFormDetenidos = (campos) => {
    for (let i = 0; i < campos.length; i++) {
        document.getElementById(campos[i]).value = '';
    }
    selectedRowDetenidos = null;
}

/* ----- ----- ----- Funciones reutilizables ----- ----- ----- */

const deleteRow = (obj, tableId) => {
    if (confirm('¿Desea eliminar este elemento?')) {
        const row = obj.parentElement.parentElement;
        document.getElementById(tableId.id).deleteRow(row.rowIndex);

    }
}

const validateFormDetenidos = (campos) => {
    let isValid = true;
    for (i = 0; i < campos.length; i++) {
        if (document.getElementById(campos[i]).value === "" && campos[i] != 'anoDetenido') {
            isValid = false;
            document.getElementById('error-' + campos[i]).innerText = 'Campo requerido';
        } else {
            document.getElementById('error-' + campos[i]).innerText = '';
        }
    }
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


/*-----------------JS PARA FILTRADO Y BÚSQUEDA-----------------*/
/*-------------------------------------------------------------*/
/*-------------------------------------------------------------*/
/*-------------------------------------------------------------*/
$(function() {
    $('[data-toggle="tooltip"]').tooltip()
    $('[data-toggle="popover"]').popover()
})

var search = document.getElementById('id_search')
var filtroActual = document.getElementById('filtroActual')
var search_button = document.getElementById('search_button')


search_button.addEventListener('click', buscarJuridicoCad)

function buscarJuridicoCad(e) {
    var myform = new FormData()
    myform.append("cadena", search.value)
    myform.append("filtroActual", filtroActual.value)
        /*la direción relativa con Fetch es con base en la url actual por eso se coloca ../ vamos a una rama abajo de la URL*/
    fetch(base_url_js + 'Juridico/buscarPorCadena', {
            method: 'POST',
            body: myform
        })
        .then(function(response) {
            if (response.ok) {
                return response.json()
            } else {
                throw "Error en la llamada Ajax";
            }
        })
        .then(function(myJson) {
            if (!(typeof(myJson) == 'string')) {
                document.getElementById('id_tbody').innerHTML = myJson.infoTable.body
                document.getElementById('id_thead').innerHTML = myJson.infoTable.header
                document.getElementById('id_pagination').innerHTML = myJson.links
                document.getElementById('id_link_excel').href = myJson.export_links.excel
                document.getElementById('id_link_pdf').href = myJson.export_links.pdf
                document.getElementById('id_total_rows').innerHTML = myJson.total_rows
                document.getElementById('id_dropdownColumns').innerHTML = myJson.dropdownColumns
                var columnsNames3 = document.querySelectorAll('th')
                columnsNames3.forEach(function(element, index, array) {
                    if (element.className.match(/column.*/))
                        hideShowColumn(element.className)
                });
                $('[data-toggle="tooltip"]').tooltip()
                $('[data-toggle="popover"]').popover()
            } else {
                console.log("myJson: " + myJson)
            }

        })
        .catch(function(error) {
            console.log("Error desde Catch _  " + error)
        })

}

function checarCadena(e) {
    if ((search.value == "") || (event.keyCode == '13')) {
        buscarJuridicoCad()
    }
}

function aplicarRangos() {
    //obtener cada valor de la fecha
    var rango_inicio = document.getElementById('id_date_1').value
    var rango_fin = document.getElementById('id_date_2').value
        //comprobar si ya seleccionó una fecha
    if (rango_inicio != '' && rango_fin != '') {
        let fecha1 = new Date(rango_inicio);
        let fecha2 = new Date(rango_fin)

        let resta = fecha2.getTime() - fecha1.getTime()
        if (resta >= 0) { //comprobar si los rangos de fechas son correctos
            document.getElementById('form_rangos').submit()
        } else {
            //caso de elegir rangos erroneos
            alert("Elige intervalos correctos")
        }
    } else {
        //caso de no ingresar aún nada
        alert("Selecciona primero los rangos")
    }
}

function hideShowColumn(col_name) {

    var myform = new FormData() //form para actualizar la session variable
    myform.append('columName', col_name) //se asigna el nombre de la columna a cambiar

    var checkbox_val = document.getElementById(col_name).value;
    if (checkbox_val == "hide") {
        var all_col = document.getElementsByClassName(col_name);
        for (var i = 0; i < all_col.length; i++) {
            all_col[i].style.display = "none";
        }
        document.getElementById(col_name).value = "show";
        myform.append('valueColumn', 'hide') //se asigna la acción (hide or show)
    } else {
        var all_col = document.getElementsByClassName(col_name);
        for (var i = 0; i < all_col.length; i++) {
            all_col[i].style.display = "table-cell";
        }
        document.getElementById(col_name).value = "hide";
        myform.append('valueColumn', 'show') //se asigna la acción (hide or show)
    }
    //se actualiza la session var para las columnas cambiadas
    fetch(base_url_js + 'Inspecciones/setColumnFetch', {
            method: 'POST',
            body: myform
        })
        .then(function(response) {
            if (response.ok) {
                return response.json()
            } else {
                throw "Error en la llamada fetch"
            }
        })
        .then(function(myJson) {
            //console.log(myJson)
        })
        .catch(function(error) {
            console.log("catch: " + error)
        })
}

function hideShowAll() {
    const valueCheckAll = document.getElementById('checkAll').value //valor actual del check todos
    var checkBoxes = document.querySelectorAll('.checkColumns') //se obtiene los checks de las columnas del filtro actual
        //se convierte todo a hide o todo a show ademas de desmarcar o marcar todos los checked
    if (valueCheckAll === 'hide') {
        checkBoxes.forEach(function(element, index, array) {
            if (element.value = 'show') {
                element.value = 'hide'
                element.checked = false
            }
        })
        document.getElementById('checkAll').value = 'show'
    } else {
        checkBoxes.forEach(function(element, index, array) {
            if (element.value = 'hide') {
                element.value = 'show'
                element.checked = true
            }
        })
        document.getElementById('checkAll').value = 'hide'
    }

    //se procede a mostrar u ocultar todo
    var columnsNames = document.querySelectorAll('th')
    columnsNames.forEach(function(element, index, array) {
        if (element.className.match(/column.*/))
            hideShowColumn(element.className)
    });
}

var columnsNames2 = document.querySelectorAll('th')
columnsNames2.forEach(function(element, index, array) {
    if (element.className.match(/column.*/))
        hideShowColumn(element.className)
});

/*-----------------FIN JS PARA FILTRADO Y BÚSQUEDA-----------------*/