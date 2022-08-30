const observacionesError = document.getElementById('observacionesElementos_error'),
    primerElementosError = document.getElementById('primerElementos_error'),
    inputsElementos = document.getElementById('inputsElementos_error'),
    policiaGuardiaError = document.getElementById('policiaDeGuardia_error'),
    msg_elementosParticipantesError = document.getElementById('msg_elementosParticipantes'),
    no_remision_elemento = document.getElementById('no_remision_elementosParticipantes'),
    //----------------Elementos del DOM
    observacionesElementosParticipantes = document.getElementById('observacionesElementos'),
    guardia = document.getElementById('policiaDeGuardia'),
    dataElementos = document.getElementById('data_elementos');

document.getElementById('btn_elementos').addEventListener('click', async(e) => {

    e.preventDefault();

    const button = document.getElementById('btn_elementos');

    let myFormData = new FormData(dataElementos),
        band = [],
        FV = new FormValidator(),
        i = 0;

    band[i++] = policiaGuardiaError.innerText = FV.validate(myFormData.get('policiaDeGuardia'), 'required');

    if (readTableElementos().length === 0) {
        primerElementosError.innerHTML = 'Se requiere de un primer respondiente';
        msg_elementosParticipantesError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario.</div>'
        window.scroll({
            top: 0,
            left: 100,
            behavior: 'smooth'
        });
        return;
    } else {
        primerElementosError.innerHTML = '';
    }

    let success = true;

    band.forEach(element => {
        success &= (element == '') ? true : false;
    });

    const input = validateInputsTables(['nombreElemento', 'noControlElemento', 'placaElemento', 'unidadElemento', 'cargoElemento', 'grupoElemento']);
    if (!input) {
        inputsElementos.innerHTML = 'No se a agregado el registro a la tabla';
        msg_elementosParticipantesError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario.</div>'
        window.scroll({
            top: 0,
            left: 100,
            behavior: 'smooth'
        });
        return;
    }

    const result = await getTabValidado(3);
    if(!result){
        success = false;
    }

    if (success) {

        button.innerHTML = `
            Guardando
            <div class="spinner-grow spinner-grow-sm" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        `;
        button.classList.add('disabled-link');

        const narrativa = document.getElementById('narrativaElementos')

        myFormData.append('elementos_participantes', document.getElementById('btn_elementos').value);
        myFormData.append('elementos_table', JSON.stringify(readTableElementos()));
        myFormData.append('remision', no_remision_elemento.value);
        myFormData.append('narrativaElementos', narrativa.value);

        fetch(base_url + 'updateElementosParticipantes', {
                method: 'POST',
                body: myFormData
            })
            .then(res => res.json())
            .then(data => {
                button.innerHTML = `
                Guardar
            `;
                button.classList.remove('disabled-link');
                if (!data.status) {
                    console.log(data)
                    observacionesError.innerText = (data.observacionesError === undefined) ? '' : data.observacionesError;
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

                    msg_elementosParticipantesError.innerHTML = messageError
                    window.scroll({
                        top: 0,
                        left: 100,
                        behavior: 'smooth'
                    });

                } else {
                    msg_elementosParticipantesError.innerHTML = '<div class="alert alert-success text-center" role="alert">Información guardada con éxito.</div>'
                    window.scroll({
                        top: 0,
                        left: 100,
                        behavior: 'smooth'
                    });
                    getTabsGuardados();
                    // result.tab === '1' ? '' : document.getElementById('save-tab-3').style.display = 'block';
                }
            })
    } else {
        msg_elementosParticipantesError.innerHTML = '<div class="alert alert-danger text-center" role="alert">Por favor, revisa nuevamente el formulario</div>'
        window.scroll({
            top: 0,
            left: 100,
            behavior: 'smooth'
        });
    }

});

const validateInputsTables = (campos) => {

    let isValid = true;

    for (i = 0; i < campos.length; i++) {
        if (document.getElementById(campos[i]).value != "") {
            isValid = false;
        }
    }

    return isValid;

}

const readTableElementos = () => {
    const table = document.getElementById('elementosParticipantes'),
        radio = document.getElementsByName('primerRespondienteCheck');


    let elementos = [],
        band = false;

    for (let i = 0; i < radio.length; i++) {
        if (radio[i].checked) {
            band = true;
            break;
        }
    }

    if (band) {
        for (let i = 1; i < table.rows.length; i++) {

            let check = table.rows[i].cells[2].getElementsByTagName('input')[0];

            elementos.push({
                ['row']: {
                    nombre: table.rows[i].cells[0].innerHTML,
                    noControl: table.rows[i].cells[1].innerHTML,
                    respondiente: check.checked ? true : false,
                    enColaboracion: (table.rows[i].cells[6].childNodes[3] != undefined) ? true : false,
                    segGPS: 0,
                    placa: table.rows[i].cells[3].innerHTML,
                    unidad: table.rows[i].cells[4].innerHTML,
                    cargo: table.rows[i].cells[5].innerHTML,
                    grupo: table.rows[i].cells[6].childNodes[1].innerHTML
                }
            });
        }

        elementos.push({
            ['row']: {
                nombre: document.getElementById('policiaDeGuardia').value,
                noControl: '',
                enColaboracion: false,
                segGPS: 0,
                respondiente: false,
                placa: '',
                unidad: '',
                cargo: 'policiaDeGuardiaElementos',
                grupo: ''
            }
        });
    }

    return elementos;
}

const getElementosParticipantes = () => {

    var myFormData = new FormData()
    myFormData.append('no_remision', no_remision_elemento.value)

    fetch(base_url + 'getElementosParticipantes', {
        method: 'POST',
        body: myFormData
    })

    .then(res => res.json())

    .then(data => {

        const rowsTable = data.elementos_participantes;
        for (let i = 0; i < rowsTable.length; i++) {
            let formData = {
                nombreElemento: rowsTable[i].Nombre,
                noControlElemento: rowsTable[i].No_Control,
                placaElemento: rowsTable[i].Placa,
                unidadElemento: (rowsTable[i].No_Unidad != null) ? rowsTable[i].No_Unidad : '',
                cargoElemento: rowsTable[i].Cargo,
                grupoElemento: rowsTable[i].Sector_Area,
            };
            insertNewRowElemento(formData, rowsTable[i].Tipo_Llamado);
        }

        guardia.value = (data.guardia.Nombre === undefined) ? '' : data.guardia.Nombre.toUpperCase();

        /* (data.guardia.Seguimiento_GPS === '1') ? document.getElementById('seguimientoGPS').checked = true: ''; */



        observacionesElementosParticipantes.value = (data.observaciones.Observaciones === undefined || data.observaciones.Observaciones === null) ? '' : data.observaciones.Observaciones.toUpperCase();

    })
}

const buttonSearch = document.getElementById('button_search'),
    elementSearch = document.getElementById('element_search'),
    listElementsSearch = document.getElementById('list_elements_search'),
    inputsElements = [
        {
            key: 'fullname',
            value: 'nombreElemento'
        },
        {
            key: 'cargo',
            value: 'cargoElemento'
        },
        {
            key: 'unidad',
            value: 'unidadElemento'
        },
        {
            key: 'control',
            value: 'noControlElemento'
        },
        {
            key: 'button',
            value: 'button_search'
        },
        {
            key: 'search',
            value: 'element_search'
        },
        {
            key: 'content',
            value: 'list_elements_search'
        }
    ];

buttonSearch.addEventListener('click', ()=>{
    buttonSearch.innerText = `Buscando`;
    buttonSearch.setAttribute('disabled', '');
    getPrimerRespondiente(elementSearch.value, inputsElements);
})

elementSearch.addEventListener('keypress', (e)=>{
    if(e.key === 'Enter'){
        buttonSearch.innerText = `Buscando`;
        buttonSearch.setAttribute('disabled', '');
        getPrimerRespondiente(elementSearch.value, inputsElements);
    }
})

const buttonSearch_2 = document.getElementById('button_search_2'),
    elementSearch_2 = document.getElementById('element_search_2'),
    listElementsSearch_2 = document.getElementById('list_elements_search_2'),
    inputsElements_2 = [
        {
            key: 'fullname',
            value: 'policiaDeGuardia'
        },
        {
            key: 'button',
            value: 'button_search_2'
        },
        {
            key: 'search',
            value: 'element_search_2'
        },
        {
            key: 'content',
            value: 'list_elements_search_2'
        }
    ];

buttonSearch_2.addEventListener('click', ()=>{
    buttonSearch_2.innerText = `Buscando`;
    buttonSearch_2.setAttribute('disabled', '');
    getPrimerRespondiente(elementSearch_2.value, inputsElements_2);
})

elementSearch_2.addEventListener('keypress', (e)=>{
    if(e.key === 'Enter'){
        buttonSearch_2.innerText = `Buscando`;
        buttonSearch_2.setAttribute('disabled', '');
        getPrimerRespondiente(elementSearch_2.value, inputsElements_2);
    }
})